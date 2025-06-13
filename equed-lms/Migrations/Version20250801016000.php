<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801016000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Store instructor feedback and quiz timestamps as UNIX integers';
    }

    public function up(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_instructorfeedback')) {
            $table = $schema->getTable('tx_equedlms_domain_model_instructorfeedback');
            if ($table->hasColumn('submitted_at')) {
                $table->changeColumn('submitted_at', ['type' => 'integer']);
            }
        }

        if ($schema->hasTable('tx_equedlms_domain_model_quizresult')) {
            $table = $schema->getTable('tx_equedlms_domain_model_quizresult');
            if ($table->hasColumn('submitted_at')) {
                $table->changeColumn('submitted_at', ['type' => 'integer']);
            }
        }

        if ($schema->hasTable('tx_equedlms_domain_model_trainingrecord')) {
            $table = $schema->getTable('tx_equedlms_domain_model_trainingrecord');
            if ($table->hasColumn('certificate_issued_at')) {
                $table->changeColumn('certificate_issued_at', ['type' => 'integer']);
            }
            if ($table->hasColumn('date')) {
                $table->changeColumn('date', ['type' => 'integer']);
            }
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('tx_equedlms_domain_model_instructorfeedback')) {
            $table = $schema->getTable('tx_equedlms_domain_model_instructorfeedback');
            if ($table->hasColumn('submitted_at')) {
                $table->changeColumn('submitted_at', ['type' => 'string']);
            }
        }

        if ($schema->hasTable('tx_equedlms_domain_model_quizresult')) {
            $table = $schema->getTable('tx_equedlms_domain_model_quizresult');
            if ($table->hasColumn('submitted_at')) {
                $table->changeColumn('submitted_at', ['type' => 'string']);
            }
        }

        if ($schema->hasTable('tx_equedlms_domain_model_trainingrecord')) {
            $table = $schema->getTable('tx_equedlms_domain_model_trainingrecord');
            if ($table->hasColumn('certificate_issued_at')) {
                $table->changeColumn('certificate_issued_at', ['type' => 'string']);
            }
            if ($table->hasColumn('date')) {
                $table->changeColumn('date', ['type' => 'string']);
            }
        }
    }
}
