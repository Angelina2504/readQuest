<?php

namespace App\Tests\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->em = static::getContainer()->get(EntityManagerInterface::class);
        $this->em->createQuery('DELETE FROM App\Entity\User u')->execute();
    }

    public function testRegisterSuccess(): void
    {
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
        $this->assertResponseStatusCodeSame(201);
    }

    public function testRegisterDuplicateEmail(): void
    {
        // First registration
        $this->client->request(
            'POST',
            '/api/auth/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'duplicate@test.com',
                'password' => 'password123',
                'user_alias' => 'userone'
            ])
        );
        $this->assertResponseStatusCodeSame(201);

        // Second registration with same email
        $this->client->request(
            'POST',
            '/api/auth/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'duplicate@test.com',
                'password' => 'password123',
                'user_alias' => 'usertwo'
            ])
        );
        $this->assertResponseStatusCodeSame(409);
    }

    public function testRegisterMissingFields(): void
    {
        $this->client->request(
            'POST',
            '/api/auth/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'test@test.com'
                // missing password and user_alias
            ])
        );
        $this->assertResponseStatusCodeSame(400);
    }

    public function testRegisterInvalidEmail(): void
    {
        $this->client->request(
            'POST',
            '/api/auth/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'not-an-email',
                'password' => 'password123',
                'user_alias' => 'testuser'
            ])
        );
        $this->assertResponseStatusCodeSame(400);
    }
}
