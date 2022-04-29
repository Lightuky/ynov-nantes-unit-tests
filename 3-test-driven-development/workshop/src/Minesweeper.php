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

    public function createMinesweeper(): array
    {
        $boards = [];
        foreach ($this->fields as $field) {
            if ($field->linesCount == 0 && $field->columnsCount == 0) {
                break;
            } elseif ($field->linesCount < 0 || $field->columnsCount < 0 || $field->linesCount > 100 || $field->columnsCount > 100) {
                throw new InvalidArgumentException("Lines/Columns count must be between 1 and 100");
            } elseif ($field->bombsCount < 1 || $field->bombsCount > ($field->linesCount * $field->columnsCount) / 5) {
                throw new InvalidArgumentException("Bombs count must be between 1 and 1/5 of the tiles");
            } else {
                $board = [$field->linesCount . " " . $field->columnsCount];
                $tileStr = str_repeat(".", $field->linesCount * $field->columnsCount);
                $randBombIndexes = array_rand(range(0, ($field->linesCount * $field->columnsCount) - 1), $field->bombsCount);
                $sliceLimit = 0;
                foreach ($randBombIndexes as $randBombIndex) {
                    $tileStr = substr_replace($tileStr, "*", $randBombIndex, 1);
                }
                for ($i = 0; $i < $field->linesCount; $i++) {
                    $board[$i + 1] = substr($tileStr, $sliceLimit, $field->columnsCount);
                    $sliceLimit = $sliceLimit + $field->columnsCount;
                }
                $boards[] = $board;
            }
        }
//        Debug non-formatted Boards :
//        print_r($boards);
//        die();
        return $this->formatTiles($boards);
    }

    public function formatTiles($boards): array
    {
        $formattedBoards = [];
        foreach ($boards as $key => $board) {
            $board = str_replace(".", "0", $board);
            $board[0] = "Field #" . $key . ":";
            $formattedBoards[] = $board;
        }
        print_r($formattedBoards);
        die();
        return $formattedBoards;
    }
}