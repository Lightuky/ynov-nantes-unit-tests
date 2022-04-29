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
//      Debug non-formatted Boards :
//      print_r($boards);
//      die();

        $formattedBoards = $this->formatTiles($boards);
        print_r($formattedBoards);
        die();
        return $formattedBoards;
    }

    public function formatTiles($boards): array
    {
        foreach ($boards as $boardIndex => $board) {
            foreach ($board as $lineIndex => $line) {
                if ($lineIndex == 0) {
                    $line = "Field #" . $boardIndex + 1 . ":";
                } else {
                    $line = str_replace(".", "0", $line);
                    $line = str_split($line);
                }
                $boards[$boardIndex][$lineIndex] = $line;
            }
        }

//      Debug formatted but not bomb-numbered Boards :
//      print_r($boards);
//      die();

        return $this->countBombs($boards);
    }

    public function countBombs($boards): array
    {
        foreach ($boards as $boardIndex => $board) {
            foreach ($board as $lineIndex => $line) if ($lineIndex != 0) {
                foreach ($line as $charIndex => $char) {
                    if ($char != "*") {
                        $char = intval($char);
                        // Check left tile
                        if (array_key_exists($charIndex - 1, $line) && $line[$charIndex - 1] == "*") {
                            $char++;
                        }
                        // Check right tile
                        if (array_key_exists($charIndex + 1, $line) && $line[$charIndex + 1] == "*") {
                            $char++;
                        }
                        // Check down tile
                        if (array_key_exists($lineIndex - 1, $board) && $board[$lineIndex - 1][$charIndex] == "*") {
                            $char++;
                        }
                        // Check up tile
                        if (array_key_exists($lineIndex + 1, $board) && $board[$lineIndex + 1][$charIndex] == "*") {
                            $char++;
                        }
//
//                        // Check down-left tile
//                        if ($lineIndex > 1 && array_key_exists($lineIndex - 1, $board) && array_key_exists($charIndex - 1, $board[$lineIndex--]) && $board[$lineIndex - 1][$charIndex - 1] == "*") {
//                            $char++;
//                        }
//                        // Check down-right tile
//                        if ($lineIndex > 1 && array_key_exists($lineIndex - 1, $board) && array_key_exists($charIndex + 1, $board[$lineIndex--]) && $board[$lineIndex - 1][$charIndex + 1] == "*") {
//                            $char++;
//                        }
//                        // Check up-left tile
//                        if (array_key_exists($lineIndex + 1, $board)) {
//                            if (array_key_exists($charIndex - 1, $board[$lineIndex++]) && $board[$lineIndex + 1][$charIndex - 1] == "*") {
//                                $char++;
//                            }
//                        }
//                        // Check up-right tile
//                        if (array_key_exists($lineIndex + 1, $board) && $lineIndex + 1 <= count($board) && $charIndex + 1 <= count($line)) {
//                            if (array_key_exists($charIndex + 1, $board[$lineIndex++])) {
//                                if ($board[$lineIndex + 1][$charIndex + 1] == "*") {
//                                    $char++;
//                                }
//                            }
//                        }
                    }
                    print_r(" $char ");
                }
                print_r("\n");
                $boards[$boardIndex][$lineIndex] = implode($line);
            }
            print_r("\n");
        }

        // print_r($boards);
        die();
        return $boards;
    }
}