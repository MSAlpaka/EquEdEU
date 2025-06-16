<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801017000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add title_key and description_key to course program and module';
    }

    public function up(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_courseprogram')) {
            $table = $schema->getTable('tx_equedlms_domain_model_courseprogram');
            if (!$table->hasColumn('title_key')) {
                $table->addColumn('title_key', 'string', ['notnull' => false]);
            }
            if (!$table->hasColumn('description_key')) {
                $table->addColumn('description_key', 'string', ['notnull' => false]);
            }
        }
        if ($schema->hasTable('tx_equedlms_domain_model_module')) {
            $table = $schema->getTable('tx_equedlms_domain_model_module');
            if (!$table->hasColumn('title_key')) {
                $table->addColumn('title_key', 'string', ['notnull' => false]);
            }
            if (!$table->hasColumn('description_key')) {
                $table->addColumn('description_key', 'string', ['notnull' => false]);
            }
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_courseprogram')) {
            $table = $schema->getTable('tx_equedlms_domain_model_courseprogram');
            foreach (['title_key', 'description_key'] as $col) {
                if ($table->hasColumn($col)) {
                    $table->dropColumn($col);
                }
            }
        }
        if ($schema->hasTable('tx_equedlms_domain_model_module')) {
            $table = $schema->getTable('tx_equedlms_domain_model_module');
            foreach (['title_key', 'description_key'] as $col) {
                if ($table->hasColumn($col)) {
                    $table->dropColumn($col);
                }
            }
        }
    }
}
