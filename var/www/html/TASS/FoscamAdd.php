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
$jdevices = $_iotJumpWayDevices->getDeviceList();
$devices = $_TASSfoscam->getTASSfoscams();

print_r($devices);
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

                <?php include dirname(__FILE__) . '/../TASS/includes/top.php'; ?>
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
                            
                            <div class="panel-body">

                                <form role="form" id="form">
                                    
                                    <div class="form-group">

                                        <label>Choose TASS Foscam iotJumpWay Device</label>
                                        <select id="deviceID" name="deviceID" class="form-control select-validate">

                                            <option value="">CHOOSE TASS FOSCAM DEVICE</option>
                                            <?php
                                                if(count($jdevices->ResponseData)):
                                                    foreach($jdevices->ResponseData AS $deviceKey => $devVal):
                                            ?>

                                            <option value="<?=abs($devVal->id); ?>,<?=$devVal->device; ?>"><?=abs($devVal->id); ?>: <?=$devVal->device; ?></option>

                                            <?php
                                                    endforeach;
                                                else:
                                            ?>
                                            
                                            <?php
                                                endif;
                                            ?>

                                        </select>

                                    </div>

                                    <div class="form-group">

                                        <label>RTSPuser</label>
                                        <input type="text" id="RTSPuser" name="RTSPuser" class="form-control text-validate" value="">
                                        <p class="help-block">Username for the RTSP stream. (Encrypted in your database)</p>

                                    </div>

                                    <div class="form-group">

                                        <label>RTSPpass</label>
                                        <input type="text" id="RTSPpass" name="RTSPpass" class="form-control text-validate" value="">
                                        <p class="help-block">Password for the RTSP stream. (Encrypted in your database)</p>

                                    </div>

                                    <div class="form-group">

                                        <label>RTSPip</label>
                                        <input type="text" id="RTSPip" name="RTSPip" class="form-control text-validate" value="">
                                        <p class="help-block">IP for the RTSP stream. (Encrypted in your database)</p>

                                    </div>
                                    
                                    <div class="form-group">

                                        <label>RTSPport</label>
                                        <input type="text" id="RTSPport" name="RTSPport" class="form-control text-validate" value="">
                                        <p class="help-block">Port for the RTSP stream. (Encrypted in your database)</p>

                                    </div>
                                    
                                    <div class="form-group">

                                        <label>RTSPendpoint</label>
                                        <input type="text" id="RTSPendpoint" name="RTSPendpoint" class="form-control text-validate" value="">
                                        <p class="help-block">Endpoint for the RTSP stream. (Encrypted in your database)</p>

                                    </div>

                                    <input type="hidden" id="ftype" name="ftype" value="addTASSfoscam" /> 
                                    <a class="btn btn-default" id="formSubmit">Submit</a>

                                    </form>

                            </div>
                            
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