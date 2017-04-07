<?php

// Init vars
// It is customized to fetch contents form danilocgsilva, but you can adapt to youts own necessities

// Function definitions

/**
 @param {string} $uri: The URI that return json.
 @return {string}: The return from uri.
 */
function curl_dir($uri) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $uri);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}

function print_page($page) {
    header('Content-Type: text/plain');
    echo $page;
}

// Usage
$content = curl_dir('https://api.github.com/repos/danilocgsilva/WebDevScripts/contents?per_page=10000');
print_page($content);
