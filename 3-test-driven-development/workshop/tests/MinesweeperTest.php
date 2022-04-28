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
            new Field(columnsCount: 5, bombsCount: 14),
            new Field(bombsCount: 8),
            new Field(),
        ];
        $minesweeper = new Minesweeper($incomplete_fields);
        $minesweeper->createMinesweeper();
    }

    public function test_types()
    {
        $this->expectException(TypeError::class);
        $wrong_types_fields = [
            new Field(null, null, null),
            new Field("string", "string", "string"),
            new Field(50.8, 50.8, 50.8),
        ];
        $minesweeper = new Minesweeper($wrong_types_fields);
        $minesweeper->createMinesweeper();
    }

    public function test_extreme_numeric_values()
    {
        $this->expectException(InvalidArgumentException::class);
        $extreme_values_fields = [
            new Field(-3, 5, 4),
            new Field(105, 5, 4),
            new Field(4, -7, 4),
            new Field(4, 112, 4),
            new Field(4, 5, -5),
            new Field(4, 5, 25),
        ];
        $minesweeper = new Minesweeper($extreme_values_fields);
        $minesweeper->createMinesweeper();
    }

    public function testMinesweeperCreation(): void
    {
        $fieldsList = [];
        $fields_data = [
            ["lines_count" => 7, "columns_count" => 4, "bombs_count" => 5],
            ["lines_count" => 6, "columns_count" => 3, "bombs_count" => 3],
            ["lines_count" => 4, "columns_count" => 8, "bombs_count" => 6],
            ["lines_count" => 7, "columns_count" => 7, "bombs_count" => 8],
        ];
        foreach ($fields_data as $field_data) {
            $fieldsList[] = new Field($field_data['lines_count'], $field_data['columns_count'], $field_data['bombs_count']);
        }
        $minesweeper = new Minesweeper($fieldsList);
        $minesweeper->createMinesweeper();

    }
}
