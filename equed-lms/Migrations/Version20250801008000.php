<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250801008000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add index for module.course_program';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('tx_equedlms_domain_model_module');
        $table->addIndex(['course_program'], 'idx_module_course_program');
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('tx_equedlms_domain_model_module');
        foreach ($table->getIndexes() as $index) {
            if ($index->getName() === 'idx_module_course_program') {
                $table->dropIndex('idx_module_course_program');
                break;
            }
        }
    }
}
