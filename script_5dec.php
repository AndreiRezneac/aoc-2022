<?php
declare(strict_types=1);

echo calculate('input_5dec.txt') . PHP_EOL;

function calculate(string $filename): string
{
    $fileContents = file_get_contents($filename);
    $lines = explode("\n", $fileContents);
    $stacksDescription = [];
    $stacks = [];
    foreach ($lines as $line) {
        if (empty($stacks) && !empty($line)) {
            $stacksDescription[] = $line;
        }
        if (empty($line) && !empty($stacksDescription)) {
            $stacks = get_stacks_transposed($stacksDescription);
            unset($stacksDescription);
            continue;
        }
        if (!empty($stacks) && empty($stacksDescription)) {
            $stacks = move_crates_in_one_go($stacks, $line);
        }

    }
    return get_top_crates($stacks);
}

function get_top_crates(array $stacks): string
{
    $result = '';
    foreach ($stacks as $stack) {
        $result .= array_pop($stack);
    }

    return strtr($result, ['[' => '', ']' => '']) ;
}

function move_crates(array $stacks, string $instruction): array
{
    [, $cratesCount, , $fromStack, , $toStack] = explode(' ', $instruction);
    for ($i = 0; $i < (int)$cratesCount; $i++) {
        $crate = array_pop($stacks[(int)$fromStack - 1]);
        $stacks[(int)$toStack - 1][] = $crate;
    }

    return $stacks;
}

function move_crates_in_one_go(array $stacks, string $instruction): array
{
    [, $cratesCount, , $fromStack, , $toStack] = explode(' ', $instruction);
    $targetStack = (int)$toStack - 1;
    $originStack = (int)$fromStack - 1;

    if (!is_array($stacks[$originStack])) {
        echo $cratesCount, ' : ' ,$fromStack, ' : ', $toStack, PHP_EOL, $instruction, PHP_EOL;
        print_r($stacks) . PHP_EOL;

        return $stacks;
    }

    $cratesMoved = array_splice($stacks[$originStack], -$cratesCount);
    $stacks[$targetStack] = array_merge($stacks[$targetStack], $cratesMoved);

    return $stacks;
}

/**
 * @return array[][]
 * returned stacks that look like this
 *
 * 0 : [A] [B] [C]
 * 1 : [Z]
 * 3 :
 * 4 : [Y] [K]
 * etc
 */
function get_stacks_transposed(array $stacksDescription): array
{
    $reversedDescription = array_reverse($stacksDescription);
    unset($reversedDescription[0]); // remove the stack numbering
    foreach ($reversedDescription as $row => $line) {
        $reversedDescription[$row] = explode(' ', $line);
    }

    $emptyCratesOut = static fn(string $crate) => $crate !== '[_]';

    $stacks = [];
    for ($i = 0, $columns = count($reversedDescription[1]); $i < $columns; $i++) {
        $stackRaw = array_column($reversedDescription, $i);
        $stacks[$i] = array_filter($stackRaw, $emptyCratesOut);
    }

    return $stacks;
}
