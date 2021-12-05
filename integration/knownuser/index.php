<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

# Queue-it Known User PHP Integration Libraries
$sdk_path = realpath(__DIR__ . '/../../sdk/KnownUser.V3.PHP');
require_once($sdk_path . '/Models.php');
require_once($sdk_path . '/KnownUser.php');

# Local Secrets (rename (config.tpl.php -> config.php) and edit with your own values
/** @var $qit_config [] */
require_once(__DIR__ . '/../../config.php');

# Integration Config
$integrationConfig = file_get_contents($qit_config["integrationConfigPath"]);
if (!$integrationConfig) {
    die("Missing Integration Config!");
}

# Main Logic for Validation / Redirect
$queueittoken = isset($_GET["queueittoken"]) ? $_GET["queueittoken"] : '';

try {
    $fullUrl = getFullRequestUri();
    $currentUrlWithoutQueueitToken = preg_replace("/([?&])(" . "queueittoken" . "=[^&]*)/i", "", $fullUrl);

    //Verify if user needs to be sent to the queue
    $result = QueueIT\KnownUserV3\SDK\KnownUser::validateRequestByIntegrationConfig(
        $currentUrlWithoutQueueitToken,
        $queueittoken,
        $integrationConfig,
        $qit_config["customerID"],
        $qit_config["secretKey"]
    );

    if ($result->doRedirect()) {
        //Adding no cache headers to prevent browsers to cache requests
        header("Expires:Fri, 01 Jan 1990 00:00:00 GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Pragma: no-cache");
        //end

        if (!$result->isAjaxResult) {
            //Send the user to the queue - either because hash was missing or because is was invalid
            header('Location: ' . $result->redirectUrl);
        } else {
            header('HTTP/1.0: 200');
            header($result->getAjaxQueueRedirectHeaderKey() . ': ' . $result->getAjaxRedirectUrl());
        }

        die();
    }

    if (!empty($queueittoken) && $result->actionType == "Queue") {
        //Request can continue
        // We remove queueit token from the querystring parameter to avoid sharing of user specific token
        header('Location: ' . $currentUrlWithoutQueueitToken);
        die();
    }
} catch (Exception $e) {
    // There was an error validating the request
    // Use your own logging framework to log the error
}

/**
 * @return string
 * @todo: Move it to somewhere more convenient
 *
 */
function getFullRequestUri()
{
    // Get HTTP/HTTPS (the possible values for this vary from server to server)
    $myUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && !in_array(strtolower($_SERVER['HTTPS']), array('off', 'no'))) ? 'https' : 'http';
    // Get domain portion
    $myUrl .= '://' . $_SERVER['HTTP_HOST'];
    // Get path to script
    $myUrl .= $_SERVER['REQUEST_URI'];
    // Add path info, if any
    if (!empty($_SERVER['PATH_INFO'])) $myUrl .= $_SERVER['PATH_INFO'];

    return $myUrl;
}

?>

<html lang="en">
<head>
    <title>KU(PHP)</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">
</head>
<body>
<h1>KU</h1>
<p>HI!</p>
<a href="/">
    <button name="Back">Back</button>
</a>
</body>
</html>
