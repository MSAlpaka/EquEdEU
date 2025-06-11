<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801005000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table for glossary entry';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('tx_equedlms_domain_model_glossaryentry');
        $table->addColumn('uid', 'integer')->setAutoincrement(true);
        $table->addColumn('pid', 'integer');
        $table->addColumn('sys_language_uid', 'integer');
        $table->addColumn('l10n_parent', 'integer');
        $table->addColumn('l10n_diffsource', 'string');
        $table->addColumn('hidden', 'boolean');
        $table->addColumn('starttime', 'integer');
        $table->addColumn('endtime', 'integer');
        $table->addColumn('term', 'string');
        $table->addColumn('term_key', 'string');
        $table->addColumn('definition', 'text');
        $table->addColumn('definition_key', 'string');
        $table->addColumn('course_program', 'integer');
        $table->addColumn('language', 'string');
        $table->addColumn('is_archived', 'boolean');
        $table->addColumn('uuid', 'string');
        $table->addColumn('created_at', 'integer');
        $table->addColumn('updated_at', 'integer');
        $table->setPrimaryKey(['uid']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('tx_equedlms_domain_model_glossaryentry');
    }
}
