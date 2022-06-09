<?php

$arr = ["a","b","c","d","e"];
$arr1 = ["a","b"];
$arr2 = ["c","d","e", "m"];

var_dump(array_diff($arr, $arr1, $arr2));