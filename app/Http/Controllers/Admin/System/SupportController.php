<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageReplyMail;
use App\Models\NewsletterSubscriber;
use App\Models\System\ContactMessage;
use App\Models\System\SupportTicket;
use App\Models\System\SupportTicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'messages');

        $messagesQuery = ContactMessage::query();
        if ($priority = $request->get('priority')) {
            $messagesQuery->where('priority', $priority);
        }
        if ($search = $request->get('msg_search')) {
            $messagesQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('subject', 'like', "%{$search}%");
            });
        }
        $messages = $messagesQuery->where('is_archived', false)->latest()->paginate(7, ['*'], 'messages_page')->withQueryString();

        $tickets = SupportTicket::latest()->get();
        $selectedTicket = null;
        if ($ticketId = $request->get('ticket')) {
            $selectedTicket = SupportTicket::with('messages')->find($ticketId);
        }
        $selectedTicket ??= $tickets->first() ? SupportTicket::with('messages')->find($tickets->first()->id) : null;

        $ticketStats = [
            'open' => SupportTicket::where('status', 'open')->count(),
            'pending' => SupportTicket::where('status', 'pending')->count(),
            'resolved' => SupportTicket::where('status', 'resolved')->count(),
            'closed' => SupportTicket::where('status', 'closed')->count(),
        ];

        $subscribersQuery = NewsletterSubscriber::query();
        if ($subStatus = $request->get('sub_status')) {
            $subscribersQuery->where('status', $subStatus);
        }
        if ($subSearch = $request->get('sub_search')) {
            $subscribersQuery->where('email', 'like', "%{$subSearch}%");
        }
        $subscribers = $subscribersQuery->latest('joined_date')->paginate(10, ['*'], 'subscribers_page')->withQueryString();
        $subscriberStats = [
            'total' => NewsletterSubscriber::count(),
            'active' => NewsletterSubscriber::active()->count(),
        ];

        return view('admin.system.support.index', compact(
            'tab', 'messages', 'tickets', 'selectedTicket', 'ticketStats', 'subscribers', 'subscriberStats'
        ));
    }

    public function replyMessage(Request $request, ContactMessage $message)
    {
        $data = $request->validate([
            'reply_body' => 'required|string',
        ]);

        $message->update([
            'reply_body' => $data['reply_body'],
            'replied_at' => now(),
            'is_read' => true,
        ]);

        try {
            Mail::to($message->email)->send(new ContactMessageReplyMail($message));
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', "Reply saved, but the email to {$message->email} failed to send. Check the SMTP/Resend settings.");
        }

        return back()->with('success', "Reply sent to {$message->email}.");
    }

    public function toggleReadMessage(ContactMessage $message)
    {
        $message->update(['is_read' => !$message->is_read]);

        return back()->with('success', 'Message updated.');
    }

    public function archiveMessage(ContactMessage $message)
    {
        $message->update(['is_archived' => true]);

        return back()->with('success', 'Message archived.');
    }

    public function destroyMessage(Request $request, ContactMessage $message)
    {
        abort_unless($request->user()->hasPermission('delete-contact-messages'), 403);

        $message->delete();

        return back()->with('success', 'Message deleted.');
    }

    public function bulkDestroyMessages(Request $request)
    {
        abort_unless($request->user()->hasPermission('delete-contact-messages'), 403);

        $data = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contact_messages,id',
        ]);

        ContactMessage::whereIn('id', $data['ids'])->delete();

        return back()->with('success', count($data['ids']).' message(s) deleted.');
    }

    public function replyTicket(Request $request, SupportTicket $ticket)
    {
        $data = $request->validate([
            'body' => 'required|string',
            'status' => 'required|in:open,pending,resolved,closed',
        ]);

        SupportTicketMessage::create([
            'ticket_id' => $ticket->id,
            'sender_type' => 'admin',
            'sender_name' => auth()->user()->full_name ?? 'Admin',
            'is_internal_note' => false,
            'body' => $data['body'],
        ]);

        $ticket->update(['status' => $data['status']]);

        return back()->with('success', 'Reply sent.');
    }

    public function destroyTicket(Request $request, SupportTicket $ticket)
    {
        abort_unless($request->user()->hasPermission('delete-support-tickets'), 403);

        $ticket->delete();

        return redirect()->route('admin.system.support.index', ['tab' => 'tickets'])->with('success', 'Ticket deleted.');
    }

    public function bulkDestroyTickets(Request $request)
    {
        abort_unless($request->user()->hasPermission('delete-support-tickets'), 403);

        $data = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:support_tickets,id',
        ]);

        SupportTicket::whereIn('id', $data['ids'])->delete();

        return redirect()->route('admin.system.support.index', ['tab' => 'tickets'])->with('success', count($data['ids']).' ticket(s) deleted.');
    }

    public function destroySubscriber(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();

        return back()->with('success', 'Subscriber removed.');
    }

    public function bulkDestroySubscribers(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:newsletter_subscribers,id',
        ]);

        NewsletterSubscriber::whereIn('id', $request->ids)->delete();

        return back()->with('success', count($request->ids).' subscribers removed.');
    }
}
