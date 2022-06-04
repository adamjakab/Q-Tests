<?php
# Local Secrets (rename (config.tpl.php -> config.php) and edit with your own values
/** @var $qit_config [] */
require_once(__DIR__ . '/../../../config.php');

$qit_queueclient_js = file_get_contents(__DIR__ . '/js/queueclient.min.js');



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
    <script type='text/javascript'>
    	<?php echo $qit_queueclient_js; ?>
    </script>
    
</head>
<body>
<h1>JS - Inline integration</h1>
<p>HI!</p>
<a href="/">
    <button name="Back">Back</button>
</a>
</body>
</html>
