<?php

declare(strict_types=1);

namespace Equed\EquedLms\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250610213300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables for exam result, practice answer option, submission attachment and user profile';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('tx_equedlms_domain_model_examresult');
        $table->addColumn('uid', 'integer')->setAutoincrement(true);
        $table->addColumn('pid', 'integer');
        $table->addColumn('uuid', 'string');
        $table->addColumn('user_course_record', 'integer');
        $table->addColumn('theory_passed', 'boolean');
        $table->addColumn('practice_passed', 'boolean');
        $table->addColumn('case_passed', 'boolean');
        $table->addColumn('total_score', 'float');
        $table->addColumn('overall_passed', 'boolean');
        $table->addColumn('overall_comment', 'string', ['notnull' => false]);
        $table->addColumn('is_archived', 'boolean');
        $table->addColumn('created_at', 'integer');
        $table->addColumn('updated_at', 'integer');
        $table->setPrimaryKey(['uid']);

        $table = $schema->createTable('tx_equedlms_domain_model_practiceansweroption');
        $table->addColumn('uid', 'integer')->setAutoincrement(true);
        $table->addColumn('pid', 'integer');
        $table->addColumn('uuid', 'string');
        $table->addColumn('practice_question', 'integer');
        $table->addColumn('text', 'string');
        $table->addColumn('is_correct', 'boolean');
        $table->addColumn('explanation_text', 'string', ['notnull' => false]);
        $table->addColumn('lang', 'string');
        $table->addColumn('generated_by', 'string', ['notnull' => false]);
        $table->addColumn('gpt_version', 'string', ['notnull' => false]);
        $table->addColumn('created_at', 'integer');
        $table->addColumn('updated_at', 'integer');
        $table->setPrimaryKey(['uid']);

        $table = $schema->createTable('tx_equedlms_domain_model_submissionattachment');
        $table->addColumn('uid', 'integer')->setAutoincrement(true);
        $table->addColumn('pid', 'integer');
        $table->addColumn('uuid', 'string');
        $table->addColumn('user_submission', 'integer');
        $table->addColumn('file', 'integer');
        $table->addColumn('title', 'string');
        $table->addColumn('type', 'string');
        $table->addColumn('visibility', 'string');
        $table->addColumn('status', 'string');
        $table->addColumn('lang', 'string');
        $table->addColumn('is_active', 'boolean');
        $table->addColumn('created_at', 'integer');
        $table->addColumn('updated_at', 'integer');
        $table->setPrimaryKey(['uid']);

        $table = $schema->createTable('tx_equedlms_domain_model_userprofile');
        $table->addColumn('uid', 'integer')->setAutoincrement(true);
        $table->addColumn('pid', 'integer');
        $table->addColumn('uuid', 'string');
        $table->addColumn('user', 'integer');
        $table->addColumn('docu_level', 'string');
        $table->addColumn('docu_level_key', 'string', ['notnull' => false]);
        $table->addColumn('total_practice_hours', 'integer');
        $table->addColumn('completed_specialties', 'integer');
        $table->addColumn('recognition_award', 'string');
        $table->addColumn('recognition_award_key', 'string', ['notnull' => false]);
        $table->addColumn('badge_level', 'integer');
        $table->addColumn('badge_level_key', 'string', ['notnull' => false]);
        $table->addColumn('profile_status', 'string');
        $table->addColumn('profile_status_key', 'string', ['notnull' => false]);
        $table->addColumn('is_visible_in_search', 'boolean');
        $table->addColumn('has_pro_access', 'boolean');
        $table->addColumn('display_name', 'string');
        $table->addColumn('country', 'string');
        $table->addColumn('is_instructor', 'boolean');
        $table->addColumn('onboarding_complete', 'boolean');
        $table->addColumn('language', 'string');
        $table->addColumn('last_login_at', 'integer', ['notnull' => false]);
        $table->addColumn('is_archived', 'boolean');
        $table->addColumn('created_at', 'integer');
        $table->addColumn('updated_at', 'integer');
        $table->setPrimaryKey(['uid']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('tx_equedlms_domain_model_examresult');
        $schema->dropTable('tx_equedlms_domain_model_practiceansweroption');
        $schema->dropTable('tx_equedlms_domain_model_submissionattachment');
        $schema->dropTable('tx_equedlms_domain_model_userprofile');
    }
}
