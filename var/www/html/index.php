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

        <div class="container">

            <div class="row">

                <div class="col-md-4 col-md-offset-4">

                    <div class="login-panel panel panel-default">

                        <div class="panel-heading">

                            <h3 class="panel-title">Sign In To GeniSys</h3> <div id="clock"></div>

                        </div>
                        <div class="panel-body">

                            <form role="form">

                                <fieldset>

                                    <div class="form-group">
                                        <input id="username" type="name" class="form-control username-validate" name="username" placeholder="App Public Key" value="" >
                                    </div>
                                    <div class="form-group">
                                        <input id="password" type="password" class="form-control password-validate" name="password" placeholder="App Private Key" value="" autocomplete="false">
                                        <input id="login" type="hidden" class="" name="login" value="1">
                                    </div>
                                    <a id="formSubmit" class="btn btn-lg btn-success btn-block">Login</a>

                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php  include dirname(__FILE__) . '/includes/scripts.php'; ?>
 
    </body>

</html> 