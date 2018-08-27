<?php

require_once '../../vendor/autoload.php';

use DataStructure\structures\Stack;

$brackets = [
    '>' => '<',
    ')' => '(',
    ']' => '[',
    '}' => '{'
];
$open = ['<', '(', '[', '{'];
$close = ['>', ')', ']', '}'];

$string = '{{{{{{{sad(1)}';

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
}
var_dump($fail);