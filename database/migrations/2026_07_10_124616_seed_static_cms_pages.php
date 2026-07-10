<?php

use App\Models\Page;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $privacyContent = <<<'HTML'
<p>Rinmora ("we", "our", "us") respects your privacy and is committed to protecting the personal information you share with us. This policy explains what we collect, how we use it, and the choices available to you.</p>
<h2>1. Information We Collect</h2>
<p>We collect information you provide directly, such as your name, email address, shipping address, and payment details when you create an account or place an order. We also collect device and usage information automatically, including your IP address, browser type, and browsing behavior on our site.</p>
<h2>2. How We Use Your Information</h2>
<p>We use your information to process orders, provide customer support, personalize your shopping experience, send order updates, and — with your consent — share promotional offers and new arrivals.</p>
<h2>3. Cookies</h2>
<p>We use cookies and similar technologies to remember your preferences, keep items in your cart, and understand how you use our site so we can improve it. You can control cookies through your browser settings at any time.</p>
<h2>4. Data Sharing</h2>
<p>We never sell your personal information. We may share data with trusted service providers — such as payment processors and shipping carriers — solely to fulfill your orders, and only to the extent necessary.</p>
<h2>5. Data Security</h2>
<p>We use industry-standard encryption and security measures to protect your information. While no method of transmission is 100% secure, we continuously review our practices to keep your data safe.</p>
<h2>6. Your Rights</h2>
<p>You may access, update, or request deletion of your personal information at any time from your account settings, or by contacting our support team directly.</p>
<h2>7. Children's Privacy</h2>
<p>Rinmora is not intended for children under 16. We do not knowingly collect personal information from children.</p>
<h2>8. Changes to This Policy</h2>
<p>We may update this Privacy Policy from time to time. Material changes will be communicated via email or a prominent notice on our site.</p>
<h2>9. Contact Us</h2>
<p>If you have questions about this Privacy Policy, please reach out to us at <a href="mailto:privacy@rinmora.com">privacy@rinmora.com</a> or visit our Contact Us page.</p>
HTML;

        $termsContent = <<<'HTML'
<p>This is a legally binding agreement between you and Rinmora. By accessing or using our website, you agree to be bound by these Terms &amp; Conditions. Please read them carefully before making a purchase.</p>
<h2>1. Acceptance of Terms</h2>
<p>By creating an account, browsing our catalog, or placing an order, you confirm that you have read, understood, and agree to these Terms &amp; Conditions and our Privacy Policy.</p>
<h2>2. Use of Website</h2>
<p>You agree to use rinmora.com only for lawful purposes. You may not use our site in any way that could damage, disable, or impair its functionality, or interfere with any other party's use of the site.</p>
<h2>3. Account Registration</h2>
<p>You are responsible for maintaining the confidentiality of your account credentials and for all activity that occurs under your account. Notify us immediately of any unauthorized use.</p>
<h2>4. Orders &amp; Payments</h2>
<p>All orders are subject to acceptance and availability. We reserve the right to refuse or cancel any order at our discretion, including in cases of suspected fraud or pricing errors.</p>
<h2>5. Pricing &amp; Availability</h2>
<p>Prices are listed in the currency shown at checkout and are subject to change without notice. We make every effort to display accurate stock levels but cannot guarantee availability at time of order.</p>
<h2>6. Intellectual Property</h2>
<p>All content on this site — including logos, product photography, and designs — is the property of Rinmora and may not be reproduced without written permission.</p>
<h2>7. Limitation of Liability</h2>
<p>Rinmora shall not be liable for any indirect, incidental, or consequential damages arising from your use of our website or products, to the fullest extent permitted by law.</p>
<h2>8. Governing Law</h2>
<p>These Terms are governed by the laws of the State of California, United States, without regard to conflict of law principles.</p>
<h2>9. Changes to Terms</h2>
<p>We may revise these Terms at any time. Continued use of our website after changes are posted constitutes your acceptance of the updated Terms.</p>
<h2>10. Support</h2>
<p>Questions about these Terms? Reach our team at <a href="mailto:legal@rinmora.com">legal@rinmora.com</a> or visit our Contact Us page.</p>
HTML;

        $returnsContent = <<<'HTML'
<p>Not quite right? We've made returning or exchanging your Rinmora piece simple and stress-free.</p>
<h2>How Returns Work</h2>
<ol>
<li><strong>Request a Return</strong> — Start your return from the My Orders page within 14 days of delivery.</li>
<li><strong>Pack Your Item</strong> — Repack the item in its original packaging with all tags attached.</li>
<li><strong>Ship It Back</strong> — Use the prepaid return label we email you and drop it off at any courier point.</li>
<li><strong>Get Refunded</strong> — Once inspected, your refund is issued to your original payment method.</li>
</ol>
<h2>Eligibility</h2>
<ul>
<li>Returned within 14 days of delivery</li>
<li>Unused, unwashed, with original tags</li>
<li>In original packaging and dust bag</li>
</ul>
<h2>Non-Returnable Items</h2>
<ul>
<li>Final sale &amp; clearance items</li>
<li>Gift cards</li>
<li>Items showing signs of wear or damage</li>
</ul>
<h2>Refund Timeline</h2>
<p>Once your return is received and inspected, refunds are processed within 5–7 business days back to your original payment method. Your bank may take a few additional days to reflect the credit.</p>
<h2>Exchange Policy</h2>
<p>Prefer a different color or style? Select "Exchange" instead of "Refund" when starting your return, and we'll ship your new item as soon as the original is received.</p>
<h2>Returns FAQ</h2>
<p><strong>Do I have to pay for return shipping?</strong><br>No — we provide a free prepaid return label for all eligible returns within the US.</p>
<p><strong>Can I return a sale item?</strong><br>Items marked "Final Sale" cannot be returned or exchanged. All other discounted items follow our standard 14-day policy.</p>
<p><strong>How do I check my return status?</strong><br>You can check the status of any return from your My Orders page at any time.</p>
HTML;

        $pages = [
            [
                'name' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => $privacyContent,
                'meta_title' => 'Privacy Policy — Rinmora',
                'meta_description' => "Rinmora's Privacy Policy — how we collect, use, and protect your information.",
            ],
            [
                'name' => 'Terms & Conditions',
                'slug' => 'terms',
                'content' => $termsContent,
                'meta_title' => 'Terms & Conditions — Rinmora',
                'meta_description' => "Rinmora's Terms & Conditions of use and purchase.",
            ],
            [
                'name' => 'Returns & Refunds',
                'slug' => 'returns',
                'content' => $returnsContent,
                'meta_title' => 'Returns & Refunds — Rinmora',
                'meta_description' => "Rinmora's Return & Refund Policy — eligibility, timelines, and exchanges.",
            ],
        ];

        foreach ($pages as $data) {
            Page::updateOrCreate(
                ['slug' => $data['slug']],
                $data + ['status' => 'published', 'show_in_menu' => false]
            );
        }
    }

    public function down(): void
    {
        Page::whereIn('slug', ['privacy-policy', 'terms', 'returns'])->delete();
    }
};
