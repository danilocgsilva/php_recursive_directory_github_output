<?php

// Init vars
// It is customized to fetch contents form danilocgsilva, but you can adapt to youts own necessities

// Function definitions

/**
 * Outputs the content given a json uri
 * @param {string} $uri: The URI that return json.
 * @return {string}: The return from uri.
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

/**
 * Format and output the content
 * @param {string} The whole content to be outputed
 * @return {void} 
 */
function print_page($page) {
    header('Content-Type: text/plain');
    echo $page;
}

/**
 */
function outputs_tree($uri, $prefix) {

    $return_string = "";

    $return_string .= "uri: " . $uri . "\n";
    $return_string .= "prefixo: " . $prefix . "\n";


    $json_returned = curl_dir($uri);
    $obj = json_decode($json_returned);

    foreach ($obj as $entry) {
        $type = $entry->type;
        if ($type == "file") {
            $return_string .= $prefix . $entry->name;
        } else {
            //$return_string .= $prefix . "/" . $entry->url;
            $content = outputs_tree($entry->url, $entry->name);
            $return_string .= $content;
        }
        $return_string .= "\n";
    }
    return $return_string;
    
}

// Usage
$content = outputs_tree('https://api.github.com/repos/danilocgsilva/danilocgsilva_shell_libs/contents?per_page=10000');
print_page($content);
