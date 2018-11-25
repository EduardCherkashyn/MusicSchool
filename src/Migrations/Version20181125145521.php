<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181125145521 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE schedule_lesson ADD student_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE schedule_lesson ADD CONSTRAINT FK_9A5530ECCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('CREATE INDEX IDX_9A5530ECCB944F1A ON schedule_lesson (student_id)');
        $this->addSql('ALTER TABLE lesson ADD student_id INT DEFAULT NULL, DROP student');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('CREATE INDEX IDX_F87474F3CB944F1A ON lesson (student_id)');
        $this->addSql('ALTER TABLE student DROP lessons');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F3CB944F1A');
        $this->addSql('DROP INDEX IDX_F87474F3CB944F1A ON lesson');
        $this->addSql('ALTER TABLE lesson ADD student LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:object)\', DROP student_id');
        $this->addSql('ALTER TABLE schedule_lesson DROP FOREIGN KEY FK_9A5530ECCB944F1A');
        $this->addSql('DROP INDEX IDX_9A5530ECCB944F1A ON schedule_lesson');
        $this->addSql('ALTER TABLE schedule_lesson DROP student_id');
        $this->addSql('ALTER TABLE student ADD lessons LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\'');
    }
}
