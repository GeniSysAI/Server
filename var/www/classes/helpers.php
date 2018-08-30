<?php 

	class Helpers{ 

        function __construct($_GeniSys)
        {
            $this->_GeniSys = $_GeniSys;
        }
				
		public function decrypt($value)
		{
			list($iv, $value) = explode(
				'@@', 
				base64_decode($value));

			return mcrypt_decrypt(
				MCRYPT_RIJNDAEL_256, 
				$this->_GeniSys->_auth, 
				$value, 
				MCRYPT_MODE_CFB, 
				$iv);
		} 
		
		public function encrypt($value)
		{          
			$iv = mcrypt_create_iv(
				mcrypt_get_iv_size(
					MCRYPT_RIJNDAEL_256, 
					MCRYPT_MODE_CFB), 
					MCRYPT_RAND);

			return base64_encode(
				$iv . '@@' .  mcrypt_encrypt(
					MCRYPT_RIJNDAEL_256,
					$this->_GeniSys->_auth, 
					$value,
					MCRYPT_MODE_CFB, 
					$iv));  
		}   
		
		public function decryptString($string)
		{
			return $this->decrypt($string);
		}
		
		public function getUserIP()
		{
			if(array_key_exists(
				'HTTP_X_FORWARDED_FOR', 
				$_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])):

				if (strpos(
					$_SERVER['HTTP_X_FORWARDED_FOR'], 
					',') > 0):

						$addr = explode(
							",",
							$_SERVER['HTTP_X_FORWARDED_FOR']); 
						return trim($addr[0]); 
				else:
					return $_SERVER['HTTP_X_FORWARDED_FOR'];
				endif;
					
			else:
				return $_SERVER['REMOTE_ADDR'];
			endif;
		}
		
		public static function verifyPassword($password, $hash)
		{
			return password_verify(
				$password, 
				$hash);
		}  
		
		public static function createPasswordHash($password)
		{
			return password_hash(
				$password, 
				PASSWORD_DEFAULT);
		}

        public function createHMAC($params=[])
        {
			$parameters = null;
            foreach($params AS $paramsKey => $paramsValue):
                $parameters = $parameters . $paramsValue . ".";
			endforeach;
			return hash_hmac("sha256",
				rtrim(
					$parameters, 
					"."),
				$this->_GeniSys->_auth);
        } 
	}