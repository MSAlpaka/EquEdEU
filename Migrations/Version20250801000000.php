<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table for course certificate';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('tx_equedlms_domain_model_coursecertificate');
        $table->addColumn('uid', 'integer')->setAutoincrement(true);
        $table->addColumn('pid', 'integer');
        $table->addColumn('uuid', 'string');
        $table->addColumn('user_course_record', 'integer');
        $table->addColumn('certificate_template', 'integer');
        $table->addColumn('certificate_dispatch', 'integer');
        $table->addColumn('certificate_number', 'string');
        $table->addColumn('language', 'string');
        $table->addColumn('badge_level', 'integer');
        $table->addColumn('is_public', 'boolean');
        $table->addColumn('is_archived', 'boolean');
        $table->addColumn('is_badge_relevant', 'boolean');
        $table->addColumn('is_auto_generated', 'boolean');
        $table->addColumn('issued_at', 'integer');
        $table->addColumn('created_at', 'integer');
        $table->addColumn('updated_at', 'integer');
        $table->setPrimaryKey(['uid']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('tx_equedlms_domain_model_coursecertificate');
    }
}
