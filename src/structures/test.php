<?php

require_once '../../vendor/autoload.php';

use DataStructure\structures\DoublyLinkedListNode;

$list = new DoublyLinkedListNode();;
$list->pushFirst(0);
$list->pushLast(1);
$list->pushFirst(2);
$list->pushLast(3);
$list->pushFirst(4);
$list->pushFirst(6);

foreach ($list as $value) {
    var_dump($value);
}

var_dump('---------');
unset($list[3]);
foreach ($list as $value) {
    var_dump($value);
}