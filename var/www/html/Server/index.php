<?php session_start();

$pageDetails = [
    "PageID" => "Server"
];

include dirname(__FILE__) . '/../../classes/startup/init.php';
include dirname(__FILE__) . '/../../classes/users/core.php';
include dirname(__FILE__) . '/../../classes/iotJumpWay/Devices.php';
include dirname(__FILE__) . '/../../classes/Server/core.php';

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
                        <h1 class="page-header">SERVER SETTINGS</h1>
                    </div>
                </div>

                <?php include dirname(__FILE__) . '/../includes/serverTop.php'; ?>
                <div class="clear"></div>
                
                <div class="row"> 

                    <div class="col-lg-8">

                        <div class="panel panel-default">

                            <div class="panel-heading">

                                <i class="fa fa-cogs fa-fw"></i> Manage Server Settings

                                <div class="pull-right">

                                    <div class="btn-group">

                                    </div>

                                </div>

                            </div>
                            
                            <div class="panel-body">

                                <form role="form" id="form">

                                    <div class="form-group">

                                        <label>Server Name</label>
                                        <input type="text" id="meta_title" name="meta_title" class="form-control text-validate" value="<?=$_GeniSys->_confs['meta_title']; ?>">
                                        <p class="help-block">Name of server, also used as meta title.</p>

                                    </div>

                                    <div class="form-group">

                                        <label>Server URL</label>
                                        <input type="text" id="domainString" name="domainString" class="form-control text-validate" value="<?=$_GeniSys->_confs['domainString']; ?>">
                                        <p class="help-block">URL of server.</p>

                                    </div>

                                    <div class="form-group">

                                        <label>iotJumpWay API URL</label>
                                        <input type="text" id="jumpwayAPI" name="jumpwayAPI" class="form-control text-validate" value="<?=$_GeniSys->_confs['jumpwayAPI']; ?>">
                                        <p class="help-block">URL of iotJumpWay API.</p>

                                    </div>

                                    <input type="hidden" id="ftype" name="ftype" value="updateServer" /> 
                                    <a class="btn btn-default" id="formSubmit">Submit</a>

                                </form>

                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="col-lg-4">

                        <?php  include dirname(__FILE__) . '/../Server/includes/serverInfo.php'; ?>

                    </div>
                        
                </div>

            </div>
        
        </div>
        
        <?php  include dirname(__FILE__) . '/../includes/scripts.php'; ?>
 
    </body>

</html> 