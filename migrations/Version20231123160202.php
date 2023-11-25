<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231123160202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE goal_workout_plan (goal_id INTEGER NOT NULL, workout_plan_id INTEGER NOT NULL, PRIMARY KEY(goal_id, workout_plan_id), CONSTRAINT FK_8025CC60667D1AFE FOREIGN KEY (goal_id) REFERENCES goal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8025CC60945F6E33 FOREIGN KEY (workout_plan_id) REFERENCES workout_plan (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8025CC60667D1AFE ON goal_workout_plan (goal_id)');
        $this->addSql('CREATE INDEX IDX_8025CC60945F6E33 ON goal_workout_plan (workout_plan_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE goal_workout_plan');
    }
}
