<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260521090541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE autor (id INT AUTO_INCREMENT NOT NULL, autor_name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, book_name VARCHAR(255) NOT NULL, book_isbn VARCHAR(13) NOT NULL, book_publication VARCHAR(10) DEFAULT NULL, book_page INT NOT NULL, book_cover VARCHAR(500) DEFAULT NULL, book_description LONGTEXT DEFAULT NULL, book_language VARCHAR(5) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE book_autor (book_id INT NOT NULL, autor_id INT NOT NULL, INDEX IDX_3FC54BC316A2B381 (book_id), INDEX IDX_3FC54BC314D45BBE (autor_id), PRIMARY KEY (book_id, autor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE book_genre (book_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_8D92268116A2B381 (book_id), INDEX IDX_8D9226814296D31F (genre_id), PRIMARY KEY (book_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, genre_name VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE reading (id INT AUTO_INCREMENT NOT NULL, reading_status VARCHAR(20) NOT NULL, reading_begin DATE DEFAULT NULL, reading_end DATE DEFAULT NULL, user_id INT DEFAULT NULL, book_id INT DEFAULT NULL, INDEX IDX_C11AFC41A76ED395 (user_id), INDEX IDX_C11AFC4116A2B381 (book_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE book_autor ADD CONSTRAINT FK_3FC54BC316A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_autor ADD CONSTRAINT FK_3FC54BC314D45BBE FOREIGN KEY (autor_id) REFERENCES autor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_genre ADD CONSTRAINT FK_8D92268116A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_genre ADD CONSTRAINT FK_8D9226814296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reading ADD CONSTRAINT FK_C11AFC41A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reading ADD CONSTRAINT FK_C11AFC4116A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE user_details CHANGE birthday birthday DATE NOT NULL, CHANGE gender gender VARCHAR(30) NOT NULL, CHANGE avatar avatar VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_autor DROP FOREIGN KEY FK_3FC54BC316A2B381');
        $this->addSql('ALTER TABLE book_autor DROP FOREIGN KEY FK_3FC54BC314D45BBE');
        $this->addSql('ALTER TABLE book_genre DROP FOREIGN KEY FK_8D92268116A2B381');
        $this->addSql('ALTER TABLE book_genre DROP FOREIGN KEY FK_8D9226814296D31F');
        $this->addSql('ALTER TABLE reading DROP FOREIGN KEY FK_C11AFC41A76ED395');
        $this->addSql('ALTER TABLE reading DROP FOREIGN KEY FK_C11AFC4116A2B381');
        $this->addSql('DROP TABLE autor');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_autor');
        $this->addSql('DROP TABLE book_genre');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE reading');
        $this->addSql('ALTER TABLE user_details CHANGE birthday birthday DATE DEFAULT NULL, CHANGE gender gender VARCHAR(30) DEFAULT NULL, CHANGE avatar avatar VARCHAR(255) DEFAULT NULL');
    }
}
