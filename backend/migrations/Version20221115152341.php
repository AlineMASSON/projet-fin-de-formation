<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221115152341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coach (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, swim TINYINT(1) NOT NULL, bike TINYINT(1) NOT NULL, run TINYINT(1) NOT NULL, experience LONGTEXT DEFAULT NULL, is_available TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_3F596DCCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE collaboration (id INT AUTO_INCREMENT NOT NULL, coach_id INT NOT NULL, triathlete_id INT NOT NULL, sport VARCHAR(255) NOT NULL, approved TINYINT(1) NOT NULL, INDEX IDX_DA3AE3233C105691 (coach_id), INDEX IDX_DA3AE3238B3044BB (triathlete_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, training_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_794381C6A76ED395 (user_id), INDEX IDX_794381C6BEFD98D1 (training_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, triathlete_id INT NOT NULL, is_validated TINYINT(1) NOT NULL, title VARCHAR(255) NOT NULL, duration INT NOT NULL, date DATE NOT NULL, sport VARCHAR(255) NOT NULL, is_ppg TINYINT(1) NOT NULL, type VARCHAR(255) NOT NULL, tag VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, feeling VARCHAR(255) DEFAULT NULL, INDEX IDX_D5128A8FA76ED395 (user_id), INDEX IDX_D5128A8F8B3044BB (triathlete_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE triathlete (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, palmares LONGTEXT DEFAULT NULL, weight INT DEFAULT NULL, size INT DEFAULT NULL, UNIQUE INDEX UNIQ_508E4108A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, profile INT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, date_birth DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', description LONGTEXT DEFAULT NULL, picture LONGTEXT DEFAULT NULL, gender INT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE coach ADD CONSTRAINT FK_3F596DCCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE collaboration ADD CONSTRAINT FK_DA3AE3233C105691 FOREIGN KEY (coach_id) REFERENCES coach (id)');
        $this->addSql('ALTER TABLE collaboration ADD CONSTRAINT FK_DA3AE3238B3044BB FOREIGN KEY (triathlete_id) REFERENCES triathlete (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F8B3044BB FOREIGN KEY (triathlete_id) REFERENCES triathlete (id)');
        $this->addSql('ALTER TABLE triathlete ADD CONSTRAINT FK_508E4108A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coach DROP FOREIGN KEY FK_3F596DCCA76ED395');
        $this->addSql('ALTER TABLE collaboration DROP FOREIGN KEY FK_DA3AE3233C105691');
        $this->addSql('ALTER TABLE collaboration DROP FOREIGN KEY FK_DA3AE3238B3044BB');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6A76ED395');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6BEFD98D1');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8FA76ED395');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8F8B3044BB');
        $this->addSql('ALTER TABLE triathlete DROP FOREIGN KEY FK_508E4108A76ED395');
        $this->addSql('DROP TABLE coach');
        $this->addSql('DROP TABLE collaboration');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE triathlete');
        $this->addSql('DROP TABLE user');
    }
}
