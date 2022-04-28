<?php

declare(strict_types=1);

namespace Minesweeper;

final class Field
{
    public int $linesCount;

    public int $columnsCount;

    public array $body;

    public function __construct(int $linesCount, int $columnsCount, array $body)
    {
        $this->linesCount = $linesCount;
        $this->columnsCount = $columnsCount;
        $this->body = $body;
    }
}