<?php
/**
 * Secret values from GO Platform
 */
$qit_config = [
    /**
     * Your account name
     */
    "customerID" => "",

    /**
     * The secret key of your account will be used to hash the queue token
     */
    "secretKey" => "",

    /**
     * Needed to download the integration configuration file from the GO Platform
     */
    "apiKey" => "",

    /**
     * This file contains sensitive information about the actions and triggers of the Waiting Room
     * This is a text file and most web servers will allow access to it if under the web directory
     *
     * !!! Make sure this file is NOT accessible through http requests !!!
     */
    "integrationConfigPath" => __DIR__ . '/../tmp/integrationconfig.json',
];
