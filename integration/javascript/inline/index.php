<?php
# Local Secrets (rename (config.tpl.php -> config.php) and edit with your own values
/** @var $qit_config [] */
require_once(__DIR__ . '/../../../config.php');

$qit_queueclient_js = file_get_contents(__DIR__ . '/js/queueclient.min.js');
$qit_queueconfigloader_js = file_get_contents(__DIR__ . '/js/queueconfigloader.min.js');


?>
<html lang="en">
<head>
    <title>JS</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <!-- Queue-it Javascript inline code -->
    <script type='text/javascript'><?php echo $qit_queueclient_js; ?></script>
    <script type='text/javascript' data-queueit-c='<?php echo $qit_config["customerID"]; ?>' data-queueit-noautorun="true" ><?php echo $qit_queueconfigloader_js; ?></script>
    
    <script type="text/javascript">
    	window.queueit_clientside_config={
    		"customerId":"adjatest",
    		"integrations":[
    		{"name":"JS-Q","actionType":"Queue","eventId":"qtestjprov2","cookieDomain":"","isCookieSecure":false,"queueDomain":"adjatest.queue-it.net","forcedTargetUrl":"","culture":"","extendValidity":true,"validity":3,"redirectLogic":"AllowTParameter",
    		"triggers":[{"triggerParts":[
    		{"operator":"Equals","valueToCompare":"qtest.jakab.pro","urlPart":"HostName","validatorType":"UrlValidator","isNegative":false,"isIgnoreCase":true},
    		{"operator":"Contains","valueToCompare":"/integration/javascriptx/","urlPart":"PagePath","validatorType":"UrlValidator","isNegative":false,"isIgnoreCase":true}]
    		,"logicalOperator":"And"}],"onVerified":"","onDisabled":"","onTimeout":"","removeTokenFromUrl":true,"queryStringPrefix":"qit"}]
    	};
    	QueueIt.Javascript.PageEventIntegration.initQueueClient(window.queueit_clientside_config);
    </script>
    <!-- Queue-it Javascript inline code -->
    
</head>
<body>
<h1>JS - Inline integration</h1>
<p>HI!</p>
<a href="/">
    <button name="Back">Back</button>
</a>

</body>
</html>
