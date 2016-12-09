<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161209142010 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF4E8DE7170');
        $this->addSql('DROP INDEX IDX_54469DF4E8DE7170 ON tickets');
        $this->addSql('ALTER TABLE tickets CHANGE updatedby updated_by INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF416FE72E1 FOREIGN KEY (updated_by) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_54469DF416FE72E1 ON tickets (updated_by)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF416FE72E1');
        $this->addSql('DROP INDEX IDX_54469DF416FE72E1 ON tickets');
        $this->addSql('ALTER TABLE tickets CHANGE updated_by updatedBy INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4E8DE7170 FOREIGN KEY (updatedBy) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_54469DF4E8DE7170 ON tickets (updatedBy)');
    }
}
