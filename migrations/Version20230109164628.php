<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230109164628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question_game (question_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_7DC5DC631E27F6BF (question_id), INDEX IDX_7DC5DC63E48FD905 (game_id), PRIMARY KEY(question_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_tag (question_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_339D56FB1E27F6BF (question_id), INDEX IDX_339D56FBBAD26311 (tag_id), PRIMARY KEY(question_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_user (question_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D37D3BA61E27F6BF (question_id), INDEX IDX_D37D3BA6A76ED395 (user_id), PRIMARY KEY(question_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question_game ADD CONSTRAINT FK_7DC5DC631E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_game ADD CONSTRAINT FK_7DC5DC63E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_tag ADD CONSTRAINT FK_339D56FB1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_tag ADD CONSTRAINT FK_339D56FBBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_user ADD CONSTRAINT FK_D37D3BA61E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_user ADD CONSTRAINT FK_D37D3BA6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_232B318CA76ED395 ON game (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_game DROP FOREIGN KEY FK_7DC5DC631E27F6BF');
        $this->addSql('ALTER TABLE question_game DROP FOREIGN KEY FK_7DC5DC63E48FD905');
        $this->addSql('ALTER TABLE question_tag DROP FOREIGN KEY FK_339D56FB1E27F6BF');
        $this->addSql('ALTER TABLE question_tag DROP FOREIGN KEY FK_339D56FBBAD26311');
        $this->addSql('ALTER TABLE question_user DROP FOREIGN KEY FK_D37D3BA61E27F6BF');
        $this->addSql('ALTER TABLE question_user DROP FOREIGN KEY FK_D37D3BA6A76ED395');
        $this->addSql('DROP TABLE question_game');
        $this->addSql('DROP TABLE question_tag');
        $this->addSql('DROP TABLE question_user');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CA76ED395');
        $this->addSql('DROP INDEX IDX_232B318CA76ED395 ON game');
        $this->addSql('ALTER TABLE game DROP user_id');
    }
}
