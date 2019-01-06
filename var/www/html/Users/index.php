<?php session_start();

$pageDetails = [
    "PageID" => "Users"
];

include dirname(__FILE__) . '/../../classes/Core/init.php';
include dirname(__FILE__) . '/../../classes/Users/core.php';

include dirname(__FILE__) . '/../../classes/iotJumpWay/Devices.php';

#print_r($_SESSION);
#session_destroy();
$_users->checkSession();
$users=$_users->getUsers([
    "Type"=>"Users"
]);

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <META name="robots" content="noindex, nofollow">

        <!-- 
          /*********************************************************
          ** @project GeniSys AI Location UI
          ** @author  Adam Milton-Barker <www.adammiltonbarker.com>
          **********************************************************/	
        -->

        <title><?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["meta_title"]); ?></title>
        <meta name="description" content="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["meta_description"]); ?>">
        <meta name="author" content="Adam Milton-Barker">

        <link type="text/css" rel="stylesheet" href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/media/GeniSys/GeniSys.css">
        <link type="text/css" rel="stylesheet" href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/media/vendor/bootstrap/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/media/vendor/metisMenu/metisMenu.min.css">
        <link type="text/css" rel="stylesheet" href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/media/css/sb-admin-2.css">
        <link type="text/css" rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
        <link type="image/x-icon" rel="icon" href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/media/images/site/favicon.png" />
        <link type="image/x-icon" rel="shortcut icon" href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/media/images/site/favicon.png" />
        <link type="image/x-icon" rel="apple-touch-icon" href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/media/images/site/favicon.png" />

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>
    
        <div id="wrapper">

            <?php include dirname(__FILE__) . '/../includes/nav.php'; ?>

            <div id="page-wrapper">

                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">USERS</h1>
                    </div>
                </div>
                
                <div class="row"> 

                    <div class="col-lg-8">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-users fa-fw"></i> Manage Location Users

                                <div class="pull-right">
                                    <div class="btn-group">
                                        <a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Users/Add"><i class="fa fa-user-plus fa-fw" style="color: #fff !important;"></i></a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="panel-body">
                            
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">ID</th>
                                            <th style="width: 20%;">Face</th>
                                            <th>User</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php 
                                            if($users["Response"]=="OK"):
                                                foreach($users["ResponseData"] AS $arrayKey => $arrayValue):
                                        ?>

                                        <tr class="odd gradeX">
                                            <td><?=$arrayValue["id"]; ?></td>
                                            <td><a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Users/User/<?=$arrayValue["id"]; ?>"><img src="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Users/profiles/<?=$arrayValue["image"]; ?>" style="width: 100%;" /></a></td>
                                            <td>
                                                <strong>Name:</strong> <?=$arrayValue["name"]; ?><br />
                                                <strong>Role:</strong> <?=$arrayValue["role"]; ?><br />
                                                <strong>Mood:</strong> <?=$arrayValue["mood"]; ?><br /><br />
                                                <strong>Last Seen:</strong> <?=date("Y-m-d H:i:s", $arrayValue["lastSeen"]); ?><br />
                                                <strong>Last Location:</strong> <?=$arrayValue["lastLocation"] ? $arrayValue["lastLocation"] : "NA"; ?><br />
                                                <strong>Last Floor:</strong> <?=$arrayValue["lastFloor"] ? $arrayValue["lastFloor"] : "NA"; ?><br />
                                                <strong>Last Zone:</strong> <?=$arrayValue["lastZone"] ? $arrayValue["lastZone"] : "NA"; ?>
                                            </td>
                                            <td class="center"><a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Users/User/<?=$arrayValue["id"]; ?>"><i class="fa fa-edit fa-fw" style="color: #fff !important;"></i></a></td>
                                        </tr>

                                        <?php 
                                                endforeach;
                                            endif;
                                        ?>
                                        
                                    </tbody>
                                </table>

                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="col-lg-4">

                        <?php  include dirname(__FILE__) . '/../Connectivity/includes/Live.php'; ?>

                    </div>

                </div>
            </div>
        </div>

        <?php  include dirname(__FILE__) . '/../includes/scripts.php'; ?>

        <script src="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Connectivity/Live/classes/mqttws31.js" type="text/javascript"></script>
        <script src="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Connectivity/Live/classes/iotJumpWay.js" type="text/javascript"></script>

    </body>
</html> 