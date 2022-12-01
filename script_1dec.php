<?php

$source = 'input_1dec.txt';

function get_max_calories_carried_by_an_elf(string $filename): int
{
	$max = 0;
	$fileContents = file_get_contents($filename);
	$lines = explode("\n", $fileContents);

	$currentAmount = 0;
	foreach($lines as $line) {
		if (empty($line)) {
			$currentAmount = 0;
			continue;
		}

		$currentAmount += (int)$line;
		if ($currentAmount > $max) {
			$max = $currentAmount;
		}
	}

	return $max;
}

//echo get_max_calories_carried_by_an_elf($source);

function get_max_calories_carried_by_any_three_elves(string $filename): int
{
    $caloriesPerElf = [];
    $fileContents = file_get_contents($filename);
    $lines = explode("\n", $fileContents);

    $i = 0;
    foreach($lines as $line) {
        if (empty($line)) {
            $i++;
            continue;
        }
        $caloriesPerElf[$i] += (int)$line;
    }

    sort($caloriesPerElf);
    $top3 = array_slice($caloriesPerElf, -3);

    return array_sum($top3);
}

echo get_max_calories_carried_by_any_three_elves($source);
