<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\ContactConfirmation;
use App\Mail\ContactNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'service' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Store contact in database
            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'service' => $request->service,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'new'
            ]);

            Log::info('Contact saved successfully', ['contact_id' => $contact->id]);

            // Test email configuration first
            $emailsSent = 0;
            $errors = [];

            // Send confirmation email to the user
            try {
                Mail::to($request->email)->send(new ContactConfirmation($contact));
                $emailsSent++;
                Log::info('Confirmation email sent successfully', ['to' => $request->email]);
            } catch (\Exception $e) {
                $errors[] = 'Confirmation email failed: ' . $e->getMessage();
                Log::error('Confirmation email failed', [
                    'to' => $request->email,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }

            // Send notification email to admin
            try {
                Mail::to('hello@younasdev.com')->send(new ContactNotification($contact));
                $emailsSent++;
                Log::info('Notification email sent successfully', ['to' => 'hello@younasdev.com']);
            } catch (\Exception $e) {
                $errors[] = 'Admin notification failed: ' . $e->getMessage();
                Log::error('Admin notification email failed', [
                    'to' => 'hello@younasdev.com',
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }

            // Return response based on email results
            if ($emailsSent > 0) {
                $message = 'Thank you for your message! I will contact you shortly.';
                if (count($errors) > 0) {
                    $message .= ' (Some email notifications may have failed)';
                    Log::warning('Partial email failure', ['errors' => $errors]);
                }
                
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'emails_sent' => $emailsSent,
                    'debug_info' => config('app.debug') ? $errors : null
                ]);
            } else {
                // No emails sent but contact saved
                Log::error('All emails failed to send', ['errors' => $errors]);
                
                return response()->json([
                    'success' => true, // Contact was saved
                    'message' => 'Your message has been saved. However, there was an issue with email notifications. I will still receive and respond to your message.',
                    'emails_sent' => 0,
                    'debug_info' => config('app.debug') ? $errors : null
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Contact form submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['_token'])
            ]);

            return response()->json([
                'success' => false,
                'message' => 'There was an error processing your message. Please try again.',
                'debug_info' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // Add this method to test email configuration
    public function testEmail()
    {
        try {
            Mail::raw('This is a test email from Laravel using Resend.', function ($message) {
                $message->to('hm.younas22@gmail.com')
                        ->subject('Test Email - Laravel Resend Integration');
            });

            return response()->json([
                'success' => true,
                'message' => 'Test email sent successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Test email failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display all contact messages (Admin only)
     */
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Show a specific contact message (Admin only)
     */
    public function show(Contact $contact)
    {
        $contact->markAsRead();
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Update contact status (Admin only)
     */
    public function updateStatus(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => 'required|in:new,read,replied'
        ]);

        $contact->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    }

    /**
     * Delete a contact message (Admin only)
     */
    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();

            return response()->json([
                'success' => true,
                'message' => 'Contact deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting contact. Please try again.'
            ], 500);
        }
    }

    /**
     * Bulk update contact status (Admin only)
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'contact_ids' => 'required|array',
            'contact_ids.*' => 'exists:contacts,id',
            'status' => 'required|in:new,read,replied'
        ]);

        try {
            $updatedCount = Contact::whereIn('id', $request->contact_ids)
                ->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => "Successfully updated {$updatedCount} contact(s) to {$request->status} status."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating contacts. Please try again.'
            ], 500);
        }
    }

    /**
     * Bulk delete contacts (Admin only)
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'contact_ids' => 'required|array',
            'contact_ids.*' => 'exists:contacts,id'
        ]);

        try {
            $deletedCount = Contact::whereIn('id', $request->contact_ids)->delete();

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} contact(s)."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting contacts. Please try again.'
            ], 500);
        }
    }
}