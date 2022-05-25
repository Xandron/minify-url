<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220524153743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE minification (id INT UNSIGNED AUTO_INCREMENT NOT NULL COMMENT \'ID\', origin_url VARCHAR(255) NOT NULL COMMENT \'Original url\', short_url VARCHAR(255) NOT NULL COMMENT \'Short url\', expired DATETIME NOT NULL COMMENT \'Life time short url\', created DATETIME DEFAULT NULL COMMENT \'Дата создания\', updated DATETIME DEFAULT NULL COMMENT \'Дата редактирования\', UNIQUE INDEX UNIQ_10F37F5883360531 (short_url), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statistic (id INT UNSIGNED AUTO_INCREMENT NOT NULL COMMENT \'ID\', minification_id INT UNSIGNED DEFAULT NULL COMMENT \'ID\', transitions_count INT NOT NULL COMMENT \'Number of transitions\', created DATETIME DEFAULT NULL COMMENT \'Дата создания\', updated DATETIME DEFAULT NULL COMMENT \'Дата редактирования\', INDEX IDX_649B469C88FD7CB7 (minification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE statistic ADD CONSTRAINT FK_649B469C88FD7CB7 FOREIGN KEY (minification_id) REFERENCES minification (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE statistic DROP FOREIGN KEY FK_649B469C88FD7CB7');
        $this->addSql('DROP TABLE minification');
        $this->addSql('DROP TABLE statistic');
    }
}
