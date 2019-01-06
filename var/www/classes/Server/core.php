<?php 

    class Server
    {
        private $_GeniSys = null;
        
        function __construct($_GeniSys)
        {
            $this->_GeniSys = $_GeniSys;
        }

        public function updateServer() 
        {   
            if(!filter_input(
                INPUT_POST,
                'meta_title',
                FILTER_SANITIZE_STRING)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"Server name is required"
                ];

            endif;

            if(!filter_input(
                INPUT_POST,
                'domainString',
                FILTER_SANITIZE_STRING)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"Server URL is required"
                ];

            endif;

            if(!filter_input(
                INPUT_POST,
                'phpmyadmin',
                FILTER_SANITIZE_STRING)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"phpmyadmin endpoint is required"
                ];

            endif;

            $pdoQuery = $this->_GeniSys->_secCon->prepare("
                UPDATE a7fh46_settings
                SET meta_title = :meta_title,
                    meta_description = :meta_description,
                    domainString = :domainString,
                    phpmyadmin = :phpmyadmin 
            ");
            $pdoQuery->execute([
                ':meta_title' => $this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'meta_title', FILTER_SANITIZE_STRING)),
                ':meta_description' => $this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'meta_description', FILTER_SANITIZE_STRING)),
                ':domainString' => $this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'domainString', FILTER_SANITIZE_STRING)),
                ':phpmyadmin' => $this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'phpmyadmin', FILTER_SANITIZE_STRING))
            ]);
            $pdoQuery->closeCursor();
            $pdoQuery = null;

            return [
                "Response"=>"OK",
                "ResponseMessage"=>"Server settings updated"
            ];
        }
    }

$_Server = new Server($_GeniSys);

if(filter_input(
    INPUT_POST,
    'ftype',
    FILTER_SANITIZE_STRING)=="updateServer"):
        die(json_encode($_Server->updateServer()));
endif;