<?php

if (!function_exists('curl_init')) {
    throw new Exception('PagarMe needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
    throw new Exception('PagarMe needs the JSON PHP extension.');
}

require(dirname(__FILE__) . '/lib/Agendor/Agendor.php');
require(dirname(__FILE__) . '/lib/Agendor/Error.php');
require(dirname(__FILE__) . '/lib/Agendor/Exception.php');
require(dirname(__FILE__) . '/lib/Agendor/Model.php');
require(dirname(__FILE__) . '/lib/Agendor/Object.php');
require(dirname(__FILE__) . '/lib/Agendor/People.php');
require(dirname(__FILE__) . '/lib/Agendor/Request.php');
require(dirname(__FILE__) . '/lib/Agendor/RestClient.php');
require(dirname(__FILE__) . '/lib/Agendor/Set.php');
require(dirname(__FILE__) . '/lib/Agendor/Subscription.php');
require(dirname(__FILE__) . '/lib/Agendor/Transaction.php');
require(dirname(__FILE__) . '/lib/Agendor/TransactionCommon.php');
require(dirname(__FILE__) . '/lib/Agendor/Util.php');
