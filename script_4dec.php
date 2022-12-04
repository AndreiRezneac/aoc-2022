<?php
declare(strict_types=1);

echo calculate_number_of_partial_overlaps('input_4dec.txt') . PHP_EOL;

function calculate_number_of_full_overlaps(string $filename): int
{
    $totalScore = 0;
    $fileContents = file_get_contents($filename);
    $lines = explode("\n", $fileContents);
    foreach ($lines as $line) {
        [$firstRange, $secondRange] = explode(',', $line);
        if (is_full_overlap($firstRange, $secondRange)) {
            $totalScore++;
        }
    }

    return $totalScore;
}

function is_full_overlap(string $firstRange, string $secondRange): bool
{
    [$start1st, $end1st] = explode('-', $firstRange);
    [$start2nd, $end2nd] = explode('-', $secondRange);

    $isFirstInSecond = $start1st >= $start2nd && $end1st <= $end2nd;
    $isSecondInFirst = $start2nd >= $start1st && $end2nd <= $end1st;

    return $isFirstInSecond || $isSecondInFirst;
}

function calculate_number_of_partial_overlaps(string $filename): int
{
    $totalScore = 0;
    $fileContents = file_get_contents($filename);
    $lines = explode("\n", $fileContents);
    foreach ($lines as $line) {
        [$firstRange, $secondRange] = explode(',', $line);
        if (is_partial_overlap($firstRange, $secondRange)) {
            $totalScore++;
        }
    }

    return $totalScore;
}

function is_partial_overlap(string $firstRange, string $secondRange): bool
{
    [$start1st, $end1st] = explode('-', $firstRange);
    [$start2nd, $end2nd] = explode('-', $secondRange);

    $isStart2ndInFirstRange = $start1st <= $start2nd && $end1st >= $start2nd;
    $isStart1stInSecondRange = $start2nd <= $start1st && $end2nd >= $start1st;

    return $isStart2ndInFirstRange || $isStart1stInSecondRange;
}
