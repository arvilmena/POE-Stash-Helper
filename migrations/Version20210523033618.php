<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210523033618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE poeaffix (id INT AUTO_INCREMENT NOT NULL, group_name VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, a_mod_grp VARCHAR(255) DEFAULT NULL, coe_affix_id INT DEFAULT NULL, regex_pattern VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poebase_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poebase_group_affixes (id INT AUTO_INCREMENT NOT NULL, base_group_id INT NOT NULL, poe_affix_id INT NOT NULL, INDEX IDX_B3CC4E8CB4BF7ABF (base_group_id), INDEX IDX_B3CC4E8C8FB5D026 (poe_affix_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poebase_group_affixes_tier (id INT AUTO_INCREMENT NOT NULL, base_group_affixes_id INT NOT NULL, poe_affix_id INT NOT NULL, name VARCHAR(255) NOT NULL, tier INT DEFAULT NULL, ilvl INT DEFAULT NULL, min NUMERIC(10, 0) NOT NULL, max NUMERIC(10, 0) NOT NULL, INDEX IDX_213B07534F9537CA (base_group_affixes_id), INDEX IDX_213B07538FB5D026 (poe_affix_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poeitem (id INT AUTO_INCREMENT NOT NULL, base_group_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E72BB0E5B4BF7ABF (base_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE poebase_group_affixes ADD CONSTRAINT FK_B3CC4E8CB4BF7ABF FOREIGN KEY (base_group_id) REFERENCES poebase_group (id)');
        $this->addSql('ALTER TABLE poebase_group_affixes ADD CONSTRAINT FK_B3CC4E8C8FB5D026 FOREIGN KEY (poe_affix_id) REFERENCES poeaffix (id)');
        $this->addSql('ALTER TABLE poebase_group_affixes_tier ADD CONSTRAINT FK_213B07534F9537CA FOREIGN KEY (base_group_affixes_id) REFERENCES poebase_group_affixes (id)');
        $this->addSql('ALTER TABLE poebase_group_affixes_tier ADD CONSTRAINT FK_213B07538FB5D026 FOREIGN KEY (poe_affix_id) REFERENCES poeaffix (id)');
        $this->addSql('ALTER TABLE poeitem ADD CONSTRAINT FK_E72BB0E5B4BF7ABF FOREIGN KEY (base_group_id) REFERENCES poebase_group (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poebase_group_affixes DROP FOREIGN KEY FK_B3CC4E8C8FB5D026');
        $this->addSql('ALTER TABLE poebase_group_affixes_tier DROP FOREIGN KEY FK_213B07538FB5D026');
        $this->addSql('ALTER TABLE poebase_group_affixes DROP FOREIGN KEY FK_B3CC4E8CB4BF7ABF');
        $this->addSql('ALTER TABLE poeitem DROP FOREIGN KEY FK_E72BB0E5B4BF7ABF');
        $this->addSql('ALTER TABLE poebase_group_affixes_tier DROP FOREIGN KEY FK_213B07534F9537CA');
        $this->addSql('DROP TABLE poeaffix');
        $this->addSql('DROP TABLE poebase_group');
        $this->addSql('DROP TABLE poebase_group_affixes');
        $this->addSql('DROP TABLE poebase_group_affixes_tier');
        $this->addSql('DROP TABLE poeitem');
    }
}
