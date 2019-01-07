<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190107180348 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_794381C6567F5183');
        $this->addSql('DROP INDEX IDX_794381C6F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__review AS SELECT id, author_id, film_id, rate, published_at FROM review');
        $this->addSql('DROP TABLE review');
        $this->addSql('CREATE TABLE review (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, film_id INTEGER DEFAULT NULL, rate INTEGER NOT NULL, published_at DATETIME NOT NULL, CONSTRAINT FK_794381C6F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_794381C6567F5183 FOREIGN KEY (film_id) REFERENCES film (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO review (id, author_id, film_id, rate, published_at) SELECT id, author_id, film_id, rate, published_at FROM __temp__review');
        $this->addSql('DROP TABLE __temp__review');
        $this->addSql('CREATE INDEX IDX_794381C6567F5183 ON review (film_id)');
        $this->addSql('CREATE INDEX IDX_794381C6F675F31B ON review (author_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, email, password, roles, created_at, enabled FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL COLLATE BINARY, email VARCHAR(255) NOT NULL COLLATE BINARY, password VARCHAR(255) NOT NULL COLLATE BINARY, roles CLOB NOT NULL COLLATE BINARY --(DC2Type:json)
        , created_at DATETIME NOT NULL, enabled BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO user (id, username, email, password, roles, created_at, enabled) SELECT id, username, email, password, roles, created_at, enabled FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677E7927C74 ON user (username, email)');
        $this->addSql('DROP INDEX IDX_8B4CAD16567F5183');
        $this->addSql('DROP INDEX IDX_8B4CAD16446F285F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__films_studios AS SELECT film_id, studio_id FROM films_studios');
        $this->addSql('DROP TABLE films_studios');
        $this->addSql('CREATE TABLE films_studios (film_id INTEGER NOT NULL, studio_id INTEGER NOT NULL, PRIMARY KEY(studio_id, film_id), CONSTRAINT FK_8B4CAD16446F285F FOREIGN KEY (studio_id) REFERENCES studio (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8B4CAD16567F5183 FOREIGN KEY (film_id) REFERENCES film (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO films_studios (film_id, studio_id) SELECT film_id, studio_id FROM __temp__films_studios');
        $this->addSql('DROP TABLE __temp__films_studios');
        $this->addSql('CREATE INDEX IDX_8B4CAD16567F5183 ON films_studios (film_id)');
        $this->addSql('CREATE INDEX IDX_8B4CAD16446F285F ON films_studios (studio_id)');
        $this->addSql('DROP INDEX UNIQ_8244BE222B36786B5373C966');
        $this->addSql('DROP INDEX IDX_8244BE2289B658FE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__film AS SELECT id, producer_id, release_year, title, country, description, budget, has_subtitles, duration_seconds, published_at, poster_img, source_path FROM film');
        $this->addSql('DROP TABLE film');
        $this->addSql('CREATE TABLE film (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, producer_id INTEGER DEFAULT NULL, release_year INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, country VARCHAR(255) DEFAULT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, budget NUMERIC(7, 2) DEFAULT NULL, has_subtitles BOOLEAN NOT NULL, duration_seconds INTEGER NOT NULL, published_at DATETIME NOT NULL, poster_img CLOB NOT NULL COLLATE BINARY, source_path VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_8244BE2289B658FE FOREIGN KEY (producer_id) REFERENCES producer (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO film (id, producer_id, release_year, title, country, description, budget, has_subtitles, duration_seconds, published_at, poster_img, source_path) SELECT id, producer_id, release_year, title, country, description, budget, has_subtitles, duration_seconds, published_at, poster_img, source_path FROM __temp__film');
        $this->addSql('DROP TABLE __temp__film');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8244BE222B36786B5373C966 ON film (title, country)');
        $this->addSql('CREATE INDEX IDX_8244BE2289B658FE ON film (producer_id)');
        $this->addSql('DROP INDEX IDX_BB8FA693567F5183');
        $this->addSql('DROP INDEX IDX_BB8FA69310DAF24A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__actors_films AS SELECT actor_id, film_id FROM actors_films');
        $this->addSql('DROP TABLE actors_films');
        $this->addSql('CREATE TABLE actors_films (actor_id INTEGER NOT NULL, film_id INTEGER NOT NULL, PRIMARY KEY(actor_id, film_id), CONSTRAINT FK_BB8FA69310DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_BB8FA693567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO actors_films (actor_id, film_id) SELECT actor_id, film_id FROM __temp__actors_films');
        $this->addSql('DROP TABLE __temp__actors_films');
        $this->addSql('CREATE INDEX IDX_BB8FA693567F5183 ON actors_films (film_id)');
        $this->addSql('CREATE INDEX IDX_BB8FA69310DAF24A ON actors_films (actor_id)');
        $this->addSql('DROP INDEX IDX_AEAFCDA0B3EC99FE');
        $this->addSql('DROP INDEX IDX_AEAFCDA0567F5183');
        $this->addSql('CREATE TEMPORARY TABLE __temp__films_achievements AS SELECT achievement_id, film_id FROM films_achievements');
        $this->addSql('DROP TABLE films_achievements');
        $this->addSql('CREATE TABLE films_achievements (achievement_id INTEGER NOT NULL, film_id INTEGER NOT NULL, PRIMARY KEY(achievement_id, film_id), CONSTRAINT FK_AEAFCDA0B3EC99FE FOREIGN KEY (achievement_id) REFERENCES achievement (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_AEAFCDA0567F5183 FOREIGN KEY (film_id) REFERENCES film (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO films_achievements (achievement_id, film_id) SELECT achievement_id, film_id FROM __temp__films_achievements');
        $this->addSql('DROP TABLE __temp__films_achievements');
        $this->addSql('CREATE INDEX IDX_AEAFCDA0B3EC99FE ON films_achievements (achievement_id)');
        $this->addSql('CREATE INDEX IDX_AEAFCDA0567F5183 ON films_achievements (film_id)');
        $this->addSql('DROP INDEX IDX_1FBF6EAF567F5183');
        $this->addSql('DROP INDEX IDX_1FBF6EAF4296D31F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__films_genres AS SELECT genre_id, film_id FROM films_genres');
        $this->addSql('DROP TABLE films_genres');
        $this->addSql('CREATE TABLE films_genres (genre_id INTEGER NOT NULL, film_id INTEGER NOT NULL, PRIMARY KEY(genre_id, film_id), CONSTRAINT FK_1FBF6EAF4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1FBF6EAF567F5183 FOREIGN KEY (film_id) REFERENCES film (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO films_genres (genre_id, film_id) SELECT genre_id, film_id FROM __temp__films_genres');
        $this->addSql('DROP TABLE __temp__films_genres');
        $this->addSql('CREATE INDEX IDX_1FBF6EAF567F5183 ON films_genres (film_id)');
        $this->addSql('CREATE INDEX IDX_1FBF6EAF4296D31F ON films_genres (genre_id)');
        $this->addSql('DROP INDEX IDX_9474526C567F5183');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, user_id, film_id, content, published_at FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, film_id INTEGER NOT NULL, content CLOB NOT NULL COLLATE BINARY, published_at DATETIME NOT NULL, CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526C567F5183 FOREIGN KEY (film_id) REFERENCES film (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, user_id, film_id, content, published_at) SELECT id, user_id, film_id, content, published_at FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C567F5183 ON comment (film_id)');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('DROP INDEX IDX_C691DC4E567F5183');
        $this->addSql('CREATE TEMPORARY TABLE __temp__trailer AS SELECT id, film_id, title, duration, source_path FROM trailer');
        $this->addSql('DROP TABLE trailer');
        $this->addSql('CREATE TABLE trailer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, film_id INTEGER DEFAULT NULL, title VARCHAR(255) DEFAULT NULL COLLATE BINARY, duration INTEGER NOT NULL, source_path VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_C691DC4E567F5183 FOREIGN KEY (film_id) REFERENCES film (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO trailer (id, film_id, title, duration, source_path) SELECT id, film_id, title, duration, source_path FROM __temp__trailer');
        $this->addSql('DROP TABLE __temp__trailer');
        $this->addSql('CREATE INDEX IDX_C691DC4E567F5183 ON trailer (film_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_BB8FA69310DAF24A');
        $this->addSql('DROP INDEX IDX_BB8FA693567F5183');
        $this->addSql('CREATE TEMPORARY TABLE __temp__actors_films AS SELECT actor_id, film_id FROM actors_films');
        $this->addSql('DROP TABLE actors_films');
        $this->addSql('CREATE TABLE actors_films (actor_id INTEGER NOT NULL, film_id INTEGER NOT NULL, PRIMARY KEY(actor_id, film_id))');
        $this->addSql('INSERT INTO actors_films (actor_id, film_id) SELECT actor_id, film_id FROM __temp__actors_films');
        $this->addSql('DROP TABLE __temp__actors_films');
        $this->addSql('CREATE INDEX IDX_BB8FA69310DAF24A ON actors_films (actor_id)');
        $this->addSql('CREATE INDEX IDX_BB8FA693567F5183 ON actors_films (film_id)');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395');
        $this->addSql('DROP INDEX IDX_9474526C567F5183');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, user_id, film_id, content, published_at FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, film_id INTEGER NOT NULL, content CLOB NOT NULL, published_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO comment (id, user_id, film_id, content, published_at) SELECT id, user_id, film_id, content, published_at FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526C567F5183 ON comment (film_id)');
        $this->addSql('DROP INDEX IDX_8244BE2289B658FE');
        $this->addSql('DROP INDEX UNIQ_8244BE222B36786B5373C966');
        $this->addSql('CREATE TEMPORARY TABLE __temp__film AS SELECT id, producer_id, release_year, title, country, description, budget, source_path, has_subtitles, duration_seconds, poster_img, published_at FROM film');
        $this->addSql('DROP TABLE film');
        $this->addSql('CREATE TABLE film (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, producer_id INTEGER DEFAULT NULL, release_year INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, country VARCHAR(255) DEFAULT NULL, description CLOB NOT NULL, budget NUMERIC(7, 2) DEFAULT NULL, source_path VARCHAR(255) NOT NULL, has_subtitles BOOLEAN NOT NULL, duration_seconds INTEGER NOT NULL, poster_img CLOB NOT NULL, published_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO film (id, producer_id, release_year, title, country, description, budget, source_path, has_subtitles, duration_seconds, poster_img, published_at) SELECT id, producer_id, release_year, title, country, description, budget, source_path, has_subtitles, duration_seconds, poster_img, published_at FROM __temp__film');
        $this->addSql('DROP TABLE __temp__film');
        $this->addSql('CREATE INDEX IDX_8244BE2289B658FE ON film (producer_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8244BE222B36786B5373C966 ON film (title, country)');
        $this->addSql('DROP INDEX IDX_AEAFCDA0B3EC99FE');
        $this->addSql('DROP INDEX IDX_AEAFCDA0567F5183');
        $this->addSql('CREATE TEMPORARY TABLE __temp__films_achievements AS SELECT achievement_id, film_id FROM films_achievements');
        $this->addSql('DROP TABLE films_achievements');
        $this->addSql('CREATE TABLE films_achievements (achievement_id INTEGER NOT NULL, film_id INTEGER NOT NULL, PRIMARY KEY(achievement_id, film_id))');
        $this->addSql('INSERT INTO films_achievements (achievement_id, film_id) SELECT achievement_id, film_id FROM __temp__films_achievements');
        $this->addSql('DROP TABLE __temp__films_achievements');
        $this->addSql('CREATE INDEX IDX_AEAFCDA0B3EC99FE ON films_achievements (achievement_id)');
        $this->addSql('CREATE INDEX IDX_AEAFCDA0567F5183 ON films_achievements (film_id)');
        $this->addSql('DROP INDEX IDX_1FBF6EAF4296D31F');
        $this->addSql('DROP INDEX IDX_1FBF6EAF567F5183');
        $this->addSql('CREATE TEMPORARY TABLE __temp__films_genres AS SELECT genre_id, film_id FROM films_genres');
        $this->addSql('DROP TABLE films_genres');
        $this->addSql('CREATE TABLE films_genres (genre_id INTEGER NOT NULL, film_id INTEGER NOT NULL, PRIMARY KEY(genre_id, film_id))');
        $this->addSql('INSERT INTO films_genres (genre_id, film_id) SELECT genre_id, film_id FROM __temp__films_genres');
        $this->addSql('DROP TABLE __temp__films_genres');
        $this->addSql('CREATE INDEX IDX_1FBF6EAF4296D31F ON films_genres (genre_id)');
        $this->addSql('CREATE INDEX IDX_1FBF6EAF567F5183 ON films_genres (film_id)');
        $this->addSql('DROP INDEX IDX_8B4CAD16446F285F');
        $this->addSql('DROP INDEX IDX_8B4CAD16567F5183');
        $this->addSql('CREATE TEMPORARY TABLE __temp__films_studios AS SELECT studio_id, film_id FROM films_studios');
        $this->addSql('DROP TABLE films_studios');
        $this->addSql('CREATE TABLE films_studios (studio_id INTEGER NOT NULL, film_id INTEGER NOT NULL, PRIMARY KEY(studio_id, film_id))');
        $this->addSql('INSERT INTO films_studios (studio_id, film_id) SELECT studio_id, film_id FROM __temp__films_studios');
        $this->addSql('DROP TABLE __temp__films_studios');
        $this->addSql('CREATE INDEX IDX_8B4CAD16446F285F ON films_studios (studio_id)');
        $this->addSql('CREATE INDEX IDX_8B4CAD16567F5183 ON films_studios (film_id)');
        $this->addSql('DROP INDEX IDX_794381C6F675F31B');
        $this->addSql('DROP INDEX IDX_794381C6567F5183');
        $this->addSql('CREATE TEMPORARY TABLE __temp__review AS SELECT id, author_id, film_id, rate, published_at FROM review');
        $this->addSql('DROP TABLE review');
        $this->addSql('CREATE TABLE review (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, film_id INTEGER DEFAULT NULL, rate INTEGER NOT NULL, published_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO review (id, author_id, film_id, rate, published_at) SELECT id, author_id, film_id, rate, published_at FROM __temp__review');
        $this->addSql('DROP TABLE __temp__review');
        $this->addSql('CREATE INDEX IDX_794381C6F675F31B ON review (author_id)');
        $this->addSql('CREATE INDEX IDX_794381C6567F5183 ON review (film_id)');
        $this->addSql('DROP INDEX IDX_C691DC4E567F5183');
        $this->addSql('CREATE TEMPORARY TABLE __temp__trailer AS SELECT id, film_id, duration, title, source_path FROM trailer');
        $this->addSql('DROP TABLE trailer');
        $this->addSql('CREATE TABLE trailer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, film_id INTEGER DEFAULT NULL, duration INTEGER NOT NULL, title VARCHAR(255) DEFAULT NULL, source_path VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO trailer (id, film_id, duration, title, source_path) SELECT id, film_id, duration, title, source_path FROM __temp__trailer');
        $this->addSql('DROP TABLE __temp__trailer');
        $this->addSql('CREATE INDEX IDX_C691DC4E567F5183 ON trailer (film_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, email, password, roles, created_at, enabled FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , created_at DATETIME NOT NULL, enabled BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO user (id, username, email, password, roles, created_at, enabled) SELECT id, username, email, password, roles, created_at, enabled FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
