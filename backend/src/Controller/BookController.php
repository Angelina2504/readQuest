<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface; 

final class BookController extends AbstractController
{

    public function __construct(
    private HttpClientInterface $httpClient,
    ) {}

    #[Route('/api/books/search', name: 'app_books_search', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    { 
        $q = $request->query->get('q');

        if (!$q) {
        return $this->json(['message' => 'Search query is required'], 400);
           }

         $response = $this->httpClient->request('GET','https://www.googleapis.com/books/v1/volumes',['query' => ['q' => $q, 'key' => $_ENV['GOOGLE_BOOKS_API_KEY']]]);

         $data = $response->toArray();
         
        $books = [];
        
         
        foreach ($data['items'] as $item) {
        $identifiers = $item['volumeInfo']['industryIdentifiers'] ?? [];
        $isbn13 = array_column($identifiers, 'identifier', 'type')['ISBN_13'] ?? null;
            $books[] = [
            'book_name' => $item['volumeInfo']['title'] ?? null,
            'book_isbn' => $isbn13,
            'book_publication' => $item['volumeInfo']['publishedDate'] ?? null,
            'book_page' => $item['volumeInfo']['pageCount'] ?? null,
            'book_description' => $item['volumeInfo']['description'] ?? null,
            'book_language' => $item['volumeInfo']['language'] ?? null,
            'book_cover' => $item['volumeInfo']['imageLinks']['thumbnail'] ?? null,
            'book_autors' => $item['volumeInfo']['authors'] ?? [],
            'books_genre' => $item['volumeInfo']['categories'] ?? []
            ];
            
        }

        return $this->json($books);
    }
}