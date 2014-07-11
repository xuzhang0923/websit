<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Pin Che</title>
<link rel="stylesheet" type="text/css" href="/flower_shop/style.css" />
<script language="javascript" type="text/javascript">
	function autoHeadAfterWhile()
	{

	}
</script>
</head>
<body>
<div id="wrap">

    <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/flower_shop/elements/menu.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/flower_shop/base/config.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/flower_shop/base/db_client.php';
        
        $dbClient = new DB_Client();
    ?>


    <div class="center_content">
        <div class="left_content">
            <div class="title"><span class="title_icon"><img src="/flower_shop/images/bullet1.gif" alt="" title="" /></span>My account</div>
                <?php
                    if (isset($_GET['action'])) {
                        switch (strtolower($_GET['action'])) {
                            case 'register':
                                // If the form was submitted lets try to create the account.
                                if (isset($_POST['password']) && isset($_POST['phone'])) {
                                    if ($dbClient->createAccount("test", $_POST['password'], $_POST['phone'])) {
                                        $registeredText = '<div class="contact_form">
                                                                <div class="form_subtitle">Register Successed</div>
                                                              		<div class="clear"></div>
                                                                    
                                                                    <div class="form_row">
                                                                        <strong>Register Successed</strong>
                                                                    </div>
                                        
                                        
                                                                    <div class="form_row">
                                                                    </div>
                                        
                                        
                                                                    <div class="form_row">
                                                                    </div>
                                                                    
                                                                    <div class="form_row">
                                                                    </div>
                                                                
                                                            </div>';
                                        echo $registeredText;
                                    }else {
                                    	$registeredText = '<div class="contact_form">
                                    	                        <div class="form_subtitle">Register</div>
                                    	                      		<div class="clear"></div>
                                    	                            
                                    	                            <div class="form_row">
                                    	                                <strong>' . $_SESSION['ERROR'] . '</strong>
                                    	                            </div>
                                    	
                                    	
                                    	                            <div class="form_row">
                                    	                            </div>
                                    	
                                    	
                                    	                            <div class="form_row">
                                    	                            </div>
                                    	                            
                                    	                            <div class="form_row">
                                    	                            </div>
                                    	                        
                                    	                    </div>';
                                    	                    
                                    	 echo $registeredText;
                                    }
                                }else {
                                    $_SESSION['error'] = "Username and or Password was not supplied.";
                                    unset($_GET['action']);
                                }
                                break;
                             case 'login':
                             	if (isset($_POST['password']) && isset($_POST['phone'])) {
                             		if($dbClient->validateUser($_POST['phone'],$_POST['password']))
                             		{
                             			$registeredText = '<div class="contact_form">
                             			                        <div class="form_subtitle">Login Successed</div>
                             			                      		<div class="clear"></div>
                             			                            
                             			                            <div class="form_row">
                             			                                <strong>Login Successed</strong>
                             			                            </div>
                             			
                             			
                             			                            <div class="form_row">
                             			                            </div>
                             			
                             			
                             			                            <div class="form_row">
                             			                            </div>
                             			                            
                             			                            <div class="form_row">
                             			                            </div>
                             			                        
                             			                    </div>';
                             			echo $registeredText;
                             		}
                             		else {
                             			$registeredText = '<div class="contact_form">
                             			                        <div class="form_subtitle">Login Failed</div>
                             			                      		<div class="clear"></div>
                             			                            
                             			                            <div class="form_row">
                             			                                <strong>Please check your user name and password</strong>
                             			                            </div>
                             			
                             			
                             			                            <div class="form_row">
                             			                            </div>
                             			
                             			
                             			                            <div class="form_row">
                             			                            </div>
                             			                            
                             			                            <div class="form_row">
                             			                            </div>
                             			                        
                             			                    </div>';
                             			echo $registeredText;
                             		}
                             	}else {
                             		
                             	}
                             	break;
                             case 'logout':
                             	unset($_SESSION['phone']);
                             	unset($_SESSION['loggedin']);
                             	
                             	$registeredText = '<div class="contact_form">
                             	                        <div class="form_subtitle">Logout</div>
                             	                      		<div class="clear"></div>
                             	                            
                             	                            <div class="form_row">
                             	                                <strong>You have logged out</strong>
                             	                            </div>
                             	
                             	
                             	                            <div class="form_row">
                             	                            	<span id="autojump">this page will jump to main page after 5 seconds</span>
                             	                            </div>
                             	                        
                             	                    </div>';
                             	echo $registeredText;
                             	                   	
                             	echo "<script language=\"javascript\"> 
                             		var t = 5;
                             		var time = document.getElementById(\"autojump\");
                             		function fun(){
                             	 		t--;
                             	 		time.innerHTML=\"this page will jump to main page after \"+t+\" seconds\";
                             	 		if(t<=0){
                             	  			location.href = \"http://www.baidu.com\";
                             	  			clearInterval(inter);
                             	 		}
                             		}
                             		var inter = setInterval(\"fun()\",1000);
                             		</script>";
                             	break;
                        }
                    }
                    else{
                ?>
                    <div class="contact_form">
                        <div class="form_subtitle">login into your account</div>
                        
                        	<?php  
                        		if(!$dbClient->loggedIn())
                        		{
                        	?>
		                            <form name="register" method="post" action=<?php echo $_SERVER['PHP_SELF'] . '?action=login' ?>>
			                            <div class="form_row">
			                                <label class="contact"><strong>Phone:</strong></label>
			                                <input type="text" class="contact_input" name="phone" />
			                            </div>
			
			
			                            <div class="form_row">
			                                <label class="contact"><strong>Password:</strong></label>
			                                <input type="password" class="contact_input" name="password" />
			                            </div>
			
			
			                            <div class="form_row">
			                                <input type="submit" class="register" value="login" />
			                            </div>
		                            </form>
	                         <?php }
	                         	else{
	                         ?>
	     	                        <form name="register" method="post" action=<?php echo $_SERVER['PHP_SELF'] . '?action=logout' ?>>
	     	                        
	     	                        	<div class="clear"></div>
	     	                        	                            
        	                            <div class="form_row">
        	                                <strong>You have logged in.</strong>
        	                            </div>
        	
        	
        	                            <div class="form_row">
        	                            </div>
        	
        	
        	                            <div class="form_row">
        	                            </div>
        	                            
        	                            <div class="form_row">
        	                            </div>
	     	                        	
	     	                            <div class="form_row">
	     	                                <input type="submit" class="register" value="logout" />
	     	                            </div>
	     	                        </form>
 	                    	<?php } ?>
                    </div>
                    
                    <div class="contact_form">
                        <div class="form_subtitle">register account</div>
                            <form name="register" method="post" action=<?php echo $_SERVER['PHP_SELF'] . '?action=register' ?>>
                            <div class="form_row">
                                <label class="contact"><strong>Phone:</strong></label>
                                <input type="text" class="contact_input" name="phone" />
                            </div>


                            <div class="form_row">
                                <label class="contact"><strong>Password:</strong></label>
                                <input type="password" class="contact_input" name="password" />
                            </div>


                            <div class="form_row">
                                <input type="submit" class="register" value="register" />
                            </div>
                        </form>
                    </div>

                <?php
                    }
                ?>

        	<div class="clear"></div>
        </div><!--end of left content-->


        <div class="right_content">

            <div class="title"><span class="title_icon"><img src="/flower_shop/images/bullet3.gif" alt="" title="" /></span>About Our Shop</div>
            <div class="about">
                <p>
                    <img src="/flower_shop/images/about.gif" alt="" title="" class="right" />
                    	This web sit is just on line, if you have any question, please contact me.
                </p>

            </div>
            
            <div class="clear"></div>
	        <div class="title"><span class="title_icon"><img src="/flower_shop/images/bullet3.gif" alt="" title="" /></span>Gruops</div>
	        <div class="about">
	            <p>
	                <img src="/flower_shop/images/about.gif" alt="" title="" class="right" />
	                	Group Number 1
	            </p>
	
	        </div>

        </div><!--end of right content-->

        <div class="clear"></div>
    </div><!--end of center content-->



    	 <div class="footer">
    	 		<div class="left_footer"><img src="/flower_shop/images/footer_logo.gif" alt="" title="" /></div>
    	      
    	      <div class="right_footer">
    	      <a href="#">home</a>
    	      <a href="#">about us</a>
    	      <a href="#">services</a>
    	      <a href="#">privacy policy</a>
    	      <a href="#">contact us</a>
    	     
    	      </div>  
    	</div>

</body>
</html>









