<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801015000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update practice test table structure';
    }

    public function up(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_practicetest')) {
            $table = $schema->getTable('tx_equedlms_domain_model_practicetest');
            foreach (['lesson', 'is_active', 'is_mandatory_for_progress', 'estimated_duration', 'shuffle_questions', 'max_attempts', 'language', 'title_key', 'description_key'] as $obsolete) {
                if ($table->hasColumn($obsolete)) {
                    $table->dropColumn($obsolete);
                }
            }
            if (!$table->hasColumn('gpt_evaluation_enabled')) {
                $table->addColumn('gpt_evaluation_enabled', 'boolean');
            }
            if (!$table->hasColumn('evaluation_scheme')) {
                $table->addColumn('evaluation_scheme', 'text', ['notnull' => false]);
            }
            if (!$table->hasColumn('expected_file_types')) {
                $table->addColumn('expected_file_types', 'string', ['notnull' => false]);
            }
            if (!$table->hasColumn('visible_from')) {
                $table->addColumn('visible_from', 'integer', ['notnull' => false]);
            }
            if (!$table->hasColumn('visible_until')) {
                $table->addColumn('visible_until', 'integer', ['notnull' => false]);
            }
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_practicetest')) {
            $table = $schema->getTable('tx_equedlms_domain_model_practicetest');
            foreach (['gpt_evaluation_enabled', 'evaluation_scheme', 'expected_file_types', 'visible_from', 'visible_until'] as $new) {
                if ($table->hasColumn($new)) {
                    $table->dropColumn($new);
                }
            }
            if (!$table->hasColumn('lesson')) {
                $table->addColumn('lesson', 'integer', ['notnull' => false]);
            }
            if (!$table->hasColumn('is_active')) {
                $table->addColumn('is_active', 'boolean');
            }
            if (!$table->hasColumn('is_mandatory_for_progress')) {
                $table->addColumn('is_mandatory_for_progress', 'boolean');
            }
            if (!$table->hasColumn('estimated_duration')) {
                $table->addColumn('estimated_duration', 'string', ['notnull' => false]);
            }
            if (!$table->hasColumn('shuffle_questions')) {
                $table->addColumn('shuffle_questions', 'boolean');
            }
            if (!$table->hasColumn('max_attempts')) {
                $table->addColumn('max_attempts', 'string', ['notnull' => false]);
            }
            if (!$table->hasColumn('language')) {
                $table->addColumn('language', 'string', ['notnull' => false]);
            }
            if (!$table->hasColumn('title_key')) {
                $table->addColumn('title_key', 'string', ['notnull' => false]);
            }
            if (!$table->hasColumn('description_key')) {
                $table->addColumn('description_key', 'string', ['notnull' => false]);
            }
        }
    }
}
