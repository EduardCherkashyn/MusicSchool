<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200412171623 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE youtube_link (id INT AUTO_INCREMENT NOT NULL, lesson_id_id INT NOT NULL, path VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_B13E81D7B548B0F (path), INDEX IDX_B13E81D735A24AD0 (lesson_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE youtube_link ADD CONSTRAINT FK_B13E81D735A24AD0 FOREIGN KEY (lesson_id_id) REFERENCES lesson (id)');
        $this->addSql('DROP INDEX UNIQ_F87474F3B13E81D7 ON lesson');
        $this->addSql('ALTER TABLE lesson DROP youtube_link');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE youtube_link');
        $this->addSql('ALTER TABLE lesson ADD youtube_link VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F87474F3B13E81D7 ON lesson (youtube_link)');
    }
}
