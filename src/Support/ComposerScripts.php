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
class ComposerScripts
{
    public static function dumpOptionsToSetterDocblock(Event $event): int
    {
        require_once __DIR__.'/../../vendor/autoload.php';

        $prefix = <<<'docblock'
/**
*
docblock;

        $suffix = <<<'docblock'

* @mixin \Guanguans\SoarPHP\Soar
*/
docblock;

        $docblock = array_reduce(self::extractOptionsFromHelp(), static function (string $docblock, array $options): string {
            'uint' === $options['type'] and $options['type'] = 'int';

            $description = sprintf('* %s', $options['description']);

            $method = sprintf(
                '* @method \Guanguans\SoarPHP\Soar %s(%s$%s)',
                'set'.ucfirst(str_camel($options['name'])),
                $options['type'] ? $options['type'].' ' : '',
                str_camel($options['name'])
            );

            return $docblock.PHP_EOL.$description.PHP_EOL.$method.PHP_EOL.'*';
        }, '');

        $event->getIO()->write("<info>{$prefix}{$docblock}{$suffix}</info>");

        return 0;
    }

    public static function dumpOptionsToPHPFile(Event $event): int
    {
        require_once __DIR__.'/../../vendor/autoload.php';

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

            $t = <<<PHP
    /**
     * {$options['description']}.
     */
    '{$options['name']}' => {$options['default']},
PHP;

            return $code.PHP_EOL.$t.PHP_EOL;
        }, '');

        file_put_contents(__DIR__.'/../../soar.full.config.sample.php', $prefix.$code.$suffix);
        $event->getIO()->write('<info>操作成功</info>');

        return 0;
    }

    /**
     * @psalm-suppress RedundantCast
     *
     * @return array<string, array<string, string|null>>
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
            preg_match("/\(default .*\)/", $option[1], $defaults);

            $default = $defaults[0] ?? null;
            if (is_string($default) && str_starts_with($default, $pre = '(default ')) {
                $default = rtrim(substr($default, strlen($pre)), ')');
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
