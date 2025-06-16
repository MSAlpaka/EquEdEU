<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801018000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add accessibility notes, media alt text and transcript columns';
    }

    public function up(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_lesson')) {
            $table = $schema->getTable('tx_equedlms_domain_model_lesson');
            if (!$table->hasColumn('accessibility_notes')) {
                $table->addColumn('accessibility_notes', 'text', ['notnull' => false]);
            }
            if (!$table->hasColumn('media_alt_text')) {
                $table->addColumn('media_alt_text', 'string', ['notnull' => false]);
            }
            if (!$table->hasColumn('transcript')) {
                $table->addColumn('transcript', 'text', ['notnull' => false]);
            }
        }
        if ($schema->hasTable('tx_equedlms_domain_model_lessoncontentpage')) {
            $table = $schema->getTable('tx_equedlms_domain_model_lessoncontentpage');
            if (!$table->hasColumn('accessibility_notes')) {
                $table->addColumn('accessibility_notes', 'text', ['notnull' => false]);
            }
            if (!$table->hasColumn('media_alt_text')) {
                $table->addColumn('media_alt_text', 'string', ['notnull' => false]);
            }
            if (!$table->hasColumn('transcript')) {
                $table->addColumn('transcript', 'text', ['notnull' => false]);
            }
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_lesson')) {
            $table = $schema->getTable('tx_equedlms_domain_model_lesson');
            foreach (['accessibility_notes', 'media_alt_text', 'transcript'] as $col) {
                if ($table->hasColumn($col)) {
                    $table->dropColumn($col);
                }
            }
        }
        if ($schema->hasTable('tx_equedlms_domain_model_lessoncontentpage')) {
            $table = $schema->getTable('tx_equedlms_domain_model_lessoncontentpage');
            foreach (['accessibility_notes', 'media_alt_text', 'transcript'] as $col) {
                if ($table->hasColumn($col)) {
                    $table->dropColumn($col);
                }
            }
        }
    }
}
