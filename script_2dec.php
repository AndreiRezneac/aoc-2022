<?php
declare(strict_types=1);

# aoc_day2_rock_paper_scissors

const FIGURE_SCORES = [
    'X' => 1, # Rock        A
    'Y' => 2, # Paper       B
    'Z' => 3, # Scissors    C
    'A' => 1,
    'B' => 2,
    'C' => 3,
];

const WIN_COMBINATIONS = [
    'A Y' => 6,
    'B Z' => 6,
    'C X' => 6,
];

const OUTCOME_SCORES = [
    'X' => 0,
    'Y' => 3,
    'Z' => 6
];

const WIN_STRATEGY = [
    'A' => 'Y',
    'B' => 'Z',
    'C' => 'X',
];

const DEFEAT_STRATEGY = [
    'A' => 'Z',
    'B' => 'X',
    'C' => 'Y',
];

function getScoreV1(string $playerOneFigure, string $playerTwoFigure): int
{
    $choiceScore = FIGURE_SCORES[$playerTwoFigure];
    $outcomeScore = getOutcomeScore($playerOneFigure, $playerTwoFigure);

    return $choiceScore + $outcomeScore;
}

function getOutcomeScore(string $playerOneFigure, string $playerTwoFigure): int
{
    if (FIGURE_SCORES[$playerOneFigure] === FIGURE_SCORES[$playerTwoFigure]) {
        return 3; # draw
    }

    $currentCombination = $playerOneFigure . ' ' . $playerTwoFigure;
    if (!empty(WIN_COMBINATIONS[$currentCombination])) {
        return 6; # win
    }

    return 0; # defeat
}

function getScoreV2(string $playerOneFigure, string $outcome): int
{
    $choiceScore = getFigureScore($playerOneFigure, $outcome);
    $outcomeScore = OUTCOME_SCORES[$outcome];

    return $choiceScore + $outcomeScore;
}

function getFigureScore(string $opponentFigure, string $outcome): int
{
    if (OUTCOME_SCORES[$outcome] === 0) { # defeat
        $figure = DEFEAT_STRATEGY[$opponentFigure];

        return FIGURE_SCORES[$figure];
    }

    if (OUTCOME_SCORES[$outcome] === 6) { # win
        $figure = WIN_STRATEGY[$opponentFigure];

        return FIGURE_SCORES[$figure];
    }

    return FIGURE_SCORES[$opponentFigure];
}

function calculate_total_score(string $filename): int
{
    $totalScore = 0;
    $fileContents = file_get_contents($filename);
    $lines = explode("\n", $fileContents);
    foreach ($lines as $line) {
        [$opponent, $player] = explode(' ', $line);
        $totalScore += getScoreV1($opponent, $player);
    }

    return $totalScore;
}

echo 'score 1: ', calculate_total_score('input_2dec.txt'), PHP_EOL;

function calculate_total_score2(string $filename): int
{
    $totalScore = 0;
    $fileContents = file_get_contents($filename);
    $lines = explode("\n", $fileContents);
    foreach ($lines as $line) {
        [$opponent, $player] = explode(' ', $line);
        $totalScore += getScoreV2($opponent, $player);
    }

    return $totalScore;
}

echo 'score 2: ', calculate_total_score2('input_2dec.txt'), PHP_EOL;
