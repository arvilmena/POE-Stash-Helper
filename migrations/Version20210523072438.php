<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210523072438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE poeaffix (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, a_mod_grp VARCHAR(255) DEFAULT NULL, coe_affix_id INT DEFAULT NULL, regex_pattern VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poebase (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poebase_affixes (id INT AUTO_INCREMENT NOT NULL, base_id INT NOT NULL, poe_affix_id INT NOT NULL, prefix_or_suffix VARCHAR(255) DEFAULT NULL, affix_group_name VARCHAR(255) DEFAULT NULL, INDEX IDX_E2F13C526967DF41 (base_id), INDEX IDX_E2F13C528FB5D026 (poe_affix_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poebase_affixes_tier (id INT AUTO_INCREMENT NOT NULL, base_affixes_id INT NOT NULL, name VARCHAR(255) NOT NULL, tier INT DEFAULT NULL, ilvl INT DEFAULT NULL, min NUMERIC(10, 0) DEFAULT NULL, max NUMERIC(10, 0) DEFAULT NULL, INDEX IDX_59DBB4AA3FEFE8D1 (base_affixes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poeitem (id INT AUTO_INCREMENT NOT NULL, base_group_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E72BB0E5B4BF7ABF (base_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE poebase_affixes ADD CONSTRAINT FK_E2F13C526967DF41 FOREIGN KEY (base_id) REFERENCES poebase (id)');
        $this->addSql('ALTER TABLE poebase_affixes ADD CONSTRAINT FK_E2F13C528FB5D026 FOREIGN KEY (poe_affix_id) REFERENCES poeaffix (id)');
        $this->addSql('ALTER TABLE poebase_affixes_tier ADD CONSTRAINT FK_59DBB4AA3FEFE8D1 FOREIGN KEY (base_affixes_id) REFERENCES poebase_affixes (id)');
        $this->addSql('ALTER TABLE poeitem ADD CONSTRAINT FK_E72BB0E5B4BF7ABF FOREIGN KEY (base_group_id) REFERENCES poebase (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poebase_affixes DROP FOREIGN KEY FK_E2F13C528FB5D026');
        $this->addSql('ALTER TABLE poebase_affixes DROP FOREIGN KEY FK_E2F13C526967DF41');
        $this->addSql('ALTER TABLE poeitem DROP FOREIGN KEY FK_E72BB0E5B4BF7ABF');
        $this->addSql('ALTER TABLE poebase_affixes_tier DROP FOREIGN KEY FK_59DBB4AA3FEFE8D1');
        $this->addSql('DROP TABLE poeaffix');
        $this->addSql('DROP TABLE poebase');
        $this->addSql('DROP TABLE poebase_affixes');
        $this->addSql('DROP TABLE poebase_affixes_tier');
        $this->addSql('DROP TABLE poeitem');
    }
}
