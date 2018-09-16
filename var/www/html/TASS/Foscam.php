<?php session_start();

$pageDetails = [
    "PageID" => "TASS"
];

include dirname(__FILE__) . '/../../classes/startup/init.php';
include dirname(__FILE__) . '/../../classes/users/core.php';
include dirname(__FILE__) . '/../../classes/iotJumpWay/Devices.php';
include dirname(__FILE__) . '/../../classes/TASS/core.php';
include dirname(__FILE__) . '/../../classes/TASS/Foscam.php';

$device  = $_GeniSys->_confs['tassID'] ? $_iotJumpWayDevices->getDevice($_GeniSys->_confs['tassID']) : null;
$devices = $_TASSfoscam->getTASSfoscams();

#print_r($devices);
#session_destroy();
$_users->checkSession();

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

        <title><?=$_GeniSys->_confs["meta_title"]; ?></title>
        <meta name="description" content="<?=$_GeniSys->_confs["meta_description"]; ?>">
        <meta name="author" content="Adam Milton-Barker">

        <link type="text/css" rel="stylesheet" href="<?=$_GeniSys->_confs["domainString"]; ?>/media/vendor/bootstrap/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="<?=$_GeniSys->_confs["domainString"]; ?>/media/vendor/metisMenu/metisMenu.min.css">
        <link type="text/css" rel="stylesheet" href="<?=$_GeniSys->_confs["domainString"]; ?>/media/css/sb-admin-2.css">
        <link type="text/css" rel="stylesheet" href="<?=$_GeniSys->_confs["domainString"]; ?>/media/vendor/font-awesome/css/font-awesome.min.css">
        <link type="text/css" rel="stylesheet" href="<?=$_GeniSys->_confs["domainString"]; ?>/media/GeniSys/GeniSys.css">
    
        <link type="image/x-icon" rel="icon" href="<?=$_GeniSys->_confs["domainString"]; ?>/media/images/site/favicon.png" />
        <link type="image/x-icon" rel="shortcut icon" href="<?=$_GeniSys->_confs["domainString"]; ?>/media/images/site/favicon.png" />
        <link type="image/x-icon" rel="apple-touch-icon" href="<?=$_GeniSys->_confs["domainString"]; ?>/media/images/site/favicon.png" />

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
                        <h1 class="page-header">TASS FOSCAM DEVICES</h1>
                    </div>
                </div>

                <?php include dirname(__FILE__) . '/../TASS/includes/TASSfoscam.php'; ?>
                <div class="clear"></div>
                
                <div class="row">

                    <div class="col-lg-8">

                        <div class="panel panel-default">

                            <div class="panel-heading">

                                <i class="fa fa-cogs fa-fw"></i> Manage TASS Foscam Devices

                                <div class="pull-right">

                                    <div class="btn-group">

                                        <a href="<?=$_GeniSys->_confs["domainString"]; ?>/TASS/FoscamAdd"><i class="fa fa-plus-circle fa-fw"></i></a> 

                                    </div>

                                </div>

                            </div>
                            
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                    if($devices["Response"]=="OK"):
                                        foreach($devices["ResponseData"] AS $deviceKey => $devVal):
                                ?>

                                    <tr class="odd gradeX">
                                        <td><?=abs($devVal["id"]); ?></td>
                                        <td><?=$_GeniSys->_helpers->decrypt($devVal["name"]); ?></td>
                                        <td><a href="<?=$_GeniSys->_confs["domainString"]; ?>/TASS/FoscamEdit?device=<?=abs($devVal["id"]); ?>"><i class="fa fa-edit fa-2x"></i></a></td>
                                    </tr>

                                <?php
                                        endforeach;
                                    endif;
                                ?>

                                </tbody>
                            </table>
                            
                        </div>
                        
                    </div>
                    <div class="col-lg-4">
        
                        <?php  include dirname(__FILE__) . '/../TASS/includes/deviceInfo.php'; ?>

                    </div>
                        
                </div>

            </div>
        
        </div>
        
        <?php  include dirname(__FILE__) . '/../includes/scripts.php'; ?>

        <script type="text/javascript">
        
        </script>
 
    </body>

</html> 