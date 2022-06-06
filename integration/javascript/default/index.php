<?php
# Local Secrets (rename (config.tpl.php -> config.php) and edit with your own values
/** @var $qit_config [] */
require_once(__DIR__ . '/../../../config.php');
// //static.queue-it.net/script/queueclient.min.js
// //static.queue-it.net/script/queueconfigloader.min.js
?>
<html lang="en">
<head>
    <title>JS</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <!-- Queue-it Javascript connector code -->
    <script type='text/javascript' src='../_connector/queueclient.js'></script>
    <script
            data-queueit-c='<?php echo $qit_config["customerID"]; ?>'
            type='text/javascript'
            src='../_connector/queueconfigloader.min.js'>
    </script>
    <!-- Queue-it Javascript connector code -->
    
</head>
<body>
<h1>JS - Default integration method</h1>
<p>Integrated using:</p>
<code>
	js code...
</code>
<a href="/">
    <button name="Back">Back</button>
</a>
</body>
</html>
