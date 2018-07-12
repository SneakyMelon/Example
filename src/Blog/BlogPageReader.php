<?php declare(strict_types = 1);

namespace Example\Blog;

use InvalidArgumentException;

class BlogPageReader implements BlogReader
{
    private $pageFolder;

    public function __construct(string $pageFolder)
    {
        $this->pageFolder = $pageFolder;
    }

    public function readByPostIdentification(string $id) : string
    {
        $path = "$this->pageFolder/$id.md";

        if (!file_exists($path)){
            throw new \Example\Blog\InvalidBlogIdException($id);
        }
        
        return file_get_contents($path);
    }
}