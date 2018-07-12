<?php declare(strict_types = 1);

namespace Example\Template;

use Parsedown;

class MarkdownRenderer implements ParsedownRenderer
{
    public function render($markdown) : string
    {
        $engine = new Parsedown();
       
        $html = $engine->text($markdown);
        return $html;
    }
}