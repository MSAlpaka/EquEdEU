<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801012000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Extend practice question with GPT metadata and unify timestamp column types';
    }

    public function up(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_practicequestion')) {
            $table = $schema->getTable('tx_equedlms_domain_model_practicequestion');
            if (!$table->hasColumn('expected_answer_text')) {
                $table->addColumn('expected_answer_text', 'text', ['notnull' => false]);
            }
            if (!$table->hasColumn('generated_by')) {
                $table->addColumn('generated_by', 'string', ['notnull' => false]);
            }
            if (!$table->hasColumn('gpt_version')) {
                $table->addColumn('gpt_version', 'string', ['notnull' => false]);
            }
            if (!$table->hasColumn('glossary_key')) {
                $table->addColumn('glossary_key', 'string', ['notnull' => false]);
            }
            if (!$table->hasColumn('difficulty')) {
                $table->addColumn('difficulty', 'string', ['notnull' => false]);
            }
            if ($table->hasColumn('lang')) {
                $table->changeColumn('lang', ['type' => 'integer']);
            }
            if ($table->hasColumn('created_at')) {
                $table->changeColumn('created_at', ['type' => 'integer']);
            }
            if ($table->hasColumn('updated_at')) {
                $table->changeColumn('updated_at', ['type' => 'integer']);
            }
        }

        if ($schema->hasTable('tx_equedlms_domain_model_practiceansweroption')) {
            $table = $schema->getTable('tx_equedlms_domain_model_practiceansweroption');
            if ($table->hasColumn('lang')) {
                $table->changeColumn('lang', ['type' => 'integer']);
            }
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_practicequestion')) {
            $table = $schema->getTable('tx_equedlms_domain_model_practicequestion');
            foreach ([
                'expected_answer_text',
                'generated_by',
                'gpt_version',
                'glossary_key',
                'difficulty',
            ] as $column) {
                if ($table->hasColumn($column)) {
                    $table->dropColumn($column);
                }
            }
            if ($table->hasColumn('lang')) {
                $table->changeColumn('lang', ['type' => 'string']);
            }
            if ($table->hasColumn('created_at')) {
                $table->changeColumn('created_at', ['type' => 'string']);
            }
            if ($table->hasColumn('updated_at')) {
                $table->changeColumn('updated_at', ['type' => 'string']);
            }
        }

        if ($schema->hasTable('tx_equedlms_domain_model_practiceansweroption')) {
            $table = $schema->getTable('tx_equedlms_domain_model_practiceansweroption');
            if ($table->hasColumn('lang')) {
                $table->changeColumn('lang', ['type' => 'string']);
            }
        }
    }
}
