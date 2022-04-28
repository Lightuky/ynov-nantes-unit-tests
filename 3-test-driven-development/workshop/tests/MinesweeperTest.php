<?php

declare(strict_types=1);

namespace Tests;

use ArgumentCountError;
use Minesweeper\Field;
use Minesweeper\Minesweeper;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use TypeError;

class MinesweeperTest extends TestCase
{
    public function testNoFields(): void
    {
        $this->expectException(ArgumentCountError::class);
        $minesweeper = new Minesweeper();
        $minesweeper->createMinesweeper();
    }

    public function testMissingAttributes(): void
    {
        $this->expectException(ArgumentCountError::class);
        $incomplete_fields = [
            new Field(linesCount: 4, columnsCount: 5),
            new Field(columnsCount: 5, body: 14),
            new Field(body: 8),
            new Field(),
        ];
        $minesweeper = new Minesweeper($incomplete_fields);
        $minesweeper->createMinesweeper();
    }

    public function test_types()
    {
        $this->expectException(TypeError::class);
        $wrong_types_fields = [
            new Field(4, 5, "string"),
            new Field(4, 5, 15),
            new Field(4, 5, 50.8),
            new Field(null, null, []),
            new Field("string", "string", []),
            new Field(50.8, 50.8, []),
        ];
        $minesweeper = new Minesweeper($wrong_types_fields);
        $minesweeper->createMinesweeper();
    }

    public function test_extreme_numeric_values()
    {
        $this->expectException(InvalidArgumentException::class);
        $extreme_values_fields = [
            new Field(-3, 5, []),
            new Field(105, 5, []),
            new Field(4, -7, []),
            new Field(4, 112, []),
        ];
        $minesweeper = new Minesweeper($extreme_values_fields);
        $minesweeper->createMinesweeper();
    }
}
