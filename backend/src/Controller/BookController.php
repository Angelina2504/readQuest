<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BookRepository;
use App\Repository\ReadingRepository;
use App\Repository\GenreRepository;
use App\Repository\AutorRepository;
use App\Entity\Book;
use App\Entity\Reading;
use App\Entity\Genre;
use App\Entity\Autor; 
use App\Service\QuestProgressionService;
use App\Service\ActivityLogService;

final class BookController extends AbstractController
{

    public function __construct(
    private HttpClientInterface $httpClient,
    private CacheInterface $cache,
    private BookRepository $bookRepository,
    private EntityManagerInterface $entityManager,
    private ReadingRepository $readingRepository,
    private QuestProgressionService $questprogressionService,
    private GenreRepository $genreRepository,
    private AutorRepository $autorRepository,
    private ActivityLogService $activityLogService,
    ) {}

    #[Route('/api/books/search', name: 'app_books_search', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    { 
        $q = $request->query->get('q');

        if (!$q) {
        return $this->json(['message' => 'Search query is required'], 400);
           }

         $cacheKey = 'google_books_' . md5($q);

        try {
            $books = $this->cache->get($cacheKey, function (ItemInterface $item) use ($q): array {
                $item->expiresAfter(3600);

                $maxRetries = 3;
                $attempt = 0;
                do {
                    $response = $this->httpClient->request('GET', 'https://www.googleapis.com/books/v1/volumes', [
                        'query' => ['q' => $q, 'key' => $_ENV['GOOGLE_BOOKS_API_KEY']]
                    ]);
                    $statusCode = $response->getStatusCode();
                    $attempt++;
                } while ($statusCode === 503 && $attempt < $maxRetries);

                if ($statusCode !== 200) {
                    throw new \RuntimeException('API unavailable');
                }

                $data = $response->toArray();

                if (empty($data['items'])) {
                    return [];
                }

                $books = [];
                foreach ($data['items'] as $item) {
                    $identifiers = $item['volumeInfo']['industryIdentifiers'] ?? [];
                    $isbn13 = array_column($identifiers, 'identifier', 'type')['ISBN_13'] ?? null;
                    $books[] = [
                        'book_name'        => $item['volumeInfo']['title'] ?? null,
                        'book_isbn'        => $isbn13,
                        'book_publication' => $item['volumeInfo']['publishedDate'] ?? null,
                        'book_page'        => $item['volumeInfo']['pageCount'] ?? null,
                        'book_description' => $item['volumeInfo']['description'] ?? null,
                        'book_language'    => $item['volumeInfo']['language'] ?? null,
                        'book_cover'       => $item['volumeInfo']['imageLinks']['thumbnail'] ?? null,
                        'book_autors'      => $item['volumeInfo']['authors'] ?? [],
                        'books_genre'      => $item['volumeInfo']['categories'] ?? [],
                    ];
                }

                return $books;
            });
        } catch (\RuntimeException) {
            return $this->json(['message' => 'Recherche indisponible, réessaie dans un instant'], 503);
        }

        return $this->json($books);
    }
    #[Route('/api/books/add', name: 'app_books_add', methods: ['POST'])]
    public function addBooks (Request $request): JsonResponse
    {  
        $data = json_decode($request->getContent(), true);
        $user = $this->getUser();

        if($user === null){
            return $this->json(['message' => 'Unauthorized'], 401);
        }

        $book = $this->bookRepository->findOneBy(['book_isbn' => $data['book_isbn']]);
        

        if($book === null){
            $book = new Book();
            $book->setBookName($data['book_name']);
            $book->setBookIsbn($data['book_isbn']);
            $book->setBookPublication(substr($data['book_publication'] ?? '', 0, 20));
            $book->setBookPage($data['book_page']);
            $book->setBookDescription($data['book_description']);
            $book->setBookLanguage($data['book_language']);
            $book->setBookCover($data['book_cover']);
    
        foreach ($data['books_genre'] ?? [] as $genreName) {

        $genre =$this->genreRepository->findOneBy(['genre_name' => $genreName]);

        if($genre === null){
            $genre = new Genre();
            $genre->setGenreName($genreName);
        }
            $this->entityManager->persist($genre);
            $book->addGenre($genre);
        }

        foreach ($data['book_autors'] ?? [] as $autorName) {

        $autor =$this->autorRepository->findOneBy(['autor_name' => $autorName]);

        if($autor === null){
            $autor = new Autor();
            $autor->setAutorName($autorName);
        }
            $this->entityManager->persist($autor);
            $book->addAutor($autor);
        } 

            $this->entityManager->persist($book);
            $this->entityManager->flush();
        }
        
        $existingReading=$this->readingRepository->findOneBy(
            ['user' => $user, 'book' => $book]);

        if($existingReading !== null){
            return $this->json(['message' => 'Book or reading already in database'], 200);
        
        }

        $reading = new Reading();
        $reading->setReadingStatus($data['reading_status']);
        $reading->setUser($user);
        $reading->setBook($book);
        
        $this->entityManager->persist($reading);
        $this->entityManager->flush();

        $this->activityLogService->log($user->getId(), 'book_added', $book->getBookName());

        return $this->json([
            'message' => 'Book created successfully',
            'reading' => [
                'reading_id'     => $reading->getId(),
                'reading_status' => $reading->getReadingStatus(),
                'book_name'      => $book->getBookName(),
                'book_cover'     => $book->getBookCover(),
                'book_isbn'      => $book->getBookIsbn(),
                'book_genres'    => array_map(fn($g) => $g->getGenreName(), $book->getGenres()->toArray()),
            ]
        ], 201);
        
    }
    #[Route('/api/books/library', name: 'app_books_library', methods: ['GET'])]
    public function getLibrary (): JsonResponse
    {
        $user = $this->getUser();
        $readings = $this->readingRepository->findByUserWithBooks($user);    
        $library = [];

        foreach ($readings as $reading) {
            $genres = array_map(fn($g) => $g->getGenreName(), $reading->getBook()->getGenres()->toArray());
            $library[] = [
                'reading_id' => $reading->getId(),
                'reading_status' => $reading->getReadingStatus(),
                'book_name' => $reading->getBook()->getBookName(),
                'book_cover' => $reading->getBook()->getBookCover(),
                'book_isbn' => $reading->getBook()->getBookIsbn(),
                'book_genres' => $genres,
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
        
        if($data['reading_status'] === 'lu') {
        $reading->setReadingEnd(new \DateTime());
        }
        
        $this->entityManager->flush();

        $user = $reading->getUser();
        $this->questprogressionService->updateProgression($user);

        $this->activityLogService->log($user->getId(), 'statut_patched', $reading->getBook()->getBookName());

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