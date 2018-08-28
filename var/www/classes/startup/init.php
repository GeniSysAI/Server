<?php
header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
header("strict-transport-security: max-age=15768000");ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    class Connection
    {
        private $dbname, $dbusername, $dbpassword;
        public $dbcon = null;

        public function __construct()
        {
            include dirname(__FILE__) . '/../../classes/startup/config.php';
            $_SESSION['confs'] = $config; 
            $this->dbname      = $config['dbname']; 
            $this->dbusername  = $config['dbusername']; 
            $this->dbpassword  = $config['dbpassword'];
            $this->connect();
        }

        function connect()
        {
            try{
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
            catch(PDOException $e){
                die($e);
            }
        }   
    }

    class aiInit
    {
        protected $_secCon;
        public    $_confs;

        function __construct(Connection $dbcon)
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

            $this->_secCon = $dbcon->dbcon;
            $this->getConfigs();
        } 	
        
        public function decrypt($value, $code)
        {
            list($iv, $data) = explode(
                '@@', 
                base64_decode($value));
            return mcrypt_decrypt(
                MCRYPT_RIJNDAEL_256, 
                $code, 
                $data, 
                MCRYPT_MODE_CFB, 
                $iv);
        }
        
        public function encrypt($value, $code)
        {
            $iv = mcrypt_create_iv(
                mcrypt_get_iv_size(
                    MCRYPT_RIJNDAEL_256, 
                    MCRYPT_MODE_CFB), 
                    MCRYPT_RAND);
                    
            return base64_encode(
                $iv . '@@' .  mcrypt_encrypt(MCRYPT_RIJNDAEL_256,
                $code, 
                $value, 
                MCRYPT_MODE_CFB, 
                $iv)); 
        }
        
        protected function getConfigs()
        {
            $pdoQuery = $this->_secCon->prepare("
                SELECT  meta_title,
                    meta_description,
                    domainString 
                FROM a7fh46_settings    
            ");
            $pdoQuery->execute();
            $this->_confs=$pdoQuery->fetch(PDO::FETCH_ASSOC);
            $pdoQuery->closeCursor();
            $pdoQuery = null; 
        }
    }

    $_secCon  = new Connection();
    $_GeniSys = new aiInit($_secCon);

?>