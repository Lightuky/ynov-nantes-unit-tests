<?php

declare(strict_types=1);

namespace Minesweeper;

use InvalidArgumentException;

final class Minesweeper
{
    /**
     * @var Field[]
     */
    private array $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function createMinesweeper()
    {
        foreach ($this->fields as $field) {
            if ($field->linesCount == 0 && $field->columnsCount == 0) {
                break;
            } elseif ($field->linesCount < 0 || $field->columnsCount < 0 || $field->linesCount > 100 || $field->columnsCount > 100) {
                throw new InvalidArgumentException("Lines/Columns count must be between 1 and 100");
            } else {

            }
        }
    }
}