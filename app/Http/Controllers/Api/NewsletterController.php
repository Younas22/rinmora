<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $subscriber = NewsletterSubscriber::firstOrNew(['email' => $data['email']]);

        if (! $subscriber->exists || $subscriber->status !== 'active') {
            $subscriber->status = 'active';
            $subscriber->joined_date = now();
        }

        $subscriber->source = $subscriber->source ?? 'home_page';
        $subscriber->save();

        return response()->json(['message' => 'Subscribed successfully.']);
    }
}
