<?php
declare(strict_types=1);

use Symfony\Component\Yaml\Yaml;

require dirname(__DIR__) . '/vendor/autoload.php';

function prettyExport(mixed $value, int $level = 0): string {
    $indent = str_repeat('    ', $level);
    if (is_array($value)) {
        $items = [];
        foreach ($value as $k => $v) {
            $items[] = $indent . '    ' . var_export($k, true) . ' => ' . prettyExport($v, $level + 1);
        }
        return "[\n" . implode(",\n", $items) . "\n" . $indent . "]";
    }
    return var_export($value, true);
}

$schemaDir = __DIR__ . '/../Configuration/Schema/Domain/Model';
$tcaDir = __DIR__ . '/../Configuration/TCA';

foreach (glob($schemaDir . '/*.yaml') as $file) {
    $data = Yaml::parseFile($file);
    if (!is_array($data) || empty($data['table']) || empty($data['columns'])) {
        continue;
    }
    $table = $data['table'];
    $model = preg_replace('/^tx_equedlms_domain_model_/', '', $table);
    $target = $tcaDir . '/tx_equedlms_domain_model_' . $model . '.php';
    if (file_exists($target)) {
        continue;
    }

    $columns = $data['columns'];
    $fields = array_values(array_diff(array_keys($columns), ['uid', 'pid']));
    $label = $fields[0] ?? 'uid';

    $colCfg = [];
    foreach ($fields as $field) {
        $type = $columns[$field]['type'] ?? 'string';
        $config = match ($type) {
            'integer' => ['type' => 'input', 'eval' => 'int'],
            'boolean' => ['type' => 'check'],
            'text' => ['type' => 'text'],
            'float' => ['type' => 'input', 'eval' => 'float'],
            default => ['type' => 'input', 'eval' => 'trim'],
        };
        $colCfg[$field] = [
            'exclude' => true,
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:' . $table . '.' . $field,
            'config' => $config,
        ];
    }

    $tca = [
        'ctrl' => [
            'title' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:' . $table,
            'label' => $label,
            'hideTable' => true,
        ],
        'columns' => $colCfg,
        'types' => [
            '1' => [
                'showitem' => implode(', ', $fields),
            ],
        ],
        'interface' => [
            'showRecordFieldList' => implode(',', $fields),
        ],
    ];

    $content = "<?php\n\ndeclare(strict_types=1);\n\n" . "defined('TYPO3') or die();\n\nreturn " . prettyExport($tca) . ";\n";
    file_put_contents($target, $content);
    echo "Generated $target\n";
}
