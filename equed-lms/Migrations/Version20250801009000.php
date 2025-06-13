<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801009000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add completed_at column to lesson progress table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('tx_equedlms_domain_model_lessonprogress');
        $table->addColumn('completed_at', 'integer');
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('tx_equedlms_domain_model_lessonprogress');
        if ($table->hasColumn('completed_at')) {
            $table->dropColumn('completed_at');
        }
    }
}
