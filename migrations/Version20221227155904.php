<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221227155904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create petition and signature databases';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE petition (
                id INT AUTO_INCREMENT NOT NULL,
                title VARCHAR(255) NOT NULL,
                text LONGTEXT NOT NULL,
                subtitle VARCHAR(255) NOT NULL,
                target VARCHAR(255) NOT NULL,
                author VARCHAR(255) NOT NULL,
                target_to_whom VARCHAR(255) NOT NULL,
                author_to_whom VARCHAR(255) NOT NULL,
                public_id VARCHAR(255) NOT NULL,
                UNIQUE INDEX UNIQ_FF598B03B5B48B91 (public_id),
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE signature (
            id INT AUTO_INCREMENT NOT NULL,
            petition_id INT NOT NULL,
            name VARCHAR(255) NOT NULL,
            surname VARCHAR(255) NOT NULL,
            patronymic VARCHAR(255) DEFAULT NULL,
            email VARCHAR(255) NOT NULL,
            signature_writing MEDIUMTEXT NOT NULL,
            signing_date DATE NOT NULL,
            INDEX IDX_AE880141AEC7D346 (petition_id),
            PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE signature ADD CONSTRAINT FK_AE880141AEC7D346 FOREIGN KEY (petition_id) REFERENCES petition (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE signature DROP FOREIGN KEY FK_AE880141AEC7D346');
        $this->addSql('DROP TABLE petition');
        $this->addSql('DROP TABLE signature');
    }
}
