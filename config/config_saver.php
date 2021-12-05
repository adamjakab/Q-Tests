<?php
/**
 * GO Platform PUT intercept code to receive and store your Integration configuration in a local json file.
 *
 * To make this work you must:
 * - Go to Integration -> Overview -> Settings
 * - Change the 'Publish web endpoint' to point to this file and add an additional
 *      '?__push_queueit_config' URL parameter to the URL so it looks like
 *      'https://your.domain.com/config/config_saver.php?__push_queueit_config'
 *  - Adjust the 'secretKey' and the 'integrationConfigPath' variables in config.php
 * - Publish (or force "Push Now") and verify that your configuration is stored
 *
 * If this script fails, it will generate a "config_saver.log" file which can be used for debugging.
 *
 * Ref: https://github.com/queueit/KnownUser.V3.PHP/tree/master/Documentation
 *
 **/

# Local Secrets (rename (config.tpl.php -> config.php) and edit with your own values
/** @var $qit_config [] */
require_once(__DIR__ . '/../config.php');

$log_data = '';

function log_and_die($log_msg, $die_msg = '', $http_response_code = 500) {
    // Log if there is anything to log
    if (!empty($log_msg)) {
        file_put_contents(__DIR__ . '/config_saver.log', $log_msg);
    }
    http_response_code($http_response_code);
    die($die_msg);
}

# Incoming request sanity check
# Check HTTP PUT request
if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
    log_and_die($log_data, 'Method Not Allowed', 405);
}
# Check for "secret" query string
if ($_SERVER['QUERY_STRING'] != '__push_queueit_config') {
    log_and_die($log_data, 'Unauthorized', 401);
}
# Check Content Type
if ($_SERVER['CONTENT_TYPE'] != 'application/json; charset=utf-8') {
    log_and_die($log_data, 'Bad Request', 400);
}

# Read the data
$raw_data = null;
try {
    $f = fopen('php://input', 'r');
    $raw_data = '';
    while($data = fread($f, 1024))
        $raw_data .= $data;
    fclose($f);
} catch (Exception $e) {
    $error_msg = 'Unable to read PUT data from request.';
    $log_data .= "\n" . $error_msg . ": " . $e->getMessage() . "\n";
    log_and_die($log_data, $error_msg);
}

# Check data length
if (strlen($raw_data) !=  $_SERVER['CONTENT_LENGTH']) {
    $error_msg = 'Received data lenght is different from expected.';
    $log_data .= "\n" . $error_msg . "\n";
    log_and_die($log_data, $error_msg);
}

# Convert to JSON
$put_data = null;
try {
    $put_data = json_decode($raw_data);
}  catch (Exception $e) {
    $error_msg = 'Unable to convert PUT data to JSON.';
    $log_data .= "\n" . $error_msg . ": " . $e->getMessage() . "\n";
    log_and_die($log_data, $error_msg);
}

# Verify authenticity
$hash_incoming = $put_data->hash;
$hash_calculated = hash_hmac('sha256', $put_data->integrationInfo, $qit_config["secretKey"]);
if ($hash_calculated !=  $hash_incoming) {
    $log_data .= "\nTimestamp: " . date('Y-m-d H:i:s'). "\n";
    $error_msg = 'Authenticity check failed!' . "\n";
    $error_msg .= 'Hash(incoming): ' . $hash_incoming . "\n";
    $error_msg .= 'Hash(calculated): ' . $hash_calculated . "\n";
    $log_data .= "\n" . $error_msg . "\n";
    log_and_die($log_data, $error_msg);
}

# Store config in file
$cfg_str = hex2bin($put_data->integrationInfo);
if (!@file_put_contents($qit_config["integrationConfigPath"], $cfg_str)) {
    $error_msg = 'Unable to store the configuration file.';
    $log_data .= "\n" . $error_msg . "\n";
    log_and_die($log_data, $error_msg);
}


# Done
//$log_data .= "\nConfiguration stored (" . date('Y-m-d H:i:s'). ").\n";
//$log_data .= "\nPUT DATA: " . json_encode($put_data). "\n";
//$log_data .= "\nSERVER DATA: " . json_encode($_SERVER). "\n";
log_and_die($log_data, "OK", 200);

