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
            if(!filter_input(INPUT_POST, 'jumpwayAPI', FILTER_SANITIZE_STRING)):
                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"iotJumpWay API URL is required"
                ];
            endif; 

            if(!filter_input(INPUT_POST, 'jumpwayLocation', FILTER_SANITIZE_STRING)):
                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"iotJumpWay location is required"
                ];
            endif; 

            if(!filter_input(INPUT_POST, 'jumpwayZone', FILTER_SANITIZE_STRING)):
                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"iotJumpWay zone is required"
                ];
            endif; 

            if(!filter_input(INPUT_POST, 'jumpwayDevice', FILTER_SANITIZE_STRING)):
                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"iotJumpWay device is required"
                ];
            endif; 

            if(!filter_input(INPUT_POST, 'jumpwayAppID', FILTER_SANITIZE_STRING)):
                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"iotJumpWay application ID is required"
                ];
            endif; 

            if(!filter_input(INPUT_POST, 'JumpWayAppPublic', FILTER_SANITIZE_STRING)):
                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"iotJumpWay public API key is required"
                ];
            endif; 

            if(!filter_input(INPUT_POST, 'JumpWayAppSecret', FILTER_SANITIZE_STRING)):
                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"iotJumpWay private API key is required"
                ];
            endif; 

            if(!filter_input(INPUT_POST, 'JumpWayMqttUser', FILTER_SANITIZE_STRING)):
                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"iotJumpWay MQTT user is required"
                ];
            endif;

            $pdoQuery = $this->_GeniSys->_secCon->prepare("
                UPDATE a7fh46_settings
                SET jumpwayAPI = :jumpwayAPI,
                    jumpwayLocation = :jumpwayLocation,
                    jumpwayZone = :jumpwayZone,
                    jumpwayDevice =:jumpwayDevice,
                    jumpwayAppID =:jumpwayAppID,
                    JumpWayAppPublic =:JumpWayAppPublic,
                    JumpWayAppSecret =:JumpWayAppSecret,
                    JumpWayMqttUser =:JumpWayMqttUser,
                    JumpWayMqttPass =:JumpWayMqttPass

            ");
            $pdoQuery->execute([
                ':jumpwayAPI' => $this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'jumpwayAPI', FILTER_SANITIZE_STRING)),
                ':jumpwayLocation' => $this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'jumpwayLocation', FILTER_SANITIZE_STRING)),
                ':jumpwayZone' => $this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'jumpwayZone', FILTER_SANITIZE_STRING)),
                ':jumpwayDevice' => $this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'jumpwayDevice', FILTER_SANITIZE_STRING)),
                ':jumpwayAppID' => $this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'jumpwayAppID', FILTER_SANITIZE_STRING)),
                ':JumpWayAppPublic' => $this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'JumpWayAppPublic', FILTER_SANITIZE_STRING)),
                ':JumpWayAppSecret' => $this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'JumpWayAppSecret', FILTER_SANITIZE_STRING)),
                ':JumpWayMqttUser' => $this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'JumpWayMqttUser', FILTER_SANITIZE_STRING)),
                ':JumpWayMqttPass' => $this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'JumpWayMqttPass', FILTER_SANITIZE_STRING))
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