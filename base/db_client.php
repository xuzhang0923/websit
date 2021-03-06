 <?php
    class DB_Client{
        private $db;
        
        function __construct(){
            require_once $_SERVER['DOCUMENT_ROOT'] . '/flower_shop/base/db_connect.php';
			require_once $_SERVER['DOCUMENT_ROOT'] . '/flower_shop/base/FileLock.php';
			
            $this->db = new DB_Connect();
            $this->db->connect();
        }
        
        function createAccount($pUsername,$pPassword,$pTele)
        {
            if(!empty($pUsername) && !empty($pPassword) && !empty($pTele))
            {
                $eUser = mysql_real_escape_string($pUsername);
                $ePass = mysql_real_escape_string($pPassword);
                $eTele = mysql_real_escape_string($pTele);
                
                $teleLen = strlen($eTele);
                if($teleLen != 11)
                {
                    $_SESSION['ERROR'] = "TELEPHONE NUMBER IS INVALID";
                    return false;
                }
                
                $sql = "SELECT phone FROM users WHERE phone = '". $eTele ."' LIMIT 1 ";
                $query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
                        
                if(mysql_num_rows($query) > 0)
                {
                    $_SESSION['ERROR'] = "This user has been reigstered";
                    return false;
                }
                
                $sql = "INSERT INTO `users` (`name`,`password`,`phone`) VALUES ('". $eUser ."','". $ePass ."','". $eTele ."')";
                $query = mysql_query($sql) or trigger_error("Query Failed: " .mysql_error());
                
                
                return true;
                
            }
            else
            {
                //todo: redirect a page that form is invalid
                echo 'Seems some thing wrong with the submitted form';
            }
        }
        
        function loggedIn()
        {
            if(isset($_SESSION['loggedin']) && isset($_SESSION['phone']))
            {
                return true;
            }
            
            return false;
        }
        
        function logoutUser()
        {
            unset($_SESSION['phone']);
            unset($_SESSION['loggedin']);
            
            return true;
        }
        
        function validateUser($telephone,$password)
        {
            $eTele = mysql_real_escape_string($telephone);
            $ePass = mysql_real_escape_string($password);
            
            $sql = "SELECT name,phone FROM users WHERE phone = '". $eTele ."' AND password = '". $ePass ."'";
            
            $query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
            
            if(mysql_num_rows($query) == 1)
            {
                $row = mysql_fetch_assoc($query);
                
                $_SESSION['phone'] = $row['phone'];
                $_SESSION['loggedin'] = true;
                
                return true;
            }
            
            return false;
        }
		
		function publishInformation($phone,$day,$time,$fromto,$totalseat,$details)
		{
			$mPhone = mysql_real_escape_string($phone);
			$mDay = mysql_real_escape_string($day);
			$mTime = mysql_real_escape_string($time);
			$mFromTo = mysql_real_escape_string($fromto);
			$mTotalSeat = mysql_real_escape_string($totalseat);
			$mDetails = mysql_real_escape_string($details);
			
			//get the date
			$mDay = date("Y-m-d",strtotime("+". $mDay ."day" ));

			$publishedInformation =
 "SELECT phone,day,fromto FROM cars WHERE phone = '" . $mPhone ."' AND day = '". $mDay . "'  and fromto = '". $fromto . "'";
			$publishedInforQuery = mysql_query($publishedInformation) or trigger_error("Query Failed:". mysql_error());
			
			if(mysql_num_rows($publishedInforQuery) > 0)
			{
				return false;
				$_SESSION['error'] = "there is such information has been published, please remove it first.";
			}
			else {
				$insertSql = "INSERT INTO `cars` (`phone`,`day`,`time`,`fromto`,`totalseat`,`details`) VALUES ('" . $mPhone ."','" . $mDay . "','". $mTime . "','" . $mFromTo . "','" . $mTotalSeat . "','" . $mDetails . "')"; 
				$insertResult = mysql_query($insertSql) or trigger_error("Insert Failed :" . mysql_error());
				
				return true;	
			}
		}

		function retrieverInformation($day,$fromto)
		{
			$mDay = mysql_real_escape_string($day);
			$mFromto = mysql_real_escape_string($fromto);
			$retrieveString = "SELECT phone,day,time,fromto,totalseat,details FROM cars WHERE day='" . $mDay . "' and fromto='" .$fromto. "'";
			
			$retrieveResult = mysql_query($retrieveString) or trigger_error("Query Failed:" . mysql_error());
			
			return $retrieveResult;
		}
        
		function subscribeCar($subscriberphone,$publishphone,$day,$fromto)
		{	
			$mSubPhone = mysql_real_escape_string($subscriberphone);
			$mPubPhone = mysql_real_escape_string($publishphone);
			$mDay = mysql_real_escape_string($day);	
			$mFromto = mysql_real_escape_string($fromto);
			
			 $lock = new File_Lock($_SERVER['DOCUMENT_ROOT'] . '/flower_shop/base/' . 'addlock.lock');
			 $lock->writeLock();
			 
			 $retreiveString = "SELECT phone,day,fromto,totalseat FROM cars WHERE day='" . $mDay . "' and fromto='" . $mFromto . "' and phone='" . $mPubPhone . "'";
			 $retrieverResult = mysql_query($retreiveString) or trigger_error("Query Failed:" . mysql_error());
			 
			 if(mysql_num_rows($retrieverResult) != 1)
			 {
			 	$_SESSION['error'] = "no subscribe car information";
			 	return false;
			 }
			 
			 if($retrieverResult)
			 {
			 	$resultArray = mysql_fetch_array($retrieverResult);
			 	if($resultArray['totalseat']<=0)
			 	{
			 		$_SESSION['error'] = "there is no enought seat";
					return false;
			 	}
				else 
				{
					$remainingSeat = $resultArray['totalseat'] -1;
					$updateString = "UPDATE cars SET totalseat='". $remainingSeat ."' WHERE phone='" . $mPubPhone . "' and day='" . $mDay . "' and fromto='" . $fromto . "'";
					$updateResult = mysql_query($updateString) or trigger_error("Query Failed:" . mysql_error()); 
					
					return true;
				}
			 }else
			 {
			 	$_SESSION['error'] = "can not get subscribed car information";		
			 }
			 
			 $lock->unlock();
		}
        
        function __destruct(){
            
        }
        
        
    }
?>