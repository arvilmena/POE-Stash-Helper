<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210523062341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poebase_group_affixes ADD prefix_or_suffix VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE poebase_group_affixes_tier DROP FOREIGN KEY FK_213B07538FB5D026');
        $this->addSql('DROP INDEX IDX_213B07538FB5D026 ON poebase_group_affixes_tier');
        $this->addSql('ALTER TABLE poebase_group_affixes_tier DROP poe_affix_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poebase_group_affixes DROP prefix_or_suffix');
        $this->addSql('ALTER TABLE poebase_group_affixes_tier ADD poe_affix_id INT NOT NULL');
        $this->addSql('ALTER TABLE poebase_group_affixes_tier ADD CONSTRAINT FK_213B07538FB5D026 FOREIGN KEY (poe_affix_id) REFERENCES poeaffix (id)');
        $this->addSql('CREATE INDEX IDX_213B07538FB5D026 ON poebase_group_affixes_tier (poe_affix_id)');
    }
}
