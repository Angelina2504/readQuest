<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260602081105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, particip_progression INT NOT NULL, particip_statut VARCHAR(30) NOT NULL, user_id INT NOT NULL, quest_id INT NOT NULL, INDEX IDX_AB55E24FA76ED395 (user_id), INDEX IDX_AB55E24F209E9EF4 (quest_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE quest (id INT AUTO_INCREMENT NOT NULL, quest_title VARCHAR(150) NOT NULL, quest_badge VARCHAR(100) NOT NULL, quest_description LONGTEXT DEFAULT NULL, quest_rules LONGTEXT DEFAULT NULL, quest_difficulty VARCHAR(30) NOT NULL, quest_criteria_type VARCHAR(20) NOT NULL, quest_criteria_value VARCHAR(100) DEFAULT NULL, quest_criteria_target INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F209E9EF4 FOREIGN KEY (quest_id) REFERENCES quest (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FA76ED395');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F209E9EF4');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE quest');
    }
}
