<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801013000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table for QMS case';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('tx_equedlms_domain_model_qmscase');
        $table->addColumn('uid', 'integer')->setAutoincrement(true);
        $table->addColumn('pid', 'integer');
        $table->addColumn('uuid', 'string');
        $table->addColumn('user_course_record', 'integer');
        $table->addColumn('course_instance', 'integer');
        $table->addColumn('certifier', 'integer');
        $table->addColumn('incident_report', 'integer');
        $table->addColumn('finalized_by', 'integer');
        $table->addColumn('title', 'string');
        $table->addColumn('title_key', 'string', ['notnull' => false]);
        $table->addColumn('case_type', 'string');
        $table->addColumn('status', 'string');
        $table->addColumn('priority', 'string');
        $table->addColumn('violates_standard', 'boolean');
        $table->addColumn('standard_reference', 'string', ['notnull' => false]);
        $table->addColumn('comment', 'text', ['notnull' => false]);
        $table->addColumn('decision', 'text', ['notnull' => false]);
        $table->addColumn('attachment', 'integer', ['notnull' => false]);
        $table->addColumn('visible_to_instructor', 'boolean');
        $table->addColumn('visible_to_training_center', 'boolean');
        $table->addColumn('visible_to_certifier', 'boolean');
        $table->addColumn('is_archived', 'boolean');
        $table->addColumn('language', 'string');
        $table->addColumn('created_at', 'integer');
        $table->addColumn('updated_at', 'integer');
        $table->setPrimaryKey(['uid']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('tx_equedlms_domain_model_qmscase');
    }
}
