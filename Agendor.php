<?php

if (!function_exists('curl_init')) {
    throw new Exception('Agendor needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
    throw new Exception('Agendor needs the JSON PHP extension.');
}

require(dirname(__FILE__) . '/lib/Agendor/Agendor.php');
require(dirname(__FILE__) . '/lib/Agendor/Set.php');
require(dirname(__FILE__) . '/lib/Agendor/Object.php');
require(dirname(__FILE__) . '/lib/Agendor/Util.php');
require(dirname(__FILE__) . '/lib/Agendor/Error.php');
require(dirname(__FILE__) . '/lib/Agendor/Exception.php');
require(dirname(__FILE__) . '/lib/Agendor/RestClient.php');
require(dirname(__FILE__) . '/lib/Agendor/Request.php');
require(dirname(__FILE__) . '/lib/Agendor/Model.php');
require(dirname(__FILE__) . '/lib/Agendor/People.php');
require(dirname(__FILE__) . '/lib/Agendor/Organization.php');
require(dirname(__FILE__) . '/lib/Agendor/Task.php');
require(dirname(__FILE__) . '/lib/Agendor/Deal.php');

// W6\Agendor\Agendor::setApiKey('f23cc874-d25b-4992-b396-8206e2261202'); // TOKEN_TESTE
