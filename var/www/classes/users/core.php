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
            if($this->_GeniSys->_user==filter_input(
                INPUT_POST,'username',
                FILTER_SANITIZE_STRING)):
                
                if($this->_GeniSys->_auth==filter_input(
                    INPUT_POST,'password',
                    FILTER_SANITIZE_STRING)): session_regenerate_id();
            
                    $_SESSION['geniSysApp']=[
                        "Active"=>true,
                        "AppId"=>$this->_GeniSys->_app,
                        "User"=>filter_input(
                            INPUT_POST,'username',
                            FILTER_SANITIZE_STRING)
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
                        ':app' => $this->_GeniSys->_app,
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
                        ':app' => $this->_GeniSys->_app,
                        ':ip' => $this->_GeniSys->_helpers->getUserIP(),
                        ':browser' => $_SERVER['HTTP_USER_AGENT'],
                        ':language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
                        ':time' => time()
                    ]);
                    $pdoQuery->closeCursor();
                    $pdoQuery = null;
                    
                    return  [
                        'Response'=>'FAILED',
                        'ResponseMessage'=>'Access Denied'
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
                    ':app' => $this->_GeniSys->_app,
                    ':ip' => $this->_GeniSys->_helpers->getUserIP(),
                    ':browser' => $_SERVER['HTTP_USER_AGENT'],
                    ':language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
                    ':time' => time()
                ]);
                $pdoQuery->closeCursor();
                $pdoQuery = null;
                
                return  [
                    'Response'=>'FAILED',
                    'ResponseMessage'=>'Access Denied'
                ];
            
            endif;

        }
    }

$_users = new users($_GeniSys);

if(filter_input(
    INPUT_POST,
    'login',
    FILTER_SANITIZE_STRING)):
        die(json_encode($_users->login()));
endif;