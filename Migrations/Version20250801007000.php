<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801007000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table for observation template with full column set';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('tx_equedlms_domain_model_observationtemplate');
        $table->addColumn('uid', 'integer')->setAutoincrement(true);
        $table->addColumn('pid', 'integer');
        $table->addColumn('uuid', 'string');
        $table->addColumn('course_program', 'integer');
        $table->addColumn('title', 'string');
        $table->addColumn('title_key', 'string', ['notnull' => false]);
        $table->addColumn('description', 'text', ['notnull' => false]);
        $table->addColumn('structure', 'text', ['notnull' => false]);
        $table->addColumn('is_active', 'boolean');
        $table->addColumn('language', 'string');
        $table->addColumn('is_archived', 'boolean');
        $table->addColumn('created_at', 'integer');
        $table->addColumn('updated_at', 'integer');
        $table->setPrimaryKey(['uid']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('tx_equedlms_domain_model_observationtemplate');
    }
}
