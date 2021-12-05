<?php
# Local Secrets (rename (config.tpl.php -> config.php) and edit with your own values
/** @var $qit_config [] */
require_once(__DIR__ . '/../../config.php');
?>
<html lang="en">
<head>
    <title>JS</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">
    <link rel="stylesheet" href="/assets/css/style.css">
    <script type='text/javascript' src='//static.queue-it.net/script/queueclient.min.js'></script>
    <script
            data-queueit-c='<?php echo $qit_config["customerID"]; ?>'
            type='text/javascript'
            src='//static.queue-it.net/script/queueconfigloader.min.js'>
    </script>
</head>
<body>
<h1>JS</h1>
<p>HI!</p>
<a href="/">
    <button name="Back">Back</button>
</a>
</body>
</html>
