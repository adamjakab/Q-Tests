<?php
/* There is not much to do here */
header('custom-header-1: Hi There!');
header('custom-header-2: How are you doing?');
?>
<html lang="en">
<head>
    <title>CF</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">
</head>
<body>
<h1>CF</h1>
<p>HI!</p>

<p>
    For this to work you need to setup a CF worker and push the
    configuration to a protected route souch as 'https://qtest.jakab.pro/integration/cloudflare/?__push_queueit_config'
</p>
<a href="/">
    <button name="Back">Back</button>
</a>
</body>
</html>
