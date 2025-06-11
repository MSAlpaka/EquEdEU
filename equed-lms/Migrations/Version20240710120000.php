<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240710120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table for course exam slots';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('tx_equedlms_domain_model_courseexamslot');
        $table->addColumn('uid', 'integer')->setAutoincrement(true);
        $table->addColumn('pid', 'integer');
        $table->addColumn('uuid', 'string');
        $table->addColumn('course_instance', 'integer');
        $table->addColumn('examiner', 'integer');
        $table->addColumn('start_date_time', 'integer');
        $table->addColumn('end_date_time', 'integer');
        $table->addColumn('location', 'string');
        $table->addColumn('capacity', 'integer');
        $table->addColumn('registered_count', 'integer');
        $table->addColumn('is_cancelled', 'boolean');
        $table->addColumn('created_at', 'integer');
        $table->addColumn('updated_at', 'integer');
        $table->setPrimaryKey(['uid']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('tx_equedlms_domain_model_courseexamslot');
    }
}
