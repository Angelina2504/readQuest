<?php

namespace App\Tests;

use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GoogleBooksMockResponseFactory
{
    public function __invoke(string $method, string $url, array $options = []): ResponseInterface
    {
        if (str_contains($url, 'googleapis.com/books')) {
            return new MockResponse(json_encode([
                'items' => [[
                    'volumeInfo' => [
                        'title'               => 'Harry Potter',
                        'industryIdentifiers' => [['type' => 'ISBN_13', 'identifier' => '9781234567890']],
                        'publishedDate'       => '1997',
                        'pageCount'           => 309,
                        'description'         => 'A wizarding adventure',
                        'language'            => 'en',
                        'imageLinks'          => ['thumbnail' => 'https://example.com/cover.jpg'],
                        'authors'             => ['J.K. Rowling'],
                        'categories'          => ['Fiction'],
                    ],
                ]],
            ]), ['http_code' => 200]);
        }

        return new MockResponse('', ['http_code' => 200]);
    }
}