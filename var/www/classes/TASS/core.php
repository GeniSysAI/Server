<?php 

    class TASS
    {
        private $_GeniSys = null;
        
        function __construct($_GeniSys)
        {
            $this->_GeniSys = $_GeniSys;
        }

        public function updateTASSlocalID()
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
                SET tassID = :tassID 
            ");
            $pdoQuery->execute([
                ':tassID' => filter_input(
                                INPUT_POST,
                                'deviceID',
                                FILTER_SANITIZE_NUMBER_INT)
            ]);
            $pdoQuery->closeCursor();
            $pdoQuery = null;

            return [
                "Response"=>"OK",
                "Redirect"=>"/TASS/"
            ];
            
        }

        public function updateTASSlocal()
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
                'tassAddress',
                FILTER_SANITIZE_STRING)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"TASS Stream address is required"
                ];

            endif;

            $pdoQuery = $this->_GeniSys->_secCon->prepare("
                UPDATE a7fh46_settings
                SET tassID = :tassID,
                    tassAddress = :tassAddress 
            ");
            $pdoQuery->execute([
                ':tassID' => filter_input(
                                INPUT_POST,
                                'deviceID',
                                FILTER_SANITIZE_NUMBER_INT),
                ':tassAddress' => filter_input(
                    INPUT_POST,
                    'tassAddress',
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
                        "Redirect"=>"/TASS/"
                    ];
            else:

                return [
                    "Response"=>"OK"
                ];

            endif;
            
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

            $url  = $this->_GeniSys->_confs['nluAddress'].$endpoint;
            $curl = curl_init($url);

            switch ($noSecurity):

                case true:

                    $headers = [
                        "Content-Type: ".$contentType,
                        "Content-Length: ".strlen(json_encode($data))
                    ];
                    break;

                default:

                    $headers = [
                        "Content-Type: ".$contentType,
                        "Content-Length: ".strlen(json_encode($data)),
                        "Authorization: Basic ". base64_encode(
                            $this->_GeniSys->_app.":".$this->_GeniSys->_helpers->createHMAC(
                                [$this->_GeniSys->_auth]))
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
        
        public function talkToTASS()
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
                "infer/1", 
                [
                    "query" => filter_input(INPUT_POST, 'humanInput', FILTER_SANITIZE_STRING)
                ],
                "application/json");
            return $response;
        }
    }

$_TASS = new TASS($_GeniSys); 

if(filter_input(
    INPUT_POST,
    'ftype',
    FILTER_SANITIZE_STRING)=="updateTASSlocalID"):
        die(json_encode($_TASS->updateTASSlocalID()));
endif;

if(filter_input(
    INPUT_POST,
    'ftype',
    FILTER_SANITIZE_STRING)=="updateTASSlocal"):
        die(json_encode($_TASS->updateTASSlocal()));
endif;

if(filter_input(
    INPUT_POST,
    'ftype',
    FILTER_SANITIZE_STRING)=="nluInteract"):
        die($_TASS->talkToTASS());
endif;