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
				
				$_SESSION['error'] = "there is such information has been published, please remove it first.";
				return false;
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
		
		function retrievePublishedInformationByPublisher($publisher)
		{
			$mPublisher = mysql_real_escape_string($publisher);
			
			$retriveSql = "SELECT phone,day,time,fromto,totalseat,details FROM cars WHERE phone='" . $mPublisher . "'";
			
			$retrieveResult = mysql_query($retriveSql) or trigger_error("Query Failed:" . mysql_error());
			
			return $retrieveResult;
		}
		
		function retrieveSubscribedInformationBySubscriber($subscriber)
		{
			$mSubscriber = mysql_real_escape_string($subscriber);
			
			$retriveSql = "SELECT id,publisher,day,fromto FROM subscribedInformation WHERE subscriber='" . $mSubscriber . "'";
			$retrieveResult = mysql_query($retriveSql) or trigger_error("Query Failed:" . mysql_error());
			
			return $retrieveResult;
		}
		
		function retreivePublishedInfromationBySubscribedCar($publisher, $day, $fromto)
		{
			$mPublisher = mysql_real_escape_string($publisher);
			$mDay = mysql_real_escape_string($day);
			$mFromTo = mysql_real_escape_string($fromto);
			
			$retriveSql = "SELECT subscriber,publisher,day,fromto FROM subscribedInformation WHERE publisher='" . $mPublisher . "' and day='" . $mDay . "' and fromto='" . $mFromTo . "'";
			$retrieveResult = mysql_query($retriveSql) or trigger_error("Query Failed:" . mysql_error());
			
			return $retrieveResult; 
		}
		
		function deletePublishCar($publisher, $day, $fromto)
		{
			$mPublisher = mysql_real_escape_string($publisher);
			$mDay = mysql_real_escape_string($day);
			$mFromTo = mysql_real_escape_string($fromto);
			
			$lock = new File_Lock($_SERVER['DOCUMENT_ROOT'] . '/flower_shop/base/' . 'addlock.lock');
			$lock->writeLock();
				$deleteString = "DELETE FROM cars WHERE phone='" . $mPublisher . "' and day='" . $mDay . "' and fromto='" . $mFromTo . "'";
				$deleteQuery = mysql_query($deleteString) or trigger_error("Deleted Failed" . mysql_error());
				
				$deleteString = "DELETE FROM subscribedInformation WHERE publisher='" . $mPublisher . "' and day='" . $mDay . "' and fromto='" . $mFromTo . "'";
				$deleteQuery = mysql_query($deleteString) or trigger_error("Deleted Failed" . mysql_error());
			$lock->unlock();
			
			return true;
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
				}
			 }else
			 {
			 	$_SESSION['error'] = "can not get subscribed car information";
			 	return false;	
			 }
			 
			 //added to subscribed car information.
			 $subscribedString = "INSERT INTO `subscribedInformation` (`subscriber`,`publisher`,`day`,`fromto`) VALUES ('" . $mSubPhone ."','" . $mPubPhone . "','". $mDay . "','" . $mFromto . "')";
			 $insterSubscribedResult = mysql_query($subscribedString) or trigger_error("Insert Failed:" . mysql_error());
			 $lock->unlock(); 
			 
			 
			 return true;
		}

		function cancelSubscriber($id,$publisher,$day,$fromto)
		{
			$mId = mysql_real_escape_string($id);
			
			//delete from details database.
			$deleteString = "DELETE FROM `subscribedInformation` WHERE id=\"" . $mId . "\"";
			
			if(!mysql_query($deleteString))
			{
				$_SESSION['error'] = mysql_error();
				return false;
			}
			
			//increase the car seat number
			$mPubPhone = mysql_real_escape_string($publisher);
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

				$remainingSeat = $resultArray['totalseat'] + 1;
				$updateString = "UPDATE cars SET totalseat='". $remainingSeat ."' WHERE phone='" . $mPubPhone . "' and day='" . $mDay . "' and fromto='" . $fromto . "'";
				$updateResult = mysql_query($updateString) or trigger_error("Query Failed:" . mysql_error()); 
			 }else
			 {
			 	$_SESSION['error'] = "can not get subscribed car information";
			 	return false;	
			 }
			 $lock->unlock(); 
			
			return true;
		}
        
        function __destruct(){
            
        }
        
        
    }
?>