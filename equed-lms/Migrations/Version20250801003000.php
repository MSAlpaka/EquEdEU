<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801003000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table for exam template criteria';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('tx_equedlms_domain_model_examtemplatecriteria');
        $table->addColumn('uid', 'integer')->setAutoincrement(true);
        $table->addColumn('pid', 'integer');
        $table->addColumn('uuid', 'string');
        $table->addColumn('exam_template', 'integer');
        $table->addColumn('title_key', 'string');
        $table->addColumn('title_override', 'string', ['notnull' => false]);
        $table->addColumn('max_points', 'string');
        $table->addColumn('is_required', 'boolean');
        $table->addColumn('position', 'integer');
        $table->addColumn('is_archived', 'boolean');
        $table->addColumn('created_at', 'integer');
        $table->addColumn('updated_at', 'integer');
        $table->setPrimaryKey(['uid']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('tx_equedlms_domain_model_examtemplatecriteria');
    }
}
