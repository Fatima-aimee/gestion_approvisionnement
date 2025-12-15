<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251215144415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE approvisionnement (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, date DATETIME NOT NULL, statut VARCHAR(255) NOT NULL, total INT NOT NULL, fournisseur_id INT NOT NULL, INDEX IDX_516C3FAA670C757F (fournisseur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, prix INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE ligne_appro (id INT AUTO_INCREMENT NOT NULL, quantite INT NOT NULL, prix_unitaire INT NOT NULL, article_id INT NOT NULL, approvisionnement_id INT NOT NULL, INDEX IDX_9E16ECA17294869C (article_id), INDEX IDX_9E16ECA1AE741A98 (approvisionnement_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE approvisionnement ADD CONSTRAINT FK_516C3FAA670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE ligne_appro ADD CONSTRAINT FK_9E16ECA17294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE ligne_appro ADD CONSTRAINT FK_9E16ECA1AE741A98 FOREIGN KEY (approvisionnement_id) REFERENCES approvisionnement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE approvisionnement DROP FOREIGN KEY FK_516C3FAA670C757F');
        $this->addSql('ALTER TABLE ligne_appro DROP FOREIGN KEY FK_9E16ECA17294869C');
        $this->addSql('ALTER TABLE ligne_appro DROP FOREIGN KEY FK_9E16ECA1AE741A98');
        $this->addSql('DROP TABLE approvisionnement');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE ligne_appro');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
