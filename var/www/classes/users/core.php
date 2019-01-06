<?php 

    class users
    {
        private $_GeniSys = null;
        
        function __construct($_GeniSys)
        {
            $this->_GeniSys = $_GeniSys;
        }

        public function checkSession()
        { 
            if(empty($_SESSION['geniSysApp']['Active']) && $this->_GeniSys->_pageDetails["PageID"]!="Login"):
                die(header("Location: /"));
            elseif(isset($_SESSION['geniSysApp']['Active']) && $this->_GeniSys->_pageDetails["PageID"]=="Login"):
                die(header("Location: /dashboard"));
            endif;
        }

        public function login() 
        {
            if($this->_GeniSys->_helpers->decrypt($this->_GeniSys->_confs["JumpWayAppPublic"])==filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING)):
                
                if($this->_GeniSys->_helpers->decrypt($this->_GeniSys->_confs["JumpWayAppSecret"])): session_regenerate_id();
            
                    $_SESSION['geniSysApp']=[
                        "Active"=>true,
                        "AppId"=>$this->_GeniSys->_helpers->decrypt($this->_GeniSys->_confs["jumpwayAppID"]),
                        "User"=>filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING)
                    ];
                    
                    $pdoQuery = $this->_GeniSys->_secCon->prepare("
                        INSERT INTO a7fh46_logins (
                            `app`,
                            `ip`,
                            `browser`,
                            `language`,
                            `time`
                        )  VALUES (
                            :app,
                            :ip,
                            :browser,
                            :language,
                            :time
                        )
                    ");
                    $pdoQuery->execute([
                        ':app' => $this->_GeniSys->_helpers->decrypt($this->_GeniSys->_confs["jumpwayAppID"]),
                        ':ip' => $this->_GeniSys->_helpers->getUserIP(),
                        ':browser' => $_SERVER['HTTP_USER_AGENT'],
                        ':language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
                        ':time' => time()
                    ]);
                    $pdoQuery->closeCursor();
                    $pdoQuery = null;

                    return  [
                        'Response'=>'OK',
                        'ResponseMessage'=>'Welcome',
                        'Redirect'=>'/dashboard'
                    ];
            
                else:
                    
                    $pdoQuery = $this->_GeniSys->_secCon->prepare("
                        INSERT INTO a7fh46_loginsF (
                            `app`,
                            `ip`,
                            `browser`,
                            `language`,
                            `time`
                        )  VALUES (
                            :app,
                            :ip,
                            :browser,
                            :language,
                            :time
                        )
                    ");
                    $pdoQuery->execute([
                        ':app' => $this->_GeniSys->_helpers->decrypt($this->_GeniSys->_confs["jumpwayAppID"]),
                        ':ip' => $this->_GeniSys->_helpers->getUserIP(),
                        ':browser' => $_SERVER['HTTP_USER_AGENT'],
                        ':language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
                        ':time' => time()
                    ]);
                    $pdoQuery->closeCursor();
                    $pdoQuery = null;
                    
                    return  [
                        'Response'=>'FAILED',
                        'ResponseMessage'=>'Access Denied1'
                    ];
                
                endif;
            
            else:
                
                $pdoQuery = $this->_GeniSys->_secCon->prepare("
                    INSERT INTO a7fh46_loginsF (
                        `app`,
                        `ip`,
                        `browser`,
                        `language`,
                        `time`
                    )  VALUES (
                        :app,
                        :ip,
                        :browser,
                        :language,
                        :time
                    )
                ");
                $pdoQuery->execute([
                    ':app' => $this->_GeniSys->_helpers->decrypt($this->_GeniSys->_confs["jumpwayAppID"]), 
                    ':ip' => $this->_GeniSys->_helpers->getUserIP(),
                    ':browser' => $_SERVER['HTTP_USER_AGENT'],
                    ':language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
                    ':time' => time()
                ]);
                $pdoQuery->closeCursor();
                $pdoQuery = null;
                
                return  [
                    'Response'=>'FAILED',
                    'ResponseMessage'=>'Access Denied2'
                ];
            
            endif;

        }

        public function getUsers($params=[])
        {
            $callParams = [];
            if($params["Type"] == "Users"):
                $where="Where role = :role";
                $callParams[":role"] = "Users";
            elseif($params["Type"] == "Admins"):
                $where="Where role = :role";
                $callParams[":role"] = "Admin";
            elseif($params["Type"] == "Guests"):
                $where="Where role = :role";
                $callParams[":role"] = "Guest";
            elseif($params["Type"] == "Unknowns"):
                $where="Where role = :role";
                $callParams[":role"] = "Unknown"; 
            endif;

            $pdoQuery = $this->_GeniSys->_secCon->prepare("
                SELECT * 
                FROM a7fh46_users 
                $where 
            ");
            $pdoQuery->execute($callParams);
            $response=$pdoQuery->fetchAll(PDO::FETCH_ASSOC);
            $pdoQuery->closeCursor();
            $pdoQuery = null; 

            if(count($response)):
                return  [
                    'Response'=>'OK',
                    'ResponseMessage'=>'Request completed',
                    'ResponseData'=> $response
                ];
            else:
                return  [
                    'Response'=>'FAILED',
                    'ResponseMessage'=>'Request failed'
                ];
            endif;
        }

        public function getUser($params=[])
        {

            $pdoQuery = $this->_GeniSys->_secCon->prepare("
                SELECT * 
                FROM a7fh46_users 
                WHERE id = :id  
            ");
            $pdoQuery->execute([
                ":id"=>$params['User']
            ]);
            $response=$pdoQuery->fetch(PDO::FETCH_ASSOC);
            $pdoQuery->closeCursor();
            $pdoQuery = null; 

            if($response["id"]):
                return  [
                    'Response'=>'OK',
                    'ResponseMessage'=>'Request completed',
                    'ResponseData'=> $response
                ];
            else:
                return  [
                    'Response'=>'FAILED',
                    'ResponseMessage'=>'Request failed'
                ];
            endif;
        }

        public function updateUser()
        {

            $pdoQuery = $this->_GeniSys->_secCon->prepare("
                UPDATE a7fh46_users 
                SET name = :name,
                    role = :role,
                    email = :email,
                    phone = :phone,
                    lastUpdated = :lastUpdated 
                WHERE id = :id  
            ");
            $pdoQuery->execute([
                ":name"=>$this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING)),
                ":role"=>filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING),
                ":email"=>$this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)),
                ":phone"=>$this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING)),
                ":lastUpdated"=>time(),
                ":id"=>filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT)
            ]);
            $pdoQuery->closeCursor();
            $pdoQuery = null; 

            return  [
                'Response'=>'OK',
                'ResponseMessage'=>'Request completed'
            ];
        }

        public function addUser()
        {
            if(isset($_FILES['profile']['name'])):
                
                $maxSize = 1000000;
                $validExtensions = ['jpeg','jpg','png','gif'];
                $validTypes = ['image/jpeg', 'image/jpg', 'image/png','image/gif'];

                $filename =  time()."-".$_FILES['profile']['name'];
                $file =  "/var/www/html/Users/profiles/".$filename;
                if (move_uploaded_file($_FILES['profile']['tmp_name'], $file)):
                    //return json_decode($this->encodeUserPhoto("POST", "Encode", ['profile' => base64_encode(fread(fopen($file, "r"), filesize($file)))]));
                    $pdoQuery = $this->_GeniSys->_secCon->prepare("
                        INSERT INTO a7fh46_users (
                            `name`,
                            `role`,
                            `email`,
                            `phone`,
                            `image`,
                            `lastUpdated`
                        )  VALUES (
                            :name,
                            :role,
                            :email,
                            :phone,
                            :image,
                            :lastUpdated
                        )
                    ");
                    $pdoQuery->execute([
                        ":name"=>$this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING)),
                        ":role"=>filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING),
                        ":email"=>$this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)),
                        ":phone"=>$this->_GeniSys->_helpers->encrypt(filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING)),
                        ":image"=>$filename,
                        ':lastUpdated' => time()
                    ]);
                    $pdoQuery->closeCursor();
                    $pdoQuery = null;
                    return  [
                        'Response'=>'OK',
                        'ResponseMessage'=>'Request completed'
                    ];
                else:
                    return  [
                        'Response'=>'FAILED',
                        'ResponseMessage'=>'Request did not complete'
                    ];
                endif;
            endif;
        }
            
        private function encodeUserPhoto($method, $endpoint, $data)
        {
            $curl = curl_init();
            $url  = $this->_GeniSys->_helpers->decrypt($this->_GeniSys->_confs["tassAddress"]).$endpoint;

            $secret = $this->_GeniSys->_helpers->decrypt($this->_GeniSys->_confs["JumpWayAppSecret"]);
            $secretHash = $this->_GeniSys->_helpers->createHMAC([$secret],$secret);
            
            $headers = [
                'Content-Type: multipart/form-data;',
                'Authorization: Basic '. base64_encode($this->_GeniSys->_helpers->decrypt($this->_GeniSys->_confs["jumpwayAppID"]).":".$secretHash)
            ];

            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

            $result = curl_exec($curl);
            curl_close($curl);
            return $result;
        }
    }

$_users = new users($_GeniSys);

if(filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING)):
    die(json_encode($_users->login()));
endif;

if(filter_input(INPUT_POST, 'ftype', FILTER_SANITIZE_STRING)=="updateUser"):
    die(json_encode($_users->updateUser()));
endif; 