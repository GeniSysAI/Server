<?php 

    class NLU
    {
        private $_GeniSys = null;
        
        function __construct($_GeniSys)
        {
            $this->_GeniSys = $_GeniSys;
        }

        public function getDevice($device) 
        {
            $pdoQuery = $this->_GeniSys->_secCon->prepare("
                SELECT * 
                FROM a7fh46_settings
                SET nluID = :nluID 
            ");
            $pdoQuery->execute([
                ':nluID' => filter_input(
                                INPUT_POST,
                                'deviceID',
                                FILTER_SANITIZE_NUMBER_INT)
            ]);
            $pdoQuery->closeCursor();
            $pdoQuery = null;
        }

        public function updateNLUdeviceID()
        {   
            if(!filter_input(
                INPUT_POST,
                'deviceID',
                FILTER_SANITIZE_NUMBER_INT)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"Device ID is required"
                ];

            endif;

            $pdoQuery = $this->_GeniSys->_secCon->prepare("
                UPDATE a7fh46_settings
                SET nluID = :nluID 
            ");
            $pdoQuery->execute([
                ':nluID' => filter_input(
                                INPUT_POST,
                                'deviceID',
                                FILTER_SANITIZE_NUMBER_INT)
            ]);
            $pdoQuery->closeCursor();
            $pdoQuery = null;

            return [
                "Response"=>"OK",
                "Redirect"=>"/NLU/"
            ];
            
        }

        public function updateNLUdevice()
        {   
            if(!filter_input(
                INPUT_POST,
                'deviceID',
                FILTER_SANITIZE_NUMBER_INT)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"Device ID is required"
                ];

            endif;

            if(!filter_input(
                INPUT_POST,
                'nluAddress',
                FILTER_SANITIZE_STRING)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"NLU API address is required"
                ];

            endif;

            $pdoQuery = $this->_GeniSys->_secCon->prepare("
                UPDATE a7fh46_settings
                SET nluID = :nluID,
                    nluAddress = :nluAddress 
            ");
            $pdoQuery->execute([
                ':nluID' => filter_input(
                                INPUT_POST,
                                'deviceID',
                                FILTER_SANITIZE_NUMBER_INT),
                ':nluAddress' => filter_input(
                    INPUT_POST,
                    'nluAddress',
                    FILTER_SANITIZE_STRING)
            ]);
            $pdoQuery->closeCursor();
            $pdoQuery = null;
            
            if(filter_input(
                INPUT_POST,
                'deviceID',
                FILTER_SANITIZE_NUMBER_INT)!=filter_input(
                    INPUT_POST,
                    'deviceIDOld',
                    FILTER_SANITIZE_NUMBER_INT)):

                    return [
                        "Response"=>"OK",
                        "Redirect"=>"/NLU/"
                    ];
            else:

                return [
                    "Response"=>"OK"
                ];

            endif;
            
        }
    }

$_NLU = new NLU($_GeniSys);

if(filter_input(
    INPUT_POST,
    'ftype',
    FILTER_SANITIZE_STRING)=="updateNLUdeviceID"):
        die(json_encode($_NLU->updateNLUdeviceID()));
endif;

if(filter_input(
    INPUT_POST,
    'ftype',
    FILTER_SANITIZE_STRING)=="updateNLUdevice"):
        die(json_encode($_NLU->updateNLUdevice()));
endif;