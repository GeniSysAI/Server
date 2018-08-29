<?php session_start();
include dirname(__FILE__) . '/../classes/startup/init.php';

$pageDetails = [
    "PageID" => "Dashboard",
    "Domain" => $_GeniSys->_confs["domainString"] 
];

include dirname(__FILE__) . '/../classes/users/users.php';

print_r($_SESSION);
session_destroy();
$_users->checkSession();

?>