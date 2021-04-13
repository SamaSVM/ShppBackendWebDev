<?php
// не обращайте на эту функцию внимания
// она нужна для того чтобы правильно считать входные данные
function readHttpLikeInput()
{
    $f = fopen('php://stdin', 'r');
    $store = "";
    $toread = 0;
    while ($line = fgets($f)) {
        $store .= preg_replace("/\r/", "", $line);
        if (preg_match('/Content-Length: (\d+)/', $line, $m))
            $toread = $m[1] * 1;
        if ($line == "\r\n")
            break;
    }
    if ($toread > 0)
        $store .= fread($f, $toread);
    return $store;
}

$contents = readHttpLikeInput();

function parseTcpStringAsHttpRequest($string)
{
    return array(
        "method" => getMethod($string),
        "uri" => getUri($string),
        "headers" => getHeaders($string),
        "body" => getBody($string),
    );
}

/*
 * A function that returns an HTTP request method.
 */
function getMethod($string)
{
    $string = stristr ( $string , ' ' , true );
    $string = removeUnnecessaryCharas($string);
    return $string;
}

/*
 * A function that returns the URI of an HTTP request.
 */
function getUri($string)
{
    $string = stristr ( $string , ' ' , false );
    $string = removeFirstChar($string);
    $string = stristr ( $string , ' ' , true );
    return $string;
}

/*
 * A function that returns an array of all HTTP request headers.
 */
function getHeaders($string)
{
    if (strpos($string, ':') == false) {
        return null;
    }

    $string = stristr($string, "\n", false);
    $string = stristr($string, "\n\r", true);
    $string = removeFirstChar($string);

    $result = array();

    while (strpos($string, ':') != false) {
        if(strpos($string, "\n") != false) {
            $substring = stristr($string, "\n", true);
            $substring = removeUnnecessaryCharas($substring);
            $string = stristr($string, "\n", false);
            $string = removeFirstChar($string);
        } else {
            $substring = $string;
        }

        $key = stristr($substring, ':', true);
        $value = stristr($substring, ' ', false);
        $value = removeUnnecessaryCharas($value);
        $result[$key] = $value;
        if($string == $substring){
            break;
        }
    }
    return $result;
}

/*
 * A function that returns the body of an HTTP request.
 */
function getBody($string)
{
    $string = stristr($string, "\n\r", false);
    $string = removeUnnecessaryCharas($string);
    return $string;
}

/*
 * A function that removes all spaces of tabs and the next line.
 */
function removeUnnecessaryCharas($string)
{
    return preg_replace('~\s+~s', '', $string );
}

/*
 * A function that removes the first character from a string.
 */
function removeFirstChar($string)
{
    $i = 0;
    $string = substr_replace($string, '', $i, 1);
    return $string;
}

$http = parseTcpStringAsHttpRequest($contents);
echo(json_encode($http, JSON_PRETTY_PRINT));
