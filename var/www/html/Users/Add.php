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
                                <i class="fa fa-users fa-fw"></i> Add Location User

                                <div class="pull-right">
                                    <div class="btn-group">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="panel-body">

                                <form role="form" id="form" enctype="multipart/form-data" action="AddTarget.php" target="TargetFrame" method="POST">

                                    <div class="form-group">

                                        <label>Name</label>
                                        <input type="text" id ="name" name="name" class="form-control text-validate" value="">
                                        <p class="help-block">Name of user.</p>

                                    </div>
                                    <div class="form-group">

                                        <label>Email</label>
                                        <input type="text" id ="email" name="email" class="form-control text-validate" value="">
                                        <p class="help-block">Email of user.</p>

                                    </div>
                                    <div class="form-group">

                                        <label>Email</label>
                                        <input type="text" id ="telephone" name="telephone" class="form-control text-validate" value="">
                                        <p class="help-block">Telephone of user.</p>

                                    </div>
                                    <div class="form-group">

                                        <label>Role</label>
                                        <select id="role" name="role" class="form-control text-validate">
                                            <option value="">Choose Role...</option>
                                            <option value="Admin">Admin</option>
                                            <option value="User">User</option>
                                            <option value="Guest">Guest</option>
                                        </select>
                                        <p class="help-block">Role of user.</p>

                                    </div>
                                    <div class="form-group">

                                        <label>Profile Picture/Facial ID</label>
                                        <input type="file"  id="profile" name="profile" class="" />
                                        <p class="help-block">Profile picture for the user, this will also be used to create the known image for the TASS security related features of GeniSys, in future versions the classifiers will pull the encodings from the database on start instead of having a copy of the images on every device that may need them.</p>

                                    </div>
                                    <a class="btn btn-default" id="mediaFormSubmit">Submit</a>

                                </form>
                                <iframe id="TargetFrame" name="TargetFrame"></iframe>

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