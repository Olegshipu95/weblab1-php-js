<?php
include "main.php";
include "connector.php";
$arrayX = array(-2, -1.5, -1, -0.5, 0, 1, 1.5, 2);
$arrayR = array(1, 1.5, 2, 2.5, 3);
date_default_timezone_set('Europe/Moscow');
$date = date('h:i:s');

function validateAndAnswer()
{
    $time_start = microtime(true);
    try {
        $x = returnFloatValue('x');
        $y = returnFloatValue('y');
        $r = returnFloatValue('r');
        if ((($x >= 0 && $y >= 0 && 4 * ($x * $x + $y * $y) <= $r * $r)) ||
            ($x >= 0 && $y <= 0 && ($x + $y >= -$r / 2)) ||
            ($x <= 0 && $y <= 0 && abs($x) <= $r && abs($y) <= $r / 2)) {
            $message = "In";
            $entry = "Yes";
        } else {
            $message = "Out";
            $entry = "No";
        }
        $time = strval(number_format(microtime(true) - $time_start, 10, ".", "") * 1000) . 'ms';
        $result = array($x, $y, $r, $message, $time);
        if (!isset($_SESSION['results'])) {
            $_SESSION['results'] = array();
        }
        $_SESSION['results'][] = $result;
        print_r('<tr><td>' . $x . '</td><td>' . $y . '</td><td>' . $r . '</td><td> ' . $entry .   '</td><td>' . $time . '</td></tr><div class="messageFromServer">' . $message .'</div>');
    } catch (Exception $e) {
        $time = strval(number_format(microtime(true) - $time_start, 10, ".", "") * 1000) . 'ms';
        sendException($e->getMessage(),$time);
    }
}

/**
 * @throws Exception
 */
function returnFloatValue(string $name): float
{
    if (isset($_POST[$name])) {
        $value = $_POST[$name];
    }
    else{
        throw new Exception('Value' .$name. 'is not on the server');
    }
    validateValue($value, $name);
    return floatval($value);
}

/**
 * @throws Exception
 */
function validateValue($value, $name)
{
    if ($value == null || $value == "") {
        throw new Exception('Value' . $name . ' is null');
    }
    if (!is_numeric($value)) {
        throw new Exception('Value' . $name . ' is not numeric');
    }
    if ($name === 'x') {
        checkX($value);
    } else if ($name === 'y') {
        checkY($value);
    } else if ($name === 'r') {
        checkR($value);
    }
}

/**
 * @throws Exception
 */
function checkX($x)
{
    global $arrayX;
    if (!in_array($x, $arrayX)) {
        throw new Exception("X is out of bounds ");
    }
}

/**
 * @throws Exception
 */
function checkY($y)
{
    if ($y >= 5 || $y <= -5) {
        throw new Exception("R is out of bounds ");
    }
}

/**
 * @throws Exception
 */
function checkR($r)
{
    global $arrayR;
    if (!in_array($r, $arrayR)) {
        throw new Exception("R is out of bounds ");
    }
}