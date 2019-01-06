<?php session_start();

$pageDetails = [
    "PageID" => "iotJumpWay"
];

include dirname(__FILE__) . '/../../classes/Core/init.php';
include dirname(__FILE__) . '/../../classes/Server/core.php';
include dirname(__FILE__) . '/../../classes/Users/core.php';

include dirname(__FILE__) . '/../../classes/iotJumpWay/core.php';
include dirname(__FILE__) . '/../../classes/iotJumpWay/Devices.php';

#print_r($_SESSION);
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
                        <h1 class="page-header">CONNECTIVITY</h1>
                    </div>
                </div>
                
                <div class="row"> 
                    <div class="col-lg-8">

                        <form role="form" id="form">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-cogs fa-fw"></i> Manage Connectivity URLs
                                    <div class="pull-right">
                                        <div class="btn-group"></div>
                                    </div>
                                </div>
                                
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label>API URL</label>
                                        <input type="text" id="jumpwayAPI" name="jumpwayAPI" class="form-control text-validate" value="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs['jumpwayAPI']); ?>">
                                        <p class="help-block">Base URL of iotJumpWay API</p>
                                    </div>

                                </div>
                            </div>  

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-cogs fa-fw"></i> Manage Connectivity Location Settings
                                    <div class="pull-right">
                                        <div class="btn-group"></div>
                                    </div>
                                </div>
                                
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label>Location ID</label>
                                        <input type="text" id="jumpwayLocation" name="jumpwayLocation" class="form-control text-validate" value="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs['jumpwayLocation']); ?>">
                                        <p class="help-block">iotJumpWay Location ID.</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Zone ID</label>
                                        <input type="text" id="jumpwayZone" name="jumpwayZone" class="form-control text-validate" value="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs['jumpwayZone']); ?>">
                                        <p class="help-block">iotJumpWay Zone ID</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Device ID</label>
                                        <input type="text" id="jumpwayDevice" name="jumpwayDevice" class="form-control text-validate" value="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs['jumpwayDevice']); ?>">
                                        <p class="help-block">iotJumpWay Device ID</p>
                                    </div>

                                </div>
                            </div> 

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-cogs fa-fw"></i> Manage Connectivity Application Settings
                                    <div class="pull-right">
                                        <div class="btn-group"></div>
                                    </div>
                                </div>
                                
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label>App ID</label>
                                        <input type="text" id="jumpwayAppID" name="jumpwayAppID" class="form-control text-validate" value="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs['jumpwayAppID']); ?>">
                                        <p class="help-block">iotJumpWay App ID</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Public Key</label>
                                        <input type="text" id="JumpWayAppPublic" name="JumpWayAppPublic" class="form-control text-validate" value="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs['JumpWayAppPublic']); ?>">
                                        <p class="help-block">iotJumpWay Public Key</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Private Key</label>
                                        <input type="text" id="JumpWayAppSecret" name="JumpWayAppSecret" class="form-control text-validate" value="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs['JumpWayAppSecret']); ?>">
                                        <p class="help-block">iotJumpWay Private Key</p>
                                    </div>

                                </div>
                            </div> 

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-cogs fa-fw"></i> Manage Connectivity MQTT Settings
                                    <div class="pull-right">
                                        <div class="btn-group"></div>
                                    </div>
                                </div>
                                
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label>MQTT User</label>
                                        <input type="text" id="JumpWayMqttUser" name="JumpWayMqttUser" class="form-control text-validate" value="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs['JumpWayMqttUser']); ?>">
                                        <p class="help-block">iotJumpWay App ID</p>
                                    </div>

                                    <input type="hidden" id="ftype" name="ftype" value="updateJumpWay" /> 
                                    <a class="btn btn-default" id="formSubmit">Submit</a>

                                </div>

                            </div>

                        </form>
                        
                    </div>
                    <div class="col-lg-4">

                        <?php  include dirname(__FILE__) . '/../Connectivity/includes/Connectivity.php'; ?>

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