<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221226230047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create petition entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE petition (id INT AUTO_INCREMENT NOT NULL, title LONGTEXT NOT NULL, text LONGTEXT NOT NULL, subtitle LONGTEXT NOT NULL, target LONGTEXT NOT NULL, author LONGTEXT NOT NULL, target_to_whom LONGTEXT NOT NULL, author_to_whom LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE signature ADD petition_id INT NOT NULL');
        $this->addSql('ALTER TABLE signature ADD CONSTRAINT FK_AE880141AEC7D346 FOREIGN KEY (petition_id) REFERENCES petition (id)');
        $this->addSql('CREATE INDEX IDX_AE880141AEC7D346 ON signature (petition_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE signature DROP FOREIGN KEY FK_AE880141AEC7D346');
        $this->addSql('DROP TABLE petition');
        $this->addSql('DROP INDEX IDX_AE880141AEC7D346 ON signature');
        $this->addSql('ALTER TABLE signature DROP petition_id');
    }
}
