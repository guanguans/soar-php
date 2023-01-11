<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP;

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;

/**
 * This file was modified from https://github.com/deniskoronets/php-array-table.
 */
class ConsoleTable implements Contracts\ConsoleTable
{
    /**
     * @var array<array<array-key, scalar|\Stringable>>
     */
    protected $rows;

    /**
     * @var string
     */
    protected $charset = 'UTF-8';

    /**
     * @var bool
     */
    protected $isRenderHeader = true;

    /**
     * @var array<array-key>
     */
    protected $columns = [];

    /**
     * @var array<array-key, int>
     */
    protected $lengthOfColumns = [];

    /**
     * @var array<string>
     */
    protected $lines = [];

    public function __construct(array $rows)
    {
        $this->rows($rows);
    }

    public function rows(array $rows): self
    {
        if ([] === $rows) {
            throw new InvalidArgumentException('The rows cannot be empty.');
        }

        $this->rows = array_map(static function ($row): array {
            return (array) $row;
        }, $rows);

        return $this;
    }

    public function charset(string $charset): self
    {
        if (! in_array($charset, mb_list_encodings())) {
            throw new InvalidArgumentException(sprintf('The charset(%s) is not supported by mb-string.', $charset));
        }

        $this->charset = $charset;

        return $this;
    }

    public function isRenderHeader(bool $isRenderHeader): self
    {
        $this->isRenderHeader = $isRenderHeader;

        return $this;
    }

    public function render(): string
    {
        $this->resetRenderData();

        $this->extractColumns();
        $this->extractLengthOfColumns();

        $this->renderHeader();
        $this->renderBody();

        return str_replace(
            ['++', '||'],
            ['+', '|'],
            implode(PHP_EOL, $this->lines)
        );
    }

    public function __clone()
    {
        $this->resetRenderData();
    }

    protected function resetRenderData(): void
    {
        $this->columns = [];
        $this->lengthOfColumns = [];
        $this->lines = [];
    }

    protected function extractColumns(): void
    {
        $this->columns = array_keys((array) reset($this->rows));
    }

    protected function extractLengthOfColumns(): void
    {
        foreach ($this->rows as $row) {
            foreach ($this->columns as $column) {
                $this->lengthOfColumns[$column] = max(
                    $this->lengthOfColumns[$column] ?? 0,
                    $this->length($row[$column]),
                    $this->length($column)
                );
            }
        }
    }

    protected function renderHeader(): void
    {
        $this->addSeparatorOfRow();

        if (! $this->isRenderHeader) {
            return;
        }

        $this->lines[] = array_reduce($this->columns, function ($carry, $column): string {
            return $carry.$this->column($column, $column);
        }, '');

        $this->addSeparatorOfRow();
    }

    protected function renderBody(): void
    {
        foreach ($this->rows as $row) {
            $this->lines[] = array_reduce($this->columns, function ($carry, $column) use ($row): string {
                return $carry.$this->column($column, $row[$column]);
            }, '');
        }

        $this->addSeparatorOfRow();
    }

    protected function addSeparatorOfRow(): void
    {
        $this->lines[] = array_reduce($this->columns, function ($carry, $column): string {
            return $carry.'+'.str_repeat('-', $this->lengthOfColumns[$column] + 2).'+';
        }, '');
    }

    protected function column($name, $column): string
    {
        return '| '.$column.' '.str_repeat(' ', $this->lengthOfColumns[$name] - $this->length($column)).'|';
    }

    protected function length($str): int
    {
        return mb_strlen((string) $str, $this->charset);
    }
}
