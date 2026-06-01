<?php

namespace App\Tests\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $em;
    private string $token;

     protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->em = static::getContainer()->get(EntityManagerInterface::class);
        $conn = $this->em->getConnection();
        $conn->executeStatement('DELETE FROM reading');
        $conn->executeStatement('DELETE FROM book');
        $conn->executeStatement('DELETE FROM user_details');
        $conn->executeStatement('DELETE FROM user');
        $this->client->request(
            'POST',
            '/api/auth/register',
            [], 
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'test@test.com',
                'password' => 'password123',
                'user_alias' => 'testuser'])
        );
        $this->client->request(
            'POST',
            '/api/auth/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username' => 'testuser',
                'password' => 'password123',
                 ])
        );   

        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->token = $data['token'];
    }

    public function testSearchBooksReturns401WithoutToken(): void {
        $this->client->request(
            'GET',
            '/api/books/search?q=harry',
            [],
            [],
            []
        );
        $this->assertResponseStatusCodeSame(401);
    }

    public function testSearchBooksReturnsResults(): void {
        $this->client->request(
            'GET',
            '/api/books/search?q=harry',
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token]
        );
        $this->assertResponseStatusCodeSame(200);
    }

    public function testAddBookCreatesBookAndReading(): void {
        $this->client->request(
            'POST',
            '/api/books/add',
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token, 'CONTENT_TYPE' => 'application/json'],
            json_encode([
                    "book_isbn" => "9781781101032",
                    "book_name"=> "Harry Potter test",
                    "book_publication"=> "2015-12-08",
                    "book_page"=> 362,
                    "book_description"=> "Test description",
                    "book_language"=> "fr",
                    "book_cover"=> null,
                    "reading_status"=> "a_lire"
            ])
        );
        $this->assertResponseStatusCodeSame(201);
    }


    public function testAddBookPreventDuplicate(): void {
        $this->client->request(
            'POST',
            '/api/books/add',
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token, 'CONTENT_TYPE' => 'application/json'],
            json_encode([
                    "book_isbn" => "9781781101032",
                    "book_name"=> "Harry Potter test",
                    "book_publication"=> "2015-12-08",
                    "book_page"=> 362,
                    "book_description"=> "Test description",
                    "book_language"=> "fr",
                    "book_cover"=> null,
                    "reading_status"=> "a_lire"
            ]),
        );
        $this->client->request(
            'POST',
            '/api/books/add',
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token, 'CONTENT_TYPE' => 'application/json'],
            json_encode([
                    "book_isbn" => "9781781101032",
                    "book_name"=> "Harry Potter test",
                    "book_publication"=> "2015-12-08",
                    "book_page"=> 362,
                    "book_description"=> "Test description",
                    "book_language"=> "fr",
                    "book_cover"=> null,
                    "reading_status"=> "a_lire"
            ]),
        );

    $this->assertResponseStatusCodeSame(200);
    }

    public function testGetLibraryReturnsUserBooks(): void {
        $this->client->request(
            'POST',
            '/api/books/add',
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token, 'CONTENT_TYPE' => 'application/json'],
            json_encode([
                    "book_isbn" => "9781781101032",
                    "book_name"=> "Harry Potter test",
                    "book_publication"=> "2015-12-08",
                    "book_page"=> 362,
                    "book_description"=> "Test description",
                    "book_language"=> "fr",
                    "book_cover"=> null,
                    "reading_status"=> "a_lire"
            ]),
        );
        $this->client->request(
            'GET',
            '/api/books/library',
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token, 'CONTENT_TYPE' => 'application/json'],
        );
        $this->assertResponseStatusCodeSame(200);
    }

    public function testPatchReadingStatusUpdates(): void {
        $this->client->request(
            'POST',
            '/api/books/add',
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token, 'CONTENT_TYPE' => 'application/json'],
            json_encode([
                    "book_isbn" => "9781781101032",
                    "book_name"=> "Harry Potter test",
                    "book_publication"=> "2015-12-08",
                    "book_page"=> 362,
                    "book_description"=> "Test description",
                    "book_language"=> "fr",
                    "book_cover"=> null,
                    "reading_status"=> "a_lire"
            ]),
        );
        $this->client->request(
            'GET',
            '/api/books/library', 
            [], 
            [], 
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token]);
            $library = json_decode(
                $this->client->getResponse()->getContent(), true);
            $id = $library[0]['reading_id'];
        $this->client->request(
            'PATCH',
            '/api/library/' . $id,
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token, 'CONTENT_TYPE' => 'application/json'],
            json_encode([
                "reading_status"=> "en_cours"
            ])
        );
        $this->assertResponseStatusCodeSame(200);
    }

     public function testDeleteReadingRemovesBook(): void {
        $this->client->request(
            'POST',
            '/api/books/add',
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token, 'CONTENT_TYPE' => 'application/json'],
            json_encode([
                    "book_isbn" => "9781781101032",
                    "book_name"=> "Harry Potter test",
                    "book_publication"=> "2015-12-08",
                    "book_page"=> 362,
                    "book_description"=> "Test description",
                    "book_language"=> "fr",
                    "book_cover"=> null,
                    "reading_status"=> "a_lire"
            ]),
        );
        $this->client->request(
            'GET',
            '/api/books/library', 
            [], 
            [], 
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token]);
            $library = json_decode(
                $this->client->getResponse()->getContent(), true);
            $id = $library[0]['reading_id'];
        $this->client->request(
            'DELETE',
            '/api/library/' . $id,
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token, 'CONTENT_TYPE' => 'application/json'],
        );
        $this->assertResponseStatusCodeSame(200);
    }
}