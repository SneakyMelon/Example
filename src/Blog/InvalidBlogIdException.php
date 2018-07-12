<?php declare(strict_types = 1);

namespace Example\Blog;

use Exception;

class InvalidBlogIdException extends Exception
{
    public function __construct($id, $code = 0, Exception $previous = null)
    {
        $message = "No blog post by the name of '$id' was found.";
        parent::__construct($message, $code, $previous);
    }
}