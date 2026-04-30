<?php

namespace App\Tests\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->em = static::getContainer()->get(EntityManagerInterface::class);
        $this->em->createQuery('DELETE FROM App\Entity\User u')->execute();
         $this->client->request(
            'POST',
            '/api/auth/register',
            [], 
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'test@test.com',
                'password' => 'password123',
                'user_alias' => 'testuser'
    ])
);
        
    }

     public function testLoginSuccess(): void
    { 
        // login valide
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
        $this->assertResponseStatusCodeSame(200);
    }

    public function testLoginWrongPassword(): void
    {   
        $this->client->request(
            'POST',
            '/api/auth/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username' => 'testuser',
                'password' => 'password1234',
               
            ])
        );
        $this->assertResponseStatusCodeSame(401);
    }

    public function testLoginUnknownUser(): void
    {  
        $this->client->request(
            'POST',
            '/api/auth/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username' => 'testuserunknown',
                'password' => 'password123',
               
            ])
        );
        $this->assertResponseStatusCodeSame(401);
    }

    public function testLoginMissingFields(): void
    {   
        $this->client->request(
            'POST',
            '/api/auth/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
               
            ])
        );
        $this->assertResponseStatusCodeSame(400);
    }
}
