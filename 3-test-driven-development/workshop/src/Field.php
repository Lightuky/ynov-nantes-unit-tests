<?php

declare(strict_types=1);

namespace Minesweeper;

final class Field
{
    public int $linesCount;

    public int $columnsCount;

    public int $bombsCount;

    public function __construct(int $linesCount, int $columnsCount, int $bombsCount)
    {
        $this->linesCount = $linesCount;
        $this->columnsCount = $columnsCount;
        $this->bombsCount = $bombsCount;
    }
}