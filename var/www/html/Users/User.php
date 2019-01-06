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
$user=$_users->getUser([
    "User"=>filter_input(INPUT_GET,'user',FILTER_SANITIZE_NUMBER_INT)
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
                        <h1 class="page-header">USER</h1>
                    </div>
                </div>
                
                <div class="row"> 

                    <div class="col-lg-8">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-users fa-fw"></i> Manage Location User

                                <div class="pull-right">
                                    <div class="btn-group">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="panel-body">

                                <form role="form" id="form">

                                    <div class="form-group">

                                        <label>Name</label>
                                        <input type="text" id="name" name="name" class="form-control text-validate" value="<?=$_GeniSys->_helpers->decrypt($user["ResponseData"]["name"]); ?>">
                                        <p class="help-block">Name of user.</p>

                                    </div>
                                    <div class="form-group">

                                        <label>Email</label>
                                        <input type="text" id ="email" name="email" class="form-control text-validate" value="<?=$_GeniSys->_helpers->decrypt($user["ResponseData"]["email"]); ?>">
                                        <p class="help-block">Email of user.</p>

                                    </div>
                                    <div class="form-group">

                                        <label>Telephone</label>
                                        <input type="text" id ="telephone" name="telephone" class="form-control text-validate" value="<?=$_GeniSys->_helpers->decrypt($user["ResponseData"]["phone"]); ?>">
                                        <p class="help-block">Telephone of user.</p>

                                    </div>
                                    <div class="form-group">

                                        <label>Role</label>
                                        <select id="role" name="role" class="form-control text-validate">
                                            <option value="Admin" <?=$user["ResponseData"]["role"]=="Admin" ? "selected" : ""; ?>>Admin</option>
                                            <option value="User" <?=$user["ResponseData"]["role"]=="User" ? "selected" : ""; ?>>User</option>
                                            <option value="Guest" <?=$user["ResponseData"]["role"]=="Guest" ? "selected" : ""; ?>>Guest</option>
                                        </select>
                                        <p class="help-block">Role of user.</p>

                                    </div>

                                    <input type="hidden" id="id" name="id" value="<?=$user["ResponseData"]["id"]; ?>" /> 
                                    <input type="hidden" id="ftype" name="ftype" value="updateUser" /> 
                                    <a class="btn btn-default" id="formSubmit">Submit</a>

                                </form>

                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="col-lg-4">

                        <?php  include dirname(__FILE__) . '/../Users/includes/User.php'; ?>

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