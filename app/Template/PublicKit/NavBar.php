<?php

namespace App\Template\PublicKit;

class NavBar
{
    private $items = [];

    public function __construct()
    {
        // Initialize navbar
    }

    public function addItem($label, $url)
    {
        $this->items[] = [
            'label' => $label,
            'url' => $url
        ];
    }

    public function render()
    {
        $html = '<nav class="navbar">';
        $html .= '<ul>';

        foreach ($this->items as $item) {
            $html .= sprintf(
                '<li><a href="%s">%s</a></li>',
                $item['url'],
                $item['label']
            );
        }

        $html .= '</ul>';
        $html .= '</nav>';

        return $html;
    }
}
