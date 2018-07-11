<?php declare(strict_types = 1);

namespace Example\Menu;

class ArrayMenuReader implements MenuReader
{
    public function readMenu() : array
    {
        return [
            ['href' => '/', 'text' => 'Homepage'],
            ['href' => '/hello/Allan', 'text' => 'Allan'],
            ['href' => '/hello/Steve', 'text' => 'Steve'],
            ['href' => '/hello/Philip', 'text' => 'Philip'],
            ['href' => '/phpmyadmin', 'text' => 'Database Admin'],
        ];
    }
}