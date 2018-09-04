<?php

require_once '../../vendor/autoload.php';

use DataStructure\structures\Stack;

$input = fopen("php://stdin", "r");
$output = fopen("php://stdout", "w");

fwrite($output, "Введите строку для проверки баланка скобок: \r\n");
fscanf($input, "%s", $string);

$brackets = [
    '>' => '<',
    ')' => '(',
    ']' => '[',
    '}' => '{'
];
$open = ['<', '(', '[', '{'];
$close = ['>', ')', ']', '}'];

$stack = new Stack();
$fail = false;
for ($i = 0; $i < strlen($string); $i++) {
    if (in_array($string{$i}, $open)) {
        $stack->push($string{$i});
    }
    if (in_array($string{$i}, $close)) {
        if (!$stack->isEmpty() && $stack->top() === $brackets[$string{$i}]) {
            $stack->pop();
        } else {
            $fail = true;
            break;
        }
    }
}
if (!$stack->isEmpty()) {
    $fail = true;
    fprintf($output, "Баланс скобок не соблюдён");
} else {
    fprintf($output, "Баланс скобок соблюдён");
}