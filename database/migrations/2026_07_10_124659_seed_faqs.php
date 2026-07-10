<?php

use App\Models\Cms\Faq;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $faqs = [
            ['category' => 'orders', 'question' => 'How do I track my order?', 'answer' => 'Once your order ships, you\'ll receive a confirmation email with a tracking link. You can also track any order anytime from your My Orders page.'],
            ['category' => 'shipping', 'question' => 'How long does shipping take?', 'answer' => 'Standard shipping takes 3–5 business days, Express takes 1–2 business days, and Same Day Delivery is available in select cities. Delivery estimates are shown at checkout.'],
            ['category' => 'returns', 'question' => 'What is your return policy?', 'answer' => 'We accept returns within 14 days of delivery for unused items in original packaging. Visit our Returns & Refunds page for full details.'],
            ['category' => 'payments', 'question' => 'What payment methods do you accept?', 'answer' => 'We accept Visa, Mastercard, PayPal, Apple Pay, Google Pay, and Cash on Delivery in select regions.'],
            ['category' => 'products', 'question' => 'Are Rinmora handbags made of genuine leather?', 'answer' => 'Most Rinmora pieces are crafted from premium vegan leather; select styles feature genuine leather. Each product page lists the exact material used.'],
            ['category' => 'account', 'question' => 'How do I reset my account password?', 'answer' => 'Head to the Forgot Password page, enter your email, and we\'ll send you a secure reset link.'],
            ['category' => 'shipping', 'question' => 'Do you ship internationally?', 'answer' => 'Yes — we currently ship to 24 countries. Shipping costs and delivery times are calculated at checkout based on your address.'],
            ['category' => 'orders', 'question' => 'Can I change my order after placing it?', 'answer' => 'Contact our support team within 1 hour of placing your order and we\'ll do our best to update it before it ships.'],
            ['category' => 'orders', 'question' => 'Do you offer gift wrapping?', 'answer' => 'Yes — select the gift wrap option at checkout for an elegant Rinmora gift box and ribbon at no extra cost.'],
            ['category' => 'products', 'question' => 'How do I care for my handbag?', 'answer' => 'Store your bag in its dust bag away from direct sunlight, avoid water exposure, and wipe clean with a soft, dry cloth.'],
            ['category' => 'payments', 'question' => 'Is Cash on Delivery available?', 'answer' => 'Yes, Cash on Delivery is available in select regions and can be chosen as a payment method at checkout.'],
            ['category' => 'account', 'question' => 'How do I redeem reward points?', 'answer' => 'Your reward point balance is shown on your Account dashboard and can be applied automatically at checkout once you have enough points.'],
        ];

        foreach ($faqs as $i => $data) {
            Faq::updateOrCreate(
                ['question' => $data['question']],
                $data + ['sort_order' => $i, 'is_visible' => true]
            );
        }
    }

    public function down(): void
    {
        Faq::query()->delete();
    }
};
