<?php
header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
header("strict-transport-security: max-age=15768000");ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    class Core
    {
        private $dbname, $dbusername, $dbpassword;
        public  $dbcon, $config = null;

        public function __construct()
        {
            include dirname(__FILE__) . '/../../classes/startup/config.php'; 

            $this->config     = $config; 
            $this->dbname     = $config['dbname']; 
            $this->dbusername = $config['dbusername']; 
            $this->dbpassword = $config['dbpassword'];
            $this->connect();
        }

        function connect()
        {
            try
            {
                $this->dbcon = new PDO(
                    'mysql:host=localhost'.';dbname='.$this->dbname,$this->dbusername,$this->dbpassword, 
                    array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
                    )
                );
                $this->dbcon->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );
                $this->dbcon->setAttribute(
                    PDO::ATTR_EMULATE_PREPARES, 
                    false
                );
            }
            catch(PDOException $e)
            {
                die($e);
            }
        }   
    }

    class aiInit
    {
        public $_secCon, $_confs, $_user, $_auth, $_mqttUser, $_mqttPass, $_helpers, $_pageDetails = null;

        function __construct(Core $_secCon, $_pageDetails)
        {
            $this->setCookie();

            $this->_secCon      = $_secCon->dbcon;
            $this->_app         = $_secCon->config['JumpWayAppID'];
            $this->_user        = $_secCon->config['JumpWayAppPublic'];
            $this->_auth        = $_secCon->config['JumpWayAppSecret'];
            $this->_mqttUser    = $_secCon->config['JumpWayMqttUser'];
            $this->_mqttPass    = $_secCon->config['JumpWayMqttPass'];
            $this->_pageDetails = $_pageDetails;

            include dirname(__FILE__) . '/../../classes/helpers.php'; 
            $this->_helpers     = new Helpers($this);
            $this->_confs       = $this->getConfigs();

        }

        private function setCookie()
        {

            if(!isSet($_COOKIE['GeniSysAI'])):
                $rander=rand();
                setcookie(
                    "GeniSysAI",
                    $rander,
                    time()+(10*365*24*60*60),
                    '/'
                    ,$_SERVER['SERVER_NAME'],
                    true,
                    true
                );
                $_COOKIE['GeniSysAI'] = $rander;
            endif; 

        }
        
        protected function getConfigs()
        {
            $pdoQuery = $this->_secCon->prepare("
                SELECT version,
                    jumpWayAPI,
                    nluID,
                    nluAddress,
                    tassDevices,
                    phpmyadmin,
                    meta_title,
                    meta_description,
                    domainString 
                FROM a7fh46_settings    
            ");
            $pdoQuery->execute();
            $response=$pdoQuery->fetch(PDO::FETCH_ASSOC);
            $pdoQuery->closeCursor();
            $pdoQuery = null; 
            return $response;
        }
    } 

    $_secCon  = new Core();
    $_GeniSys = new aiInit(
        $_secCon,
        $pageDetails);