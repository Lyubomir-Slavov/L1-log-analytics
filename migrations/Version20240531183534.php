<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240531183534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX IDX_B5F762D9060CAEA ON log_entry (service_name)');
        $this->addSql('CREATE INDEX IDX_B5F762D4F139D0C ON log_entry (status_code)');
        $this->addSql('CREATE INDEX IDX_B5F762DAA9E377A ON log_entry (date)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_B5F762D9060CAEA ON log_entry');
        $this->addSql('DROP INDEX IDX_B5F762D4F139D0C ON log_entry');
        $this->addSql('DROP INDEX IDX_B5F762DAA9E377A ON log_entry');
    }
}
