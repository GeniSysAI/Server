<?php 

    class TASSfoscam
    {
        private $_GeniSys = null;
        
        function __construct($_GeniSys)
        {
            $this->_GeniSys = $_GeniSys;
        }
        
        public function getTASSfoscams()
        {
            $pdoQuery = $this->_GeniSys->_secCon->prepare("
                SELECT id,
                    name  
                FROM tass_foscam_devices     
            ");
            $pdoQuery->execute();
            $foscams=$pdoQuery->fetchAll(PDO::FETCH_ASSOC);
            $pdoQuery->closeCursor();
            $pdoQuery = null; 
            
            if(count($foscams)):

                return [
                    "Response"=>"OK",
                    "ResponseData"=>$foscams
                ];

            else:

                return [
                    "Response"=>"FAILED"
                ];

            endif;
        }
        
        public function getTASSfoscam($device)
        {
            $pdoQuery = $this->_GeniSys->_secCon->prepare("
                SELECT *  
                FROM tass_foscam_devices  
                WHERE id = :id  
            ");
            $pdoQuery->execute([
                ":id" => $device
            ]);
            $foscam=$pdoQuery->fetch(PDO::FETCH_ASSOC);
            $pdoQuery->closeCursor();
            $pdoQuery = null;

            return [
                "Response"=>"OK",
                "ResponseData"=>$foscam
            ];
        }

        public function addTASSfoscam()
        {   
            if(!filter_input(
                INPUT_POST,
                'deviceID',
                FILTER_SANITIZE_STRING)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"Device ID is required"
                ];

            endif;

            if(!filter_input(
                INPUT_POST,
                'RTSPuser',
                FILTER_SANITIZE_STRING)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"RTSPuser is required"
                ];

            endif;

            if(!filter_input(
                INPUT_POST,
                'RTSPpass',
                FILTER_SANITIZE_STRING)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"RTSPpass is required"
                ];

            endif;
            
            if(!filter_input(
                INPUT_POST,
                'RTSPip',
                FILTER_SANITIZE_STRING)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"RTSPip is required"
                ];

            endif;
            
            if(!filter_input(
                INPUT_POST,
                'RTSPport',
                FILTER_SANITIZE_STRING)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"RTSPport is required"
                ];

            endif; 					
                        
            $jumpWayDetails = explode(",", filter_input(INPUT_POST, 'deviceID', FILTER_SANITIZE_STRING));

            $pdoQuery = $this->_GeniSys->_secCon->prepare("
                INSERT INTO tass_foscam_devices (
                    `jid`,
                    `name`,
                    `RTSPuser`,
                    `RTSPpass`,
                    `RTSPip`,
                    `RTSPport`,
                    `RTSPendpoint`,
                    `Stream`,
                    `StreamAccess`,
                    `StreamPort`,
                    `URL`
                )  VALUES (
                    :jid,
                    :name,
                    :RTSPuser,
                    :RTSPpass,
                    :RTSPip,
                    :RTSPport,
                    :RTSPendpoint,
                    :Stream,
                    :StreamAccess,
                    :StreamPort,
                    :URL
                )
            ");
            $pdoQuery->execute([
                ':jid' => abs($jumpWayDetails[0]),
                ':name' => $this->_GeniSys->_helpers->encrypt($jumpWayDetails[1]),
                ':RTSPuser' => $this->_GeniSys->_helpers->encrypt(
                                                                filter_input(
                                                                        INPUT_POST,
                                                                        'RTSPuser',
                                                                        FILTER_SANITIZE_STRING)),
                ':RTSPpass' => $this->_GeniSys->_helpers->encrypt(
                                                                filter_input(
                                                                        INPUT_POST,
                                                                        'RTSPpass',
                                                                        FILTER_SANITIZE_STRING)),
                ':RTSPip' => $this->_GeniSys->_helpers->encrypt(
                                                            filter_input(
                                                                    INPUT_POST,
                                                                    'RTSPip',
                                                                    FILTER_SANITIZE_STRING)),
                ':RTSPport' => $this->_GeniSys->_helpers->encrypt(
                                                                filter_input(
                                                                        INPUT_POST,
                                                                        'RTSPport',
                                                                        FILTER_SANITIZE_STRING)),
                ':RTSPendpoint' => $this->_GeniSys->_helpers->encrypt(
                                                                    filter_input(
                                                                            INPUT_POST,
                                                                            'RTSPendpoint',
                                                                            FILTER_SANITIZE_STRING)),
                ':Stream' => $this->_GeniSys->_helpers->encrypt(
                                                        filter_input(
                                                                INPUT_POST,
                                                                'Stream',
                                                                FILTER_SANITIZE_STRING)),
                ':StreamAccess' => "",
                ':StreamPort' => $this->_GeniSys->_helpers->encrypt(
                                                                filter_input(
                                                                        INPUT_POST,
                                                                        'StreamPort',
                                                                        FILTER_SANITIZE_STRING)),
                ':URL' => ""
            ]);
            $pdoQuery->closeCursor();
            $pdoQuery = null;

            unset($_POST);

            return [
                "Response"=>"OK",
                "Redirect"=>"/TASS/Foscam"
            ];
            
        }

        public function updateTASSfoscam()
        {   
            if(!filter_input(
                INPUT_POST,
                'tassID',
                FILTER_SANITIZE_STRING)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"Device ID is required"
                ];

            endif;

            if(!filter_input(
                INPUT_POST,
                'RTSPuser',
                FILTER_SANITIZE_STRING)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"RTSPuser is required"
                ];

            endif;

            if(!filter_input(
                INPUT_POST,
                'RTSPpass',
                FILTER_SANITIZE_STRING)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"RTSPpass is required"
                ];

            endif;
            
            if(!filter_input(
                INPUT_POST,
                'RTSPip',
                FILTER_SANITIZE_STRING)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"RTSPip is required"
                ];

            endif;
            
            if(!filter_input(
                INPUT_POST,
                'RTSPport',
                FILTER_SANITIZE_STRING)):

                return [
                    "Response"=>"FAILED",
                    "ResponseMessage"=>"RTSPport is required"
                ];

            endif; 					
                        
            $jumpWayDetails = explode(",", filter_input(INPUT_POST, 'deviceID', FILTER_SANITIZE_STRING));

            $pdoQuery = $this->_GeniSys->_secCon->prepare("
                UPDATE tass_foscam_devices
                SET jid = :jid,
                    name = :name,
                    RTSPuser = :RTSPuser,
                    RTSPpass = :RTSPpass,
                    RTSPip = :RTSPip,
                    RTSPport = :RTSPport,
                    RTSPendpoint = :RTSPendpoint,
                    Stream = :Stream,
                    StreamAccess = :StreamAccess,
                    StreamPort = :StreamPort,
                    URL = :URL
                WHERE id = :id 
            ");
            $pdoQuery->execute([
                ':jid' => abs($jumpWayDetails[0]),
                ':name' => $this->_GeniSys->_helpers->encrypt($jumpWayDetails[1]),
                ':RTSPuser' => $this->_GeniSys->_helpers->encrypt(
                                                                filter_input(
                                                                        INPUT_POST,
                                                                        'RTSPuser',
                                                                        FILTER_SANITIZE_STRING)),
                ':RTSPpass' => $this->_GeniSys->_helpers->encrypt(
                                                                filter_input(
                                                                        INPUT_POST,
                                                                        'RTSPpass',
                                                                        FILTER_SANITIZE_STRING)),
                ':RTSPip' => $this->_GeniSys->_helpers->encrypt(
                                                            filter_input(
                                                                    INPUT_POST,
                                                                    'RTSPip',
                                                                    FILTER_SANITIZE_STRING)),
                ':RTSPport' => $this->_GeniSys->_helpers->encrypt(
                                                                filter_input(
                                                                        INPUT_POST,
                                                                        'RTSPport',
                                                                        FILTER_SANITIZE_STRING)),
                ':RTSPendpoint' => $this->_GeniSys->_helpers->encrypt(
                                                                    filter_input(
                                                                            INPUT_POST,
                                                                            'RTSPendpoint',
                                                                            FILTER_SANITIZE_STRING)),
                ':Stream' => $this->_GeniSys->_helpers->encrypt(
                                                        filter_input(
                                                                INPUT_POST,
                                                                'Stream',
                                                                FILTER_SANITIZE_STRING)),
                ':StreamAccess' => "",
                ':StreamPort' => $this->_GeniSys->_helpers->encrypt(
                                                                filter_input(
                                                                        INPUT_POST,
                                                                        'StreamPort',
                                                                        FILTER_SANITIZE_STRING)),
                ':URL' => "",
                ':id' =>  filter_input(
                                    INPUT_POST,
                                    'tassID',
                                    FILTER_SANITIZE_STRING)
            ]);
            $pdoQuery->closeCursor();
            $pdoQuery = null;

            return [
                "Response"=>"OK",
                "Redirect"=>"/TASS/FoscamEdit.php?device=".abs($jumpWayDetails[0])
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
    }

$_TASSfoscam = new TASSfoscam($_GeniSys);

if(filter_input(
    INPUT_POST,
    'ftype',
    FILTER_SANITIZE_STRING)=="addTASSfoscam"):
        die(json_encode($_TASSfoscam->addTASSfoscam()));
endif;

if(filter_input(
    INPUT_POST,
    'ftype',
    FILTER_SANITIZE_STRING)=="updateTASSfoscam"):
        die(json_encode($_TASSfoscam->updateTASSfoscam()));
endif;