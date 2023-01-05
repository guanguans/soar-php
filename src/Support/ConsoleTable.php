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

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Exceptions\RuntimeException;

/**
 * This file was modified from https://github.com/deniskoronets/php-array-table.
 */
class ConsoleTable
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $columnsList = [];

    /**
     * @var array
     */
    private $columnsLength = [];

    /**
     * @var array
     */
    private $result = [];

    /**
     * @var string
     */
    private $charset = 'UTF-8';

    /**
     * @var bool
     */
    private $renderHeader = true;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Set custom charset for columns values.
     *
     * @return $this
     */
    public function charset(string $charset): self
    {
        if (! in_array($charset, mb_list_encodings())) {
            throw new InvalidArgumentException(sprintf('This charset `%s` is not supported by mb-string. Please check it: http://php.net/manual/ru/function.mb-list-encodings.php', $charset));
        }

        $this->charset = $charset;

        return $this;
    }

    /**
     * Set mode to print no header in the table.
     *
     * @return $this
     */
    public function noHeader(): self
    {
        $this->renderHeader = false;

        return $this;
    }

    /**
     * Build your ascii table and return the result.
     */
    public function render(): string
    {
        if (empty($this->data)) {
            throw new RuntimeException('no data rendering');
        }

        $this->calcColumnsList();
        $this->calcColumnsLength();

        /** render section */
        $this->renderHeader();
        $this->renderBody();
        $this->lineSeparator();
        /** end render section */

        return str_replace(
            ['++', '||'],
            ['+', '|'],
            implode(PHP_EOL, $this->result)
        );
    }

    /**
     * Calculates list of columns in data.
     */
    protected function calcColumnsList(): void
    {
        $this->columnsList = array_keys(reset($this->data));
    }

    /**
     * Calculates length for string.
     */
    protected function length($str): int
    {
        return mb_strlen((string) $str, $this->charset);
    }

    /**
     * Calculate maximum string length for each column.
     */
    private function calcColumnsLength(): void
    {
        foreach ($this->data as $row) {
            if ('---' === $row) {
                continue;
            }
            foreach ($this->columnsList as $column) {
                $this->columnsLength[$column] = max(
                    isset($this->columnsLength[$column])
                        ? $this->columnsLength[$column]
                        : 0,
                    $this->length($row[$column]),
                    $this->length($column)
                );
            }
        }
    }

    /**
     * Append a line separator to result.
     */
    private function lineSeparator(): void
    {
        $tmp = '';

        foreach ($this->columnsList as $column) {
            $tmp .= '+'.str_repeat('-', $this->columnsLength[$column] + 2).'+';
        }

        $this->result[] = $tmp;
    }

    private function column($columnKey, $value): string
    {
        return '| '.$value.' '.str_repeat(' ', $this->columnsLength[$columnKey] - $this->length($value)).'|';
    }

    /**
     * Render header part.
     */
    private function renderHeader(): void
    {
        $this->lineSeparator();

        if (! $this->renderHeader) {
            return;
        }

        $tmp = '';

        foreach ($this->columnsList as $column) {
            $tmp .= $this->column($column, $column);
        }

        $this->result[] = $tmp;

        $this->lineSeparator();
    }

    /**
     * Render body section of table.
     */
    private function renderBody(): void
    {
        foreach ($this->data as $row) {
            if ('---' === $row) {
                $this->lineSeparator();

                continue;
            }

            $tmp = '';

            foreach ($this->columnsList as $column) {
                $tmp .= $this->column($column, $row[$column]);
            }

            $this->result[] = $tmp;
        }
    }
}
