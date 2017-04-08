<?php


// First thing: analyses the input value. It must have the repository name and something "not malicious"
$issetrepo = isset($_GET['repo']);
$repolength = strlen($_GET['repo']) < 100;
$repostring = preg_match('/[a-zA-Z0-9-_]/', $_GET['repo']);
if ($issetrepo && $repolength && $repostring) {
    $repository_name = $_GET['repo'];
} else {
    exit();
}

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

    GLOBAL $authorizationstring;
    if (isset($authorizationstring)) {
        curl_setopt($ch, CURLOPT_USERPWD, $authorizationstring);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    }

    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}

/**
 * Format and output the content
 * @param $oage {string} The whole content to be outputed
 * @return {void} 
 */
function print_page($page) {
    header('Content-Type: text/plain');
    echo $page;
}

/**
 * Outpuths the whole thing, based in the uri.
 * @param $uri {string} The json uri
 * @param $prefix {string} Usable only in the recursive action to points out which folder is outputing.
 * @return {string} The string tree.
 */
function outputs_tree($uri, $prefix) {

    $return_string = "";

    $json_returned = curl_dir($uri);
    $obj = json_decode($json_returned);

    foreach ($obj as $entry) {
        $type = $entry->type;
        if ($type == "file") {
            $return_string .= $prefix . $entry->name . "\n";
        } else {
            //$return_string .= $prefix . "/" . $entry->url;
            $content = outputs_tree($entry->url, $entry->name . "/");
            $return_string .= $content;
        }
    }
    return $return_string;
}

function init_creds() {
    $file = 'php_recursive_directory_github_output.creds.php';
    if (file_exists($file) && is_readable($file)) {
        include_once($file);
        if ($authorizationstring == "USERNAME:PASSWORD") {
            $content = "You tryied to set the ahtorization string to get more requisitions from github server, but you did not changed anything." . "\n";
            $content .= "Write the correct credential string in the file or simple remove it to let script proced.";
            print_page($content);
            exit();
        }
        return $authorizationstring;
    }
}

// Usage
$authorizationstring = init_creds();
$uri = 'https://api.github.com/repos/danilocgsilva/' . $repository_name . '/contents?per_page=10000';
$content = outputs_tree($uri);
print_page($content);
