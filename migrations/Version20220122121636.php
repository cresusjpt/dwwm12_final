<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220122121636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455C2BB5B57 FOREIGN KEY (etre_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455263DA5A FOREIGN KEY (etrede_id) REFERENCES user (id)');
        //$this->addSql('CREATE INDEX IDX_C7440455C2BB5B57 ON client (etre_id)');
        $this->addSql('CREATE INDEX IDX_C7440455263DA5A ON client (etrede_id)');
        //$this->addSql('DROP INDEX IDX_C7440455C2BB5B57 ON user');
        $this->addSql('ALTER TABLE user DROP etre_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        //$this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455C2BB5B57');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455263DA5A');
        //$this->addSql('DROP INDEX IDX_C7440455C2BB5B57 ON client');
        $this->addSql('DROP INDEX IDX_C7440455263DA5A ON client');
        //$this->addSql('ALTER TABLE user ADD etre_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_C7440455C2BB5B57 ON user (etre_id)');
    }
}
