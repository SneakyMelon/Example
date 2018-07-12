<?php declare(strict_types = 1);

namespace Example\Controllers;

use Http\Response;
use Example\Template\FrontendRenderer;
use Example\Template\ParsedownRenderer;
use Example\Blog\BlogReader;
use Example\Blog\InvalidBlogIdException;

class Blog
{

    private $response;
    private $renderer;
    private $blogReader;
    private $markdownRenderer;

    public function __construct(
        Response $response,
        ParsedownRenderer $markdownRenderer,
        FrontendRenderer $renderer,
        BlogReader $blogReader)
    {
        $this->blogReader = $blogReader;
        $this->response = $response;
        $this->renderer = $renderer;
        $this->markdownRenderer = $markdownRenderer;
    }

    public function show($params)
    {
        $id = $params['id'];
        $data = array();

        // Step 1: Get contents of file, or fail
        try {
            $data['content'] = $this->blogReader->readByPostIdentification($id);            
        } catch (InvalidBlogIdException $e) {
            $this->response->setStatusCode(404);
            return $this->response->setContent('404 - Sorry, the Blog post was not found.');
        }

        // Step 2: Render .md into HTML
        $data['content'] = $this->markdownRenderer->render($data['content']);
        
        // Step 3: Render Full HTML Template with Blog content  
        $html = $this->renderer->render('Blog', $data);
        $this->response->setContent($html);
    }

    public function index()
    {
        // Show index file for blog
    }
}