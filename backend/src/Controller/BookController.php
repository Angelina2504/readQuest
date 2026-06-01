<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BookRepository;
use App\Repository\ReadingRepository;
use App\Entity\Book;
use App\Entity\Reading;

final class BookController extends AbstractController
{

    public function __construct(
    private HttpClientInterface $httpClient,
    private BookRepository $bookRepository,
    private EntityManagerInterface $entityManager,
    private ReadingRepository $readingRepository,
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
    #[Route('/api/books/add', name: 'app_books_add', methods: ['POST'])]
    public function addBooks (Request $request): JsonResponse
    {  
        $data = json_decode($request->getContent(), true);
        $user = $this->getUser();

        if($user == null){
            return $this->json(['message' => 'Unauthorized'], 401);
        }
        $book = $this->bookRepository->findOneBy(['book_isbn' => $data['book_isbn']]);

        if($book === null){
            $book = new Book();
            $book->setBookName($data['book_name']);
            $book->setBookIsbn($data['book_isbn']);
            $book->setBookPublication($data['book_publication']);
            $book->setBookPage($data['book_page']);
            $book->setBookDescription($data['book_description']);
            $book->setBookLanguage($data['book_language']);
            $book->setBookCover($data['book_cover']);
        }
        $this->entityManager->persist($book);
        $this->entityManager->flush();

        $reading = new Reading();
        $reading->setReadingStatus($data['reading_status']);
        $reading->setUser($user);
        $reading->setBook($book);

        $this->entityManager->persist($reading);
        $this->entityManager->flush();

        return $this->json(['message' => 'Book created successfully'], 201);
        
    }
    #[Route('/api/books/library', name: 'app_books_library', methods: ['GET'])]
    public function getLibrary (): JsonResponse
    {
        $user = $this->getUser();
        $readings = $this->readingRepository->findBy(['user' => $user]);    
        $library = [];

        foreach ($readings as $reading) {
            $library[] = [
                'reading_id' => $reading->getId(),
                'reading_status' => $reading->getReadingStatus(),
                'book_name' => $reading->getBook()->getBookName(),
                'book_cover' => $reading->getBook()->getBookCover(),
                'book_isbn' => $reading->getBook()->getBookIsbn(),
            ];
        }
        return $this->json($library);
    }

    #[Route('/api/library/{id}', name: 'app_library_statut', methods: ['PATCH'])]
    public function patchStatut(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $reading = $this->readingRepository->findOneBy(['id'=>$id]);

        if($reading === null){
            return $this->json(['message' => 'Reading not found'], 404);
        }
           $reading->setReadingStatus($data['reading_status']);
        
        $this->entityManager->flush();

        return $this->json(['message' => 'Statut update'], 200);
    }

     #[Route('/api/library/{id}', name: 'app_library_delete', methods: ['DELETE'])]
    public function deleteReading(int $id): JsonResponse
    {
        $reading = $this->readingRepository->findOneBy(['id'=>$id]);

         if($reading === null){
            return $this->json(['message' => 'Reading not found'], 404);
        }

        $this->entityManager->remove($reading);

        $this->entityManager->flush();

        return $this->json(['message' => 'Book Delete'], 200);
    }
}