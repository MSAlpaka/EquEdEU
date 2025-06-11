<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801001000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table for course feedback';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('tx_equedlms_domain_model_coursefeedback');
        $table->addColumn('uid', 'integer')->setAutoincrement(true);
        $table->addColumn('pid', 'integer');
        $table->addColumn('uuid', 'string');
        $table->addColumn('user_course_record', 'integer');
        $table->addColumn('submitted_by_user', 'integer');
        $table->addColumn('rating_instructor', 'integer');
        $table->addColumn('rating_training_location', 'integer');
        $table->addColumn('rating_overall', 'integer');
        $table->addColumn('standard_coverage_confirmed', 'boolean');
        $table->addColumn('wants_followup_info', 'boolean');
        $table->addColumn('is_visible_to_instructor', 'boolean');
        $table->addColumn('is_visible_to_training_center', 'boolean');
        $table->addColumn('language', 'string');
        $table->addColumn('comment', 'text', ['notnull' => false]);
        $table->addColumn('course_wishes', 'text', ['notnull' => false]);
        $table->addColumn('status', 'string');
        $table->addColumn('created_at', 'integer');
        $table->addColumn('updated_at', 'integer');
        $table->setPrimaryKey(['uid']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('tx_equedlms_domain_model_coursefeedback');
    }
}
