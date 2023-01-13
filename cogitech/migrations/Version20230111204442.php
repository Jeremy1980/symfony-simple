<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230111204442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, name varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");

        $this->addSql("CREATE TABLE `posts` (`id` int NOT NULL,`user_id` int NOT NULL,`title` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,`body` longtext COLLATE utf8mb4_unicode_ci NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        $this->addSql("CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");

        $this->addSql("INSERT INTO `user` (`id`, `name`, `email`, `roles`, `password`) VALUES  (1, 'admin', 'admin@kozacki.pl', '{\"role\": \"ROLE_ADMIN\"}', '$2y$13$7ZhfxGdk2M2VLGVJWhEk1u0xgTQWApFG2CuLyKiUFKwyOzotLk7zC')");

        $this->addSql("ALTER TABLE `posts` ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);");
        $this->addSql("ALTER TABLE `posts` MODIFY `id` int NOT NULL AUTO_INCREMENT;");
        $this->addSql("ALTER TABLE `posts` ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE NO ACTION;");

    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE `user`");
        $this->addSql("DROP TABLE `posts`");
        $this->addSql("DROP TABLE messenger_messages");
    }
}
