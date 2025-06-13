<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801010000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update user course record table with additional columns and timestamp types';
    }

    public function up(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_usercourserecord')) {
            $table = $schema->getTable('tx_equedlms_domain_model_usercourserecord');
            if (!$table->hasColumn('uuid')) {
                $table->addColumn('uuid', 'string');
            }
            if (!$table->hasColumn('archived_attempts')) {
                $table->addColumn('archived_attempts', 'text', ['notnull' => false]);
            }
            if (!$table->hasColumn('passed_modules')) {
                $table->addColumn('passed_modules', 'text', ['notnull' => false]);
            }
            if (!$table->hasColumn('external_certificate_flag')) {
                $table->addColumn('external_certificate_flag', 'boolean');
            }
            if (!$table->hasColumn('created_at')) {
                $table->addColumn('created_at', 'integer');
            }
            if (!$table->hasColumn('updated_at')) {
                $table->addColumn('updated_at', 'integer');
            }
            $table->changeColumn('enrolled_at', ['type' => 'integer']);
            $table->changeColumn('completed_at', ['type' => 'integer']);
            $table->changeColumn('revoked_at', ['type' => 'integer']);
            $table->changeColumn('last_activity', ['type' => 'integer']);
            $table->changeColumn('certified_at', ['type' => 'integer']);
            $table->changeColumn('validated_at', ['type' => 'integer']);
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_usercourserecord')) {
            $table = $schema->getTable('tx_equedlms_domain_model_usercourserecord');
            if ($table->hasColumn('uuid')) {
                $table->dropColumn('uuid');
            }
            if ($table->hasColumn('archived_attempts')) {
                $table->dropColumn('archived_attempts');
            }
            if ($table->hasColumn('passed_modules')) {
                $table->dropColumn('passed_modules');
            }
            if ($table->hasColumn('external_certificate_flag')) {
                $table->dropColumn('external_certificate_flag');
            }
            if ($table->hasColumn('created_at')) {
                $table->dropColumn('created_at');
            }
            if ($table->hasColumn('updated_at')) {
                $table->dropColumn('updated_at');
            }
            $table->changeColumn('enrolled_at', ['type' => 'string']);
            $table->changeColumn('completed_at', ['type' => 'string']);
            $table->changeColumn('revoked_at', ['type' => 'string']);
            $table->changeColumn('last_activity', ['type' => 'string']);
            $table->changeColumn('certified_at', ['type' => 'string']);
            $table->changeColumn('validated_at', ['type' => 'string']);
        }
    }
}
