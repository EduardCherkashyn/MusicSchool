<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181214172020 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE schedule_lesson (id INT AUTO_INCREMENT NOT NULL, student_id INT DEFAULT NULL, day_of_the_week VARCHAR(255) NOT NULL, time TIME NOT NULL, INDEX IDX_9A5530ECCB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, student_id INT DEFAULT NULL, date DATE NOT NULL, homework LONGTEXT NOT NULL, attendance TINYINT(1) DEFAULT NULL, mark INT DEFAULT NULL, mark_comment LONGTEXT DEFAULT NULL, INDEX IDX_F87474F3CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE schedule_lesson ADD CONSTRAINT FK_9A5530ECCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE schedule_lesson DROP FOREIGN KEY FK_9A5530ECCB944F1A');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F3CB944F1A');
        $this->addSql('DROP TABLE schedule_lesson');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE student');
    }
}
