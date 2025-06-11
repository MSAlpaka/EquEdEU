<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801002000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table for incident report';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('tx_equedlms_domain_model_incidentreport');
        $table->addColumn('uid', 'integer')->setAutoincrement(true);
        $table->addColumn('pid', 'integer');
        $table->addColumn('uuid', 'string');
        $table->addColumn('user_course_record', 'integer');
        $table->addColumn('course_instance', 'integer');
        $table->addColumn('instructor', 'integer');
        $table->addColumn('certifier', 'integer');
        $table->addColumn('reported_user', 'integer');
        $table->addColumn('incident_type_key', 'string');
        $table->addColumn('severity_key', 'string');
        $table->addColumn('status', 'string');
        $table->addColumn('comment_instructor', 'text', ['notnull' => false]);
        $table->addColumn('comment_service_center', 'text', ['notnull' => false]);
        $table->addColumn('comment_certifier', 'text', ['notnull' => false]);
        $table->addColumn('linked_certificate_number', 'string', ['notnull' => false]);
        $table->addColumn('linked_standard_key', 'string', ['notnull' => false]);
        $table->addColumn('visible_to_instructor', 'boolean');
        $table->addColumn('visible_to_training_center', 'boolean');
        $table->addColumn('visible_to_certifier', 'boolean');
        $table->addColumn('is_archived', 'boolean');
        $table->addColumn('created_at', 'integer');
        $table->addColumn('updated_at', 'integer');
        $table->setPrimaryKey(['uid']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('tx_equedlms_domain_model_incidentreport');
    }
}
