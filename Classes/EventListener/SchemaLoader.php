<?php

declare(strict_types=1);

namespace Equed\EquedLms\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use TYPO3\CMS\Core\Database\Event\AlterTableDefinitionStatementsEvent;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use Symfony\Component\Yaml\Yaml;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Adds SQL table definitions from YAML files for Doctrine.
 */
final class SchemaLoader implements EventSubscriberInterface, SingletonInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            AlterTableDefinitionStatementsEvent::class => 'addSchema'
        ];
    }

    public function addSchema(AlterTableDefinitionStatementsEvent $event): void
    {
        $extensionPath = ExtensionManagementUtility::extPath('equed_lms');
        $files = glob($extensionPath . 'Configuration/Schema/Domain/Model/*.yaml') ?: [];
        foreach ($files as $file) {
            $data = Yaml::parseFile($file);
            if (!is_array($data) || empty($data['table']) || empty($data['columns'])) {
                continue;
            }
            $table = $data['table'];
            $cols = [];
            foreach ($data['columns'] as $name => $info) {
                $type = $info['type'] ?? 'string';
                $sqlType = match ($type) {
                    'integer' => 'int(11) DEFAULT 0',
                    'boolean' => 'tinyint(1) DEFAULT 0',
                    'text' => 'text',
                    'float' => 'double',
                    default => "varchar(255) DEFAULT ''",
                };
                $cols[] = "    {$name} {$sqlType}";
            }
            $cols[] = '    PRIMARY KEY (uid)';
            $sql = "CREATE TABLE {$table} (\n" . implode(",\n", $cols) . "\n);";
            $event->addSqlData($sql);
        }
    }
}
