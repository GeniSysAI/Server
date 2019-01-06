<?php session_start();

$pageDetails = [
    "PageID" => "Users"
];

include dirname(__FILE__) . '/../../classes/Core/init.php';
include dirname(__FILE__) . '/../../classes/Users/core.php';

include dirname(__FILE__) . '/../../classes/iotJumpWay/Devices.php';

print_r($_POST);
print_r($_FILES);
#session_destroy();
$_users->checkSession();
?>