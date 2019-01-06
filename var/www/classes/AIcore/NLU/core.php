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
                ':nluID' => filter_input(INPUT_POST, 'deviceID', FILTER_SANITIZE_NUMBER_INT)
            ]);
            $pdoQuery->closeCursor();
            $pdoQuery = null;
        }

        public function updateNLUdeviceID()
        {   
            if(!filter_input(INPUT_POST, 'deviceID', FILTER_SANITIZE_NUMBER_INT)):
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
                ':nluID' => $this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'deviceID', FILTER_SANITIZE_NUMBER_INT))
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
            if(!filter_input(INPUT_POST, 'deviceID', FILTER_SANITIZE_NUMBER_INT)):
                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"Device ID is required"
                ];
            endif;

            if(!filter_input(INPUT_POST, 'nluAddress', FILTER_SANITIZE_STRING)):
                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"NLU address is required"
                ];
            endif;

            $pdoQuery = $this->_GeniSys->_secCon->prepare("
                UPDATE a7fh46_settings
                SET nluID = :nluID,
                    nluAddress = :nluAddress 
            ");
            $pdoQuery->execute([
                ':nluID' => $this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'nluID', FILTER_SANITIZE_NUMBER_INT)),
                ':nluAddress' => $this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'nluAddress', FILTER_SANITIZE_STRING))
            ]);
            $pdoQuery->closeCursor();
            $pdoQuery = null; 

            return [
                "Response"=>"OK"
            ];
            
        }
        
        private function apiCall($method, $endpoint, $data=[], $contentType, $noSecurity = true)
        {
            if(!$method):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"Method input is required"
                ];

            endif;
            if(!$endpoint):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"Endpoint input is required"
                ];

            endif;

            $url  = $this->_GeniSys->_helpers->decrypt($this->_GeniSys->_confs["nluAddress"]).$endpoint;
            $curl = curl_init($url);

            switch ($noSecurity):
                case true:
                    $headers = [
                        "Content-Type: ".$contentType,
                        "Content-Length: ".strlen(json_encode($data))
                    ];
                    break;
                default:
                    $secret = $this->_GeniSys->_helpers->decrypt($this->_GeniSys->_confs["JumpWayAppSecret"]);
                    $secretHash = $this->_GeniSys->_helpers->createHMAC([$secret],$secret);

                    $headers = [
                        "Content-Type: ".$contentType,
                        "Content-Length: ".strlen(json_encode($data)),
                        "Authorization: Basic ". base64_encode($this->_GeniSys->_helpers->decrypt($this->_GeniSys->_confs["jumpwayAppID"]).":".$secretHash)
                    ];
                    break;
            endswitch;
            
            switch ($method):
                case "POST":
                    switch ($contentType):
                        case "application/json":
                            curl_setopt($curl, CURLOPT_POST, 1);
                            $data ? curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data)) : "";
                            break;
                        default:
                            curl_setopt($curl, CURLOPT_POST, 1);
                            $data ? curl_setopt($curl, CURLOPT_POSTFIELDS, $data) : "";
                            break;
                    endswitch;
                    break;

                case "PUT":
                    $data ? curl_setopt($curl, CURLOPT_PUT, 1) : "";
                    break;

                default:
                    $url = sprintf("%s?%s", $this->_GeniSys->_confs['nluAddress'].$endpoint, http_build_query($data));
                    break;

            endswitch;

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($curl);
            curl_close($curl);
            return $result;
        }
        
        public function talkToNLU()
        {  
            if(!filter_input(
                INPUT_POST,
                'humanInput',
                FILTER_SANITIZE_STRING)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"Human input is required"
                ];

            endif;

            $response = $this->apiCall(
                "POST", 
                "infer", 
                [
                    "query" => filter_input(INPUT_POST, 'humanInput', FILTER_SANITIZE_STRING)
                ],
                "application/json");
            return $response;
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

if(filter_input(
    INPUT_POST,
    'ftype',
    FILTER_SANITIZE_STRING)=="nluInteract"):
        die($_NLU->talkToNLU());
endif;