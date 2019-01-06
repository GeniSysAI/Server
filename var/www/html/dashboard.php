<?php session_start();

$pageDetails = [
    "PageID" => "Dashboard"
];

include dirname(__FILE__) . '/../classes/Core/init.php';
include dirname(__FILE__) . '/../classes/Server/core.php';
include dirname(__FILE__) . '/../classes/Users/core.php';

include dirname(__FILE__) . '/../classes/AIcore/NLU/core.php';
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

       <style>
        </style>

    </head>

    <body>
    
        <div id="wrapper">

            <?php include dirname(__FILE__) . '/includes/nav.php'; ?>
    
            <div id="page-wrapper" style=" background: none !important;">

                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Server Dashboard</h1>
                    </div>
                    <div class="col-lg-12"><?php include dirname(__FILE__) . '/Server/includes/top.php'; ?></div>
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-superpowers fa-fw"></i> <?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["meta_title"]); ?> Core
                                <div class="pull-right">
                                    <div class="btn-group"></div>
                                </div>
                            </div>
                            <div class="panel-body">
                                    
                                <a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Server/" class="coreButtons">
                                    <div>

                                        <i class="fa fa-server fa-5x"></i><br />
                                        <strong>Server</strong>

                                    </div>
                                </a>
                                    
                                <a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/AIcore/Language/" class="coreButtons">
                                    <div>

                                        <i class="fa fa-language fa-5x"></i><br />
                                        <strong>Language</strong>

                                    </div>
                                </a>
                                    
                                <a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/AIcore/Vision/" class="coreButtons">
                                    <div>

                                        <i class="fa fa-eye fa-5x"></i><br />
                                        <strong>Vision</strong>

                                    </div>
                                </a>
                                
                                <a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Connectivity/" class="coreButtons">
                                    <div>

                                        <i class="fa fa-th fa-5x"></i><br />
                                        <strong>Connectivity</strong>

                                    </div>
                                </a>
                                
                                <a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/<?=$_GeniSys->_confs["phpmyadmin"]; ?>" class="coreButtons" target="_BLANK">
                                    <div>

                                        <i class="fa fa-database fa-5x"></i><br />
                                        <strong>Database</strong>

                                    </div>
                                </a>
                                
                                <a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Users/" class="coreButtons">
                                    <div>

                                        <i class="fa fa-users fa-5x"></i><br />
                                        <strong>Users</strong>

                                    </div>
                                </a>

                            </div>
                        </div>
                    
                        <?php  include dirname(__FILE__) . '/includes/cam.php'; ?>

                    </div>
                    <div class="col-lg-6">

                        <?php  include dirname(__FILE__) . '/Connectivity/includes/Live.php'; ?>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-commenting-o fa-fw"></i> Communicate
                                <div class="pull-right">
                                    <div class="btn-group"></div>
                                </div>
                            </div>

                            <div class="panel-body">

                                <?php 
                                    if($_GeniSys->_confs["nluID"]):
                                ?>

                                <div id="GeniSysChat" style="width: 100%; height: 250px; border: 1px solid #ccc; padding 5px; overflow: hidden; overflow-y: scroll;"></div>

                                <form role="form" id="form" append="true" appendid="GeniSysChat" >

                                    <div class="form-group">
                                        <input type="text" id="humanInput" name="humanInput" class="form-control text-validate" placeholder="Communicate with GeniSys">
                                    </div>

                                    <input type="hidden" id="ftype" name="ftype" value="nluInteract" /> 
                                    <a class="btn btn-default" id="formSubmit">Send</a>

                                </form>

                                <?php 
                                    else:
                                ?>

                                You need to setup your NLU and iotJumpWay device before you can interact with your NLU.

                                <?php 
                                    endif;


                                ?>

                            </div>
                        </div>
                        
                        <?php  include dirname(__FILE__) . '/includes/GeniSys.php'; ?>

                    </div>
                </div>
            </div>
        </div>
        
        <?php  include dirname(__FILE__) . '/includes/scripts.php'; ?>

        <script src="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Connectivity/Live/classes/mqttws31.js" type="text/javascript"></script>
        <script src="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Connectivity/Live/classes/iotJumpWay.js" type="text/javascript"></script>
 
    </body>
</html> 



                                
                