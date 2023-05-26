<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP\Support;

use Composer\Script\Event;
use Guanguans\SoarPHP\Soar;

/**
 * @internal
 */
class ComposerScript
{
    public static function dumpSoarDocblock(Event $event): int
    {
        require_once $event->getComposer()->getConfig()->get('vendor-dir').'/autoload.php';

        $prefix = <<<'docblock'
<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */
/**
docblock;

        $suffix = <<<'docblock'

 * @mixin \Guanguans\SoarPHP\Soar
 */

docblock;

        $methodMapper = [
            'add' => ' * @method self add{method}({type} ${name})',
            'remove' => ' * @method self remove{method}()',
            'only' => ' * @method self only{method}()',
            'set' => ' * @method self set{method}({type} ${name})',
            'merge' => ' * @method self merge{method}({type} ${name})',
            // 'getNormalized' => ' * @method null|{type} getNormalized{method}($default = null)',
            'get' => ' * @method null|{type} get{method}($default = null)',
        ];

        $options = self::extractOptionsFromHelp();

        $docblock = array_reduce_with_keys($methodMapper, static function (string $docblock, string $t, string $typeOfMethod) use ($options): string {
            return array_reduce($options, static function (string $docblock, array $option) use ($typeOfMethod, $t): string {
                if ('uint' === $option['type']) {
                    $option['type'] = 'int';
                }

                if (str_starts_with($typeOfMethod, 'get') && null === $option['type']) {
                    $option['type'] = 'mixed';
                }

                $description = str_replace('@', '', " * {$option['description']}".PHP_EOL);

                $replacer = [
                    '{method}' => ucfirst(str_camel($option['name'])),
                    '{type}' => $option['type'],
                    '{name}' => str_camel($option['name']),
                ];

                $method = str_replace(array_keys($replacer), array_values($replacer), $t);

                return $docblock.PHP_EOL.$description.$method.PHP_EOL.' *';
            }, $docblock);
        }, '');

        file_put_contents(__DIR__.'/../../examples/soar.options.docblock.php', $prefix.$docblock.$suffix);
        $event->getIO()->write('<info>操作成功</info>');

        return 0;
    }

    public static function dumpSoarConfig(Event $event): int
    {
        require_once $event->getComposer()->getConfig()->get('vendor-dir').'/autoload.php';

        $prefix = <<<'PHP'
<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

// +----------------------------------------------------------------------+//
// |              请参考 @see https://github.com/XiaoMi/soar               |//
// +----------------------------------------------------------------------+//

return [
PHP;

        $suffix = '];'.PHP_EOL;

        $code = array_reduce(self::extractOptionsFromHelp(), static function (string $code, array $options): string {
            null === $options['default'] and $options['default'] = 'null';

            $item = <<<PHP
    /**
     * {$options['description']}.
     */
    '{$options['name']}' => {$options['default']},

PHP;

            return $code.PHP_EOL.$item;
        }, '');

        file_put_contents(__DIR__.'/../../examples/soar.options.full.php', $prefix.$code.$suffix);
        $event->getIO()->write('<info>操作成功</info>');

        return 0;
    }

    /**
     * @psalm-suppress RedundantCast
     *
     * @return array<string, array<string, null|string>>
     */
    public static function extractOptionsFromHelp(): array
    {
        $arrayMap = array_map(static function (string $option): ?string {
            if (! str_starts_with($option, ' ')) {
                return null;
            }

            return ltrim($option);
        }, explode(PHP_EOL, Soar::create()->help()));

        $options = array_reduce(array_chunk(array_filter($arrayMap), 2), static function (array $options, array $option): array {
            $names = (array) explode(' ', $option[0]);
            preg_match('/\\(default .*\\)/', $option[1], $defaults);

            $default = $defaults[0] ?? null;
            if (\is_string($default) && str_starts_with($default, $pre = '(default ')) {
                $default = rtrim(substr($default, \strlen($pre)), ')');
            }

            $options[$names[0]] = [
                'name' => $names[0],
                'description' => $option[1],
                'type' => $names[1] ?? null,
                'default' => $default,
            ];

            return $options;
        }, []);

        $options['help'] = [
            'name' => 'help',
            'description' => 'Help',
            'type' => null,
            'default' => null,
        ];

        return $options;
    }
}
