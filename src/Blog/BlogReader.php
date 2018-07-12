<?php declare(strict_types = 1);

namespace Example\Blog;

interface BlogReader
{
    public function readByPostIdentification(string $id) : string;
}