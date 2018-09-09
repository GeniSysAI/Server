<?php 

    class iotJumpWay
    {
        private $_GeniSys = null;
        
        function __construct($_GeniSys)
        {
            $this->_GeniSys = $_GeniSys;
        }

        public function updateJumpWay() 
        { 
            if(!filter_input(
                INPUT_POST,
                'jumpwayAPI',
                FILTER_SANITIZE_STRING)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"iotJumpWay API URL is required"
                ];

            endif;

            $pdoQuery = $this->_GeniSys->_secCon->prepare("
                UPDATE a7fh46_settings
                SET jumpwayAPI = :jumpwayAPI 
            ");
            $pdoQuery->execute([
                ':jumpwayAPI' => filter_input(
                                        INPUT_POST,
                                        'jumpwayAPI',
                                        FILTER_SANITIZE_STRING)
            ]);
            $pdoQuery->closeCursor();
            $pdoQuery = null;

            return [
                "Response"=>"OK",
                "ResponseMessage"=>"iotJumpWay settings updated"
            ];
        }
    }

$_iotJumpWay = new iotJumpWay($_GeniSys);

if(filter_input(
    INPUT_POST,
    'ftype',
    FILTER_SANITIZE_STRING)=="updateJumpWay"):
        die(json_encode($_iotJumpWay->updateJumpWay()));
endif; 