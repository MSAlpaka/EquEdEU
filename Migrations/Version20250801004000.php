<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801004000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table for lesson question';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('tx_equedlms_domain_model_lessonquestion');
        $table->addColumn('uid', 'integer')->setAutoincrement(true);
        $table->addColumn('pid', 'integer');
        $table->addColumn('uuid', 'string');
        $table->addColumn('lesson_quiz', 'integer');
        $table->addColumn('question_text', 'text');
        $table->addColumn('question_type', 'string');
        $table->addColumn('points', 'integer');
        $table->addColumn('order_number', 'integer');
        $table->addColumn('created_at', 'integer');
        $table->addColumn('updated_at', 'integer');
        $table->setPrimaryKey(['uid']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('tx_equedlms_domain_model_lessonquestion');
    }
}
