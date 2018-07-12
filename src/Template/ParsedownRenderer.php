<?php declare(strict_types = 1);

namespace Example\Template;

interface ParsedownRenderer
{
    public function render($markdown) : string;
}