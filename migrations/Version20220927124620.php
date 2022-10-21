<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220927124620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE details_devis ADD CONSTRAINT FK_1BC863C441DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id)');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B829D7B75 FOREIGN KEY (ease_car_id) REFERENCES easeandcar (id)');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('DROP INDEX IDX_9E7D15901823061F ON galerie');
        $this->addSql('ALTER TABLE galerie ADD contrat VARCHAR(255) DEFAULT NULL, DROP contrat_id');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68C66C5C062 FOREIGN KEY (relation_devis_id) REFERENCES devis (id)');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68CDC7649A5 FOREIGN KEY (relation_client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68C7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68C1823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE details_devis DROP FOREIGN KEY FK_1BC863C441DEFADA');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B829D7B75');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B19EB6921');
        $this->addSql('ALTER TABLE galerie ADD contrat_id INT DEFAULT NULL, DROP contrat');
        $this->addSql('CREATE INDEX IDX_9E7D15901823061F ON galerie (contrat_id)');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68C66C5C062');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68CDC7649A5');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68C7F2DEE08');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68C1823061F');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
    }
}
