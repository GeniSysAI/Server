<?php 

    class iotJumpWayLocation
    {
        private $_GeniSys = null;
        
        function __construct($_GeniSys)
        {
            $this->_GeniSys = $_GeniSys;
        }
        
        private function apiCall($method, $endpoint, $data)
        {
            $curl = curl_init();
            $url  = $this->_GeniSys->_confs["jumpwayAPI"]."/API/REST/".$endpoint;
            switch ($method):

                case "POST":
                    curl_setopt($curl, CURLOPT_POST, 1);
                    $data ? curl_setopt($curl, CURLOPT_POSTFIELDS, $data) : "";
                    break;

                case "PUT":
                    $data ? curl_setopt($curl, CURLOPT_PUT, 1) : "";
                    break;

                default:
                    $url = sprintf("%s?%s", $this->_GeniSys->_confs["jumpwayAPI"]."/API/REST/".$endpoint, http_build_query($data));

            endswitch;

            $headers = [
                'Authorization: Basic '. base64_encode(
                    $this->_GeniSys->_app.":".$this->_GeniSys->_helpers->createHMAC(
                        [$this->_GeniSys->_auth]))
            ];

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($curl);
            curl_close($curl);
            return $result;
        }

        public function getLocation($params=[]) 
        {
            return json_decode($this->apiCall("POST","Locations/0_1_0/getLocation",$params));
        }

        public function getLocationZones($params=[]) 
        {
            return json_decode($this->apiCall("POST","Locations/0_1_0/getLocationZones",$params));
        }
    }


$_iotJumpWayLocation = new iotJumpWayLocation($_GeniSys);