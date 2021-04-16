<?php
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

//--------------------------------------------------
$contents = readHttpLikeInput();

function outputHttpResponse($statuscode, $statusmessage, $headers, $body)
{
    echo 'HTTP/1.1 ' . $statuscode . ' ' . $statusmessage . "\n" .
        'Date: ' . date('D\, d M Y G:i:s e') . "\n";
    if ($headers != false) {
        foreach ($headers as $key => $value) {
            echo "{$key}: {$value}\n";
        }
    }
    echo "\n\r";
    if($body != '') {
        echo $body;
    }
}

function processHttpRequest($method, $uri, $headers, $body)
{
    if(checkContentLength($headers) == false){
        return;
    }
    if ($method != 'GET' or !stristr($uri, '?nums', false)) {
        outputHttpResponse('400', 'Bad Request', $headers, $body);
        echo "\n\r\n\rnot found";
        echo "\n\r";
        return;
    }

    if (!stristr($uri, '/sum', false)) {
        outputHttpResponse('404', 'Not Found', $headers, $body);
        echo "\n\r\n\rnot found";
        echo "\n\r";
        return;
    }

    outputHttpResponse('200', 'OK', $headers, $body);
    echo "\r\n" . array_sum(str_split($uri));
    echo "\n\r";
}

function checkContentLength($headers, $body)
{
if($headers != false and (int) $headers['Content-Length'] == iconv_strlen($body)){
    return true;
}
return false;
}

//-------------------------------------------------------------------------
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
    $string = stristr($string, ' ', true);
    $string = removeUnnecessaryCharas($string);
    return $string;
}

/*
 * A function that returns the URI of an HTTP request.
 */
function getUri($string)
{
    $string = stristr($string, ' ', false);
    $string = removeFirstChar($string);
    $string = stristr($string, ' ', true);
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
        if (strpos($string, "\n") != false) {
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
        if ($string == $substring) {
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
    return preg_replace('~\s+~s', '', $string);
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
processHttpRequest($http["method"], $http["uri"], $http["headers"], $http["body"]);
