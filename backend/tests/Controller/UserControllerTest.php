<?php

namespace App\Tests\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class UserControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $em;
    private string $token;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->em = static::getContainer()->get(EntityManagerInterface::class);
        $conn = $this->em->getConnection();
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

    public function testGetProfileWithoutUserDetailsReturnsDefaultProfile(): void {
        $this->client->request(
            'GET',
            '/api/user/profile',
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token]
        );
        $this->assertResponseStatusCodeSame(200);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertSame('testuser', $data['alias']);
        $this->assertNull($data['birthday']);
        $this->assertNull($data['avatar']);
    }

    public function testPatchProfileCreatesUserDetails(): void {
        $this->client->request(
            'PATCH',
            '/api/user/profile',
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token],
            json_encode([
                'birthday' => '1992-05-05',
                'gender' => 'Femme',
                'alias' => 'testuser',
                'email' => 'test@test.com',
                 ])
        );

    $this->assertResponseStatusCodeSame(201);
    }

    public function testGetProfileWithUserDetailReturns200(): void {
        $this->client->request(
            'PATCH',
            '/api/user/profile',
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token],
            json_encode([
                'birthday' => '1992-05-05',
                'gender' => 'Femme',
                'alias' => 'testuser',
                'email' => 'test@test.com',
                 ])
        );
        $this->client->request(
            'GET',
            '/api/user/profile',
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token],
            '',
        );
    $this->assertResponseStatusCodeSame(200);
    }

    public function testPostAvatarUploadsSuccessfully(): void {
        $tmpPath = sys_get_temp_dir() . '/test_avatar.jpg';
        file_put_contents($tmpPath, pack('H*', 'FFD8FFE000104A46494600010100000100010000FFD9'));

        $file = new UploadedFile(
                $tmpPath,  
                'avatar.jpg',               
                'image/jpeg',               
                null,                       
                true                        // mode test (important !)
                );
        $this->client->request(
            'PATCH',
            '/api/user/profile',
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token],
            json_encode([
                'birthday' => '1992-05-05',
                'gender' => 'Femme',
                'alias' => 'testuser',
                'email' => 'test@test.com',
                 ])
        );

        $this->client->request(
        'POST',
        '/api/user/avatar',
        [],
        ['avatar' => $file],        
        ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token]
        );
        $this->assertResponseStatusCodeSame(200);
    }
};