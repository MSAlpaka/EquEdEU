<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801019000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Drop fe_user column from lesson progress table';
    }

    public function up(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_lessonprogress')) {
            $table = $schema->getTable('tx_equedlms_domain_model_lessonprogress');
            if ($table->hasColumn('fe_user')) {
                $table->dropColumn('fe_user');
            }
            if (!$table->hasColumn('user_course_record')) {
                $table->addColumn('user_course_record', 'integer');
            }
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_lessonprogress')) {
            $table = $schema->getTable('tx_equedlms_domain_model_lessonprogress');
            if (!$table->hasColumn('fe_user')) {
                $table->addColumn('fe_user', 'integer');
            }
            if ($table->hasColumn('user_course_record')) {
                $table->dropColumn('user_course_record');
            }
        }
    }
}
