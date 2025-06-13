<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801006000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table for course bundle';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('tx_equedlms_domain_model_coursebundle');
        $table->addColumn('uid', 'integer')->setAutoincrement(true);
        $table->addColumn('pid', 'integer');
        $table->addColumn('title', 'string');
        $table->addColumn('title_key', 'string');
        $table->addColumn('description', 'text');
        $table->addColumn('description_key', 'string');
        $table->addColumn('available_from', 'integer');
        $table->addColumn('hidden', 'boolean');
        $table->addColumn('price', 'string');
        $table->addColumn('discount_percentage', 'string');
        $table->addColumn('is_active', 'boolean');
        $table->addColumn('is_visible', 'boolean');
        $table->addColumn('slug', 'string');
        $table->addColumn('image', 'integer');
        $table->addColumn('recommended_after', 'integer');
        $table->addColumn('uuid', 'string');
        $table->addColumn('created_at', 'integer');
        $table->addColumn('updated_at', 'integer');
        $table->setPrimaryKey(['uid']);

        $mm = $schema->createTable('tx_equedlms_coursebundle_courseprogram_mm');
        $mm->addColumn('uid_local', 'integer');
        $mm->addColumn('uid_foreign', 'integer');
        $mm->addColumn('sorting', 'integer');
        $mm->setPrimaryKey(['uid_local', 'uid_foreign']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('tx_equedlms_domain_model_coursebundle');
        $schema->dropTable('tx_equedlms_coursebundle_courseprogram_mm');
    }
}
