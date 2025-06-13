<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801011000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Extend submission table with GPT analysis columns and foreign keys';
    }

    public function up(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_submission')) {
            $table = $schema->getTable('tx_equedlms_domain_model_submission');
            if (!$table->hasColumn('uuid')) {
                $table->addColumn('uuid', 'string');
            }
            if (!$table->hasColumn('gpt_analysis_status')) {
                $table->addColumn('gpt_analysis_status', 'string', ['notnull' => false]);
            }
            if (!$table->hasColumn('gpt_score')) {
                $table->addColumn('gpt_score', 'float', ['notnull' => false]);
            }
            if (!$table->hasColumn('gpt_summary')) {
                $table->addColumn('gpt_summary', 'text', ['notnull' => false]);
            }
            if (!$table->hasColumn('gpt_suggestion')) {
                $table->addColumn('gpt_suggestion', 'text', ['notnull' => false]);
            }
            if (!$table->hasColumn('gpt_analysis_data')) {
                $table->addColumn('gpt_analysis_data', 'text', ['notnull' => false]);
            }
            if (!$table->hasColumn('analyzed_at')) {
                $table->addColumn('analyzed_at', 'integer', ['notnull' => false]);
            }
            if (!$table->hasColumn('text_content')) {
                $table->addColumn('text_content', 'text', ['notnull' => false]);
            }
            $table->changeColumn('created_at', ['type' => 'integer']);
            $table->addForeignKeyConstraint('fe_users', ['user'], ['uid'], ['onDelete' => 'SET NULL']);
            $table->addForeignKeyConstraint('tx_equedlms_domain_model_lesson', ['lesson'], ['uid'], ['onDelete' => 'SET NULL']);
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_submission')) {
            $table = $schema->getTable('tx_equedlms_domain_model_submission');
            foreach ($table->getForeignKeys() as $fk) {
                $table->removeForeignKey($fk->getName());
            }
            foreach ([
                'uuid',
                'gpt_analysis_status',
                'gpt_score',
                'gpt_summary',
                'gpt_suggestion',
                'gpt_analysis_data',
                'analyzed_at',
                'text_content'
            ] as $column) {
                if ($table->hasColumn($column)) {
                    $table->dropColumn($column);
                }
            }
            $table->changeColumn('created_at', ['type' => 'integer']);
        }
    }
}
