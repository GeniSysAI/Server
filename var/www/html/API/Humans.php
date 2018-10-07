<?php session_start();

$pageDetails = [
    "PageID" => "API"
];

include dirname(__FILE__) . '/../../classes/startup/init.php';

class API
{
    private $_GeniSys      = null;
    public $_requestMethod = null;
    public $_requestCall   = null;
    public $_requestData   = null;
        
    function __construct($_GeniSys) 
    { 
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header('Content-Type: application/json');
        header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");

        $this->_GeniSys = $_GeniSys;        
            
        $this->getRequestMethod();
        $this->getRequestData();

        $this->_requestCall = $_POST["Call"];
        $this->_requestData = $_POST["Data"];
    }
		
    protected function writeFile($file,$data)
    {
        $fps = fopen($file, 'w');
        fwrite($fps, print_r($data, TRUE));
        fclose($fps);
    }

    private function getRequestMethod()
    {	
        $this->_requestMethod = $_SERVER['REQUEST_METHOD'];
        
        if ($this->_requestMethod == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)):
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE'):
                $this->_requestMethod = 'DELETE';
            elseif($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT'):
                $this->_requestMethod = 'PUT';
            else:
                $this->_requestMethod = null;
            endif;
        endif;
    }

    private function getRequestData()
    { 
        switch($this->_requestMethod):
            case 'DELETE':
            case 'POST':
                if($_SERVER['CONTENT_TYPE']=='application/json'):
                    $_POST = json_decode(file_get_contents('php://input'), true);
                else:
                    $_POST = json_decode(file_get_contents('php://input'), true);
                endif;
                break;
            case 'GET':
                $this->_request = $this->cleanData($_GET);
                break;
            case 'PUT':
                $this->_request = $this->cleanData($_GET);
                $this->file = file_get_contents("php://input");
                break;
            default:
                $this->_request = null;
                break;
        endswitch;
    }

    private function cleanData($data) 
    { 
        $clean_input = Array();
        if (is_array($data)):
            foreach ($data as $k => $v):
                $clean_input[$k] = $this->cleanData($v);
            endforeach;
        else:
            $clean_input = trim(strip_tags($data));
        endif;
        return $clean_input;
    }
		
    private function getAuthHeaders()
    { 
        $authParts=[
            $_SERVER["PHP_AUTH_USER"],
            $_SERVER["PHP_AUTH_PW"]
        ];
        $this->writeFile("auth.txt",$authParts);
        return $authParts;
    }

    private function _requestStatus($code) 
    { 
        $status = [
            200 => 'OK',
            401 => 'Not Authorized',
            404 => 'Not Found',   
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        ]; 
        
        return ($status[$code])?$status[$code]:$status[500]; 
    }

    private function returnResponse($data, $status = 200) {
        
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        return json_encode($data);
        
    }

    public function createHMAC($params=[], $key)
    {
        $parameters = null;
        foreach($params AS $paramsKey => $paramsValue):
            $parameters = $parameters . $paramsValue . ".";
        endforeach;
        return hash_hmac("sha256",
            rtrim(
                $parameters, 
                "."),
                $key);
    }
        
    public function processAPIcall() 
    {
        $authHeaders=$this->getAuthHeaders();
			
        if (!$authHeaders[0] || !$authHeaders[1]):
            return $this->returnResponse(["Response"=>"Failed", "ResponseMessage"=>"No Authorisation Provided"], 401);
        endif;

        $secretHash  = $this->createHMAC([$this->_GeniSys->_pSk],$this->_GeniSys->_pSk);

        if(!hash_equals($authHeaders[1], $secretHash)):
            return $this->returnResponse(["Response"=>"Failed", "ResponseMessage"=>"Not Authorised"], 401);
        endif;

        if($this->_requestMethod==null):
            return $this->returnResponse(["Response"=>"Failed", "ResponseMessage"=>"No valid method"], 401);
        endif;

        if($this->_requestData==null):
            return $this->returnResponse(["Response"=>"Failed", "ResponseMessage"=>"No valid data"], 401);
        endif;

        if($this->_requestCall==null):
            return $this->returnResponse(["Response"=>"Failed", "ResponseMessage"=>"No valid call"], 404);
        endif;
			
        if ((int)method_exists($this, $this->_requestCall) > 0):
            return $this->returnResponse($this->{$this->_requestCall}($this->_requestData));
        endif;

        return $this->returnResponse(["Response"=>"Failed", "ResponseMessage"=>"No valid call"], 404);
    }
        
    private function getHumanID($data) 
    {
        $pdoQuery = $this->_GeniSys->_secCon->prepare("
            SELECT id 
            FROM a7fh46_users
            WHERE name = :name 
        ");
        $pdoQuery->execute([
            ':name' => $data["name"]
        ]);
        $dataR=$pdoQuery->fetch(PDO::FETCH_ASSOC);
        $pdoQuery->closeCursor();
        $pdoQuery = null;

        if($dataR["id"]):
            return [
                "Response"=>"OK",
                "ResponseMessage"=>"getHuman OK",
                "ResponseData"=>$dataR['id']
            ];
        else:
            return [
                "Response"=>"Failed",
                "ResponseMessage"=>"getHuman Failed"
            ];
        endif;
    }
        
    private function trackHuman($data) 
    {
        $pdoQuery = $this->_GeniSys->_secCon->prepare("
            INSERT INTO a7fh46_users_logs 
                (uid, lid, fid, zid, did, timeSeen) 
            VALUES 
                (:uid, :lid, :fid, :zid, :did, :timeSeen)
            ON DUPLICATE KEY UPDATE
                timeSeen = IF(VALUES(timeSeen) > (NOW() - INTERVAL 2 MINUTE), VALUES(timeSeen), :timeSeenU)
        ");
        $pdoQuery->execute([
            ':uid' => $data["uid"],
            ':lid' => $data["lid"],
            ':fid' => $data["fid"],
            ':zid' => $data["zid"],
            ':did' => $data["did"],
            ':timeSeen' => date("Y-m-d H:i:s"),
            ':timeSeenU' => date("Y-m-d H:i:s")
        ]);
		
        $pdoQuery = $this->_GeniSys->_secCon->prepare("
            UPDATE a7fh46_users 
            SET floor=:floor,
                zone=:zone,
                lastSeen=:lastSeen 
            WHERE id=:id 
        ");
        $pdoQuery->execute([
            ':floor'=>$data["fid"],
            ':zone'=>$data["zid"],
            ':lastSeen'=>date("Y-m-d H:i:s"),
            ':id'=>$data["uid"]
        ]);
        
        return [
            "Response"=>"OK",
            "ResponseMessage"=>"trackHuman OK"
        ];
    }
}

$_Humans= new API($_GeniSys);
echo $_Humans->processAPIcall();
?>