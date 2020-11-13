<?php
# CLI ONLY - enable this to disable non cli calls to this file
(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('cli only');

/**
 * 1) put this into crontab (every 5 minutes)
 * 2) make it callable only from cli (or localhost if you must)
 *
 * Ref: https://github.com/queueit/KnownUser.V3.PHP/tree/master/Documentation
 *
 **/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

# Local Secrets (rename (config.tpl.php -> config.php) and edit with your own values
/** @var $qit_config [] */
require_once(__DIR__ . '/../../config.php');

# Using Secure URL (API key protected)
$is_secure = true;
# For testing ONLY
# $is_secure = isset($_GET["get_secure_config"]) && $_GET["get_secure_config"] == 1;

# Configuration URL
if ($is_secure) {
    $url_tpl = "https://{CID}.queue-it.net/status/integrationconfig/secure/{CID}";
} else {
    $url_tpl = "https://{CID}.queue-it.net/status/integrationconfig/{CID}";
}
$config_url = str_replace("{CID}", $qit_config["customerID"], $url_tpl);


# Main logic
try {
    //print "Getting configuration[" . ($is_secure ? "secure" : "insecure") . "]...<br/>\n";
    $c = curl_init($config_url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

    $headers = [
        'Host: queue-it.net',
    ];
    if ($is_secure) {
        array_push($headers, 'api-key: ' . $qit_config["apiKey"]);
    }
    curl_setopt($c, CURLOPT_HTTPHEADER, $headers);

    $cfg_str = curl_exec($c);
    $http_code = curl_getinfo($c, CURLINFO_HTTP_CODE);
    $content_type = curl_getinfo($c, CURLINFO_CONTENT_TYPE);
    curl_close($c);

    if (200 != $http_code) {
        throw new Exception("Bad Response Code: " . $http_code, 1);
    }

    if ("application/json; charset=utf-8" != $content_type) {
        throw new Exception("Bad Content Type: " . $content_type, 2);
    }

    $c = json_decode($cfg_str);
    if (json_last_error()) {
        throw new Exception("Bad Configuration Data: " . json_last_error_msg(), 3);
    }

} catch (Exception $e) {
    print $e->getMessage() . "<br/>\n";
    unset($cfg_str);
}

if (!isset($cfg_str)) {
    die("KO! Unable to get configuration.");
}

/*
print("Got configuration for "
    . "<code>" . $c->CustomerId . "</code>/"
    . "<code>" . $c->AccountId . "</code> "
    . "version <code>" . $c->ConfigDataVersion . "</code> "
    . "<br/>\n");
*/

// Do something intelligent with the configuration...
if (@file_put_contents($qit_config["integrationConfigPath"], $cfg_str)) {
    print("OK.\n");
} else {
    print("ERROR!\n");
}

