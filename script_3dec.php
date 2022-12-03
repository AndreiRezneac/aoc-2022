<?php
declare(strict_types=1);

//echo calculate_total_score('input_3dec.txt') . PHP_EOL;
echo calculate_total_score_for_group_badges('input_3dec.txt') . PHP_EOL;

function calculate_total_score(string $filename): int
{
    $lowerCaseLetters = range('a', 'z');
    $upperCaseLetters = range('A', 'Z');

    $flippedLowercaseLetters = array_flip($lowerCaseLetters);
    $flippedUppercaseLetter = array_flip($upperCaseLetters);

    $totalScore = 0;
    $fileContents = file_get_contents($filename);
    $lines = explode("\n", $fileContents);
    foreach ($lines as $line) {
        $item = get_item_in_both_compartments($line);
        $totalScore += get_item_score($item, $flippedLowercaseLetters, $flippedUppercaseLetter);
    }

    return $totalScore;
}

function calculate_total_score_for_group_badges(string $filename): int
{
    $lowerCaseLetters = range('a', 'z');
    $upperCaseLetters = range('A', 'Z');

    $flippedLowercaseLetters = array_flip($lowerCaseLetters);
    $flippedUppercaseLetter = array_flip($upperCaseLetters);

    $totalScore = 0;
    $group = [];
    $fileContents = file_get_contents($filename);
    $lines = explode("\n", $fileContents);
    foreach ($lines as $line) {
        $group[] = $line;
        if (count($group) === 3) {
            $item = get_badge_item(...$group);
            $totalScore += get_item_score($item, $flippedLowercaseLetters, $flippedUppercaseLetter);
            $group = [];
        }
    }

    return $totalScore;
}

function get_item_in_both_compartments(string $rucksackContents): string
{
    $items = str_split($rucksackContents);
    $compartmentSize = (int) (count($items) / 2);
    [$compartment1, $compartment2] = array_chunk($items, $compartmentSize);
    $itemsInBothCompartments = array_intersect($compartment1, $compartment2);

    return current($itemsInBothCompartments);
}

function get_item_score(string $item, array $flippedLowercaseLetters, array $flippedUppercaseLetter): int
{
    # a =  1;
    # z = 26;
    # A = 27;
    # Z = 52;

    $score = $flippedLowercaseLetters[$item] ?? null;
    if (is_int($score)) {
        return $score + 1;
    }

    $score = $flippedUppercaseLetter[$item] ?? null;
    if (is_int($score)) {
        return $score + 1 + 26;
    }

    return 0;
}

function get_badge_item(string $items1, string $items2, string $items3): string
{
    $set1 = str_split($items1);
    $set2 = str_split($items2);
    $set3 = str_split($items3);

    $commonItems = array_intersect($set1, $set2, $set3);

    return current($commonItems);
}
