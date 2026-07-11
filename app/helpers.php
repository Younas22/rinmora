<?php

if (!function_exists('getInitials')) {
    function getInitials(string $name): string
    {
        $words = explode(' ', $name);
        $initials = '';
        
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
            if (strlen($initials) >= 2) break;
        }
        
        return $initials;
    }
}

if (!function_exists('getRandomColor')) {
    function getRandomColor(): string
    {
        $colors = [
            '#20c997', '#0d6efd', '#6f42c1', '#d63384', 
            '#fd7e14', '#ffc107', '#198754', '#0dcaf0'
        ];
        
        return $colors[array_rand($colors)];
    }
}




if (!function_exists('darkenHex')) {
    /**
     * Darken a hex color by a percentage — used to derive a "-dark" hover
     * variant from the single admin-configured brand color (there's no
     * separate "primary dark" field in Settings > Theme Colors).
     */
    function darkenHex(string $hex, float $percent = 0.12): string
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }
        if (strlen($hex) !== 6 || !ctype_xdigit($hex)) {
            return '#'.$hex;
        }

        [$r, $g, $b] = array_map(fn ($c) => max(0, (int) round(hexdec($c) * (1 - $percent))), str_split($hex, 2));

        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
}

if (!function_exists('format_price')) {
    /**
     * Format a base-currency (USD) amount using the admin's active display
     * currency (Settings > Currency): converts by exchange_rate, then
     * applies that currency's decimal places and symbol position. Falls
     * back to plain USD formatting if no currency is marked active yet
     * (e.g. before the currencies table has been seeded).
     */
    function format_price(float|int|string|null $amount): string
    {
        $amount = (float) $amount;
        $currency = \App\Models\Currency::active();

        if (! $currency) {
            return '$'.number_format($amount, 2);
        }

        $converted = $amount * (float) $currency->exchange_rate;
        $formatted = number_format($converted, $currency->decimal_places);

        return $currency->symbol_position === 'after'
            ? $formatted.$currency->symbol
            : $currency->symbol.$formatted;
    }
}

if (!function_exists('processImages')) {
    function processImages($content) {
        // Add responsive class to images
        $content = preg_replace('/<img(.*?)>/', '<img$1 class="img-fluid">', $content);
        // Limit image width if width attribute is too large.
        $content = preg_replace_callback(
            '/<img(.*?)width="(\d+)"(.*?)>/',
            function($matches) {
                $width = min($matches[2], 1200); // Max width 1200px
                return '<img'.$matches[1].'width="'.$width.'"'.$matches[3].'>';
            },
            $content
        );
        
        return $content;
    }
}

