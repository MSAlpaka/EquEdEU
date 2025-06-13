<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801014000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename user column to fe_user in lesson progress table';
    }

    public function up(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_lessonprogress')) {
            $table = $schema->getTable('tx_equedlms_domain_model_lessonprogress');
            if ($table->hasColumn('user') && !$table->hasColumn('fe_user')) {
                $table->renameColumn('user', 'fe_user');
            }
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_lessonprogress')) {
            $table = $schema->getTable('tx_equedlms_domain_model_lessonprogress');
            if ($table->hasColumn('fe_user') && !$table->hasColumn('user')) {
                $table->renameColumn('fe_user', 'user');
            }
        }
    }
}
