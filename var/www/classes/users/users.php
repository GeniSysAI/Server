<?php

    class users
    {
        protected $_secCon;

        function __construct(Connection $dbcon)
        {
            $this->_secCon = $dbcon->dbcon;
        }

        public function login() 
        {
            if($_SESSION['confs']['JumpWayMqttUser']!=filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING)):

				return  [
					'Response'=>'OK',
					'Message'=>'Welcome'
                ];
            
            else:
                
                return  [
                    'Response'=>'FAILED',
                    'Message'=>'Access Denied'
                ];
            
            endif;

        }
    }

$_users  = new users($_secCon);

if(filter_input(
    INPUT_POST,
    'login',
    FILTER_SANITIZE_STRING)):
        die(json_encode($_POST));
endif;

?>