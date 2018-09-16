<?php session_start();

$pageDetails = [
    "PageID" => "Dashboard"
];

include dirname(__FILE__) . '/../classes/startup/init.php';
include dirname(__FILE__) . '/../classes/users/core.php';
include dirname(__FILE__) . '/../classes/Server/core.php';
include dirname(__FILE__) . '/../classes/NLU/core.php';

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

            <?php include dirname(__FILE__) . '/includes/nav.php'; ?>
    
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Dashboard</h1>
                    </div>
                    
                </div>

                <?php include dirname(__FILE__) . '/includes/homeTop.php'; ?>
                
                <div class="row"> 

                    <div class="col-lg-8">
                        
                        <div class="well">
                            <h4>Welcome To The GeniSys Server UI</h4>
                            <p>You can manage your GeniSys network including your NLU Engine, local server TASS camera and TASS Fascom devices from this UI.</p>
                            
                            <ul>
                                <li><a href="<?=$_GeniSys->_confs["domainString"]; ?>/NLU/">Manage NLU Engine</a></li>
                                <li><a href="<?=$_GeniSys->_confs["domainString"]; ?>/TASS/">Manage TASS Local</a></li>
                                <li><a href="<?=$_GeniSys->_confs["domainString"]; ?>/TASS/Foscam">Manage TASS Foscam Devices</a></li>
                            </ul>

                            <p>Providing you have set up your TASS Local and your NLU Engine, you will be able to see the server camera stream and interact with the NLU engine using the interfaces below.</p>

                            <p>For support please visit the issues are in the relevant <a href="https://github.com/GeniSysAI/">GeniSys AI Github Repos</a>.</p>
                            
                        </div>
                    
                    </div>
                    <div class="col-lg-4">
        
                        <?php  include dirname(__FILE__) . '/includes/GeniSys.php'; ?>
                    
                    </div>
                    
                </div>
                <div class="clear"></div>
                
                <div class="row"> 

                    <div class="col-lg-8">
                
                        <div class="row"> 

                            <div class="col-lg-6">

                                <div class="panel panel-default">

                                    <div class="panel-heading">

                                        <i class="fa fa-eye fa-fw"></i> LOCAL TASS

                                        <div class="pull-right">

                                            <div class="btn-group"></div>

                                        </div>

                                    </div>
                                    
                                    <div class="panel-body">

                                        <img src="<?=$_GeniSys->_confs["tassAddress"]; ?>/<?=time(); ?>.mjpg"  style="width: 100%;" />

                                    </div>
                                    
                                </div>

                            </div>
                            <div class="col-lg-6">
                            

                                <div class="panel panel-default">

                                    <div class="panel-heading">

                                        <i class="fa fa-commenting-o fa-fw"></i> LOCAL NLU

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
                                                <label>Talk to your AI</label>
                                                <input type="text" id="humanInput" name="humanInput" class="form-control text-validate" autofocus>
                                            </div>

                                            <input type="hidden" id="ftype" name="ftype" value="nluInteract" /> 
                                            <a class="btn btn-default" id="formSubmit">Submit</a>

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
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="col-lg-4">

                        <?php  include dirname(__FILE__) . '/Server/includes/serverInfo.php'; ?>

                    </div>
                        
                </div>

            </div>
        
        </div>
        
        <?php  include dirname(__FILE__) . '/includes/scripts.php'; ?>
 
    </body>

</html> 