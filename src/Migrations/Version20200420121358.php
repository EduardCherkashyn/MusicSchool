<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200420121358 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F361041807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('CREATE INDEX IDX_8C9F361041807E1D ON file (teacher_id)');
        $this->addSql('ALTER TABLE photo ADD teacher_id INT NOT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B7841841807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('CREATE INDEX IDX_14B7841841807E1D ON photo (teacher_id)');
        $this->addSql('ALTER TABLE video ADD teacher_id INT NOT NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C41807E1D ON video (teacher_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F361041807E1D');
        $this->addSql('DROP INDEX IDX_8C9F361041807E1D ON file');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B7841841807E1D');
        $this->addSql('DROP INDEX IDX_14B7841841807E1D ON photo');
        $this->addSql('ALTER TABLE photo DROP teacher_id');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C41807E1D');
        $this->addSql('DROP INDEX IDX_7CC7DA2C41807E1D ON video');
        $this->addSql('ALTER TABLE video DROP teacher_id');
    }
}
