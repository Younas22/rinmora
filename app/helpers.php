<?php
use App\Models\MenuItem;

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




if (!function_exists('get_menu_items')) {
    function get_menu_items($category = 'header', $activeOnly = true) {
        return MenuItem::where('category', $category)
            ->when($activeOnly, function ($query) {
                $query->where('is_active', true);
            })
            ->orderBy('sort_order')
            ->get();
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

