<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221227114719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create field public_id in petition entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE petition ADD public_id TEXT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FF598B03B5B48B91 ON petition (public_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_FF598B03B5B48B91 ON petition');
        $this->addSql('ALTER TABLE petition DROP public_id');
    }
}
