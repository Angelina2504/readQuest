<?php

namespace App\Tests\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuestControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $em;
    private string $token;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->em = static::getContainer()->get(EntityManagerInterface::class);
        $conn = $this->em->getConnection();
        $conn->executeStatement('DELETE FROM participation');
        $conn->executeStatement('DELETE FROM reading');
        $conn->executeStatement('DELETE FROM book');
        $conn->executeStatement('DELETE FROM user_details');
        $conn->executeStatement('DELETE FROM user');
        $conn->executeStatement('DELETE FROM quest');
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
        public function testGetQuestsReturnsResults(): void {
            $this->client->request(
                'GET',
                '/api/quests',
                [],
                [],
                []
            );
            $this->assertResponseStatusCodeSame(200);
        }

        public function testJoinQuestsCreateParticipation(): void {
            $conn = $this->em->getConnection();
            $conn->executeStatement("INSERT INTO quest (quest_title, quest_badge, quest_difficulty, quest_criteria_type, quest_criteria_target) VALUES ('Test', 'lvl1Fable.png', 'Fable', 'book_count', 3)");
            $questId = $conn->lastInsertId();
            $this->client->request(
                'POST',
                '/api/quests/' . $questId . '/join',
                [],
                [],
                ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token]
            );
            $this->assertResponseStatusCodeSame(201);
        }

        public function testJoinQuestsPreventDuplicate(): void {
            $conn = $this->em->getConnection();
            $conn->executeStatement("INSERT INTO quest (quest_title, quest_badge, quest_difficulty, quest_criteria_type, quest_criteria_target) VALUES ('Test', 'lvl1Fable.png', 'Fable', 'book_count', 3)");
            $questId = $conn->lastInsertId();
            $this->client->request(
                'POST',
                '/api/quests/' . $questId . '/join',
                [],
                [],
                ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token]
            );
            $this->client->request(
                'POST',
                '/api/quests/' . $questId . '/join',
                [],
                [],
                ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token]
            );
            $this->assertResponseStatusCodeSame(200);
        }

        public function testGetMyReturnsParticipations(): void {
            $conn = $this->em->getConnection();
            $conn->executeStatement("INSERT INTO quest (quest_title, quest_badge, quest_difficulty, quest_criteria_type, quest_criteria_target) VALUES ('Test', 'lvl1Fable.png', 'Fable', 'book_count', 3)");
            $questId = $conn->lastInsertId();
            $this->client->request(
                'POST',
                '/api/quests/' . $questId . '/join',
                [],
                [],
                ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token]
            );
            $this->client->request(
                'GET',
                '/api/quests/my',
                [],
                [],
                ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token]
            );
            $this->assertResponseStatusCodeSame(200);
        }

        public function testGetQuestsReturns401WithoutToken(): void {
            $this->client->request(
                'GET',
                '/api/quests/my',
                [],
                [],
                []
            );
            $this->assertResponseStatusCodeSame(401);
        }

        public function testLeaveQuestRemovesParticipation(): void {
            $conn = $this->em->getConnection();
            $conn->executeStatement("INSERT INTO quest (quest_title, quest_badge, quest_difficulty, quest_criteria_type, quest_criteria_target) VALUES ('Test', 'lvl1Fable.png', 'Fable', 'book_count', 3)");
            $questId = $conn->lastInsertId();
            $this->client->request(
                'POST',
                '/api/quests/' . $questId . '/join',
                [],
                [],
                ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token]
            );
            $this->client->request(
                'DELETE',
                '/api/quests/' . $questId . '/leave',
                [],
                [],
                ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token]
            );
            $this->assertResponseStatusCodeSame(200);
        }

}