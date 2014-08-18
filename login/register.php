<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
    		require_once '../global.php';
        require_once 'elements/menu.php';
        require_once 'base/config.php';
        require_once 'base/db_client.php';
        	require_once 'base/tools.php';
        
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
                                                                        <strong>注册成功</strong>
                                                                    </div>
                                                                    
																<div class="form_row">
                             	                            		<span id="autojump">3 秒后页面自动跳转到登入页面</span>
                             	                            		</div>
                                                                    
																	<div class="clear"></div>
                                                                
                                                            </div>';
                                        echo $registeredText;
										
										echo "<script language=\"javascript\"> 
                             				var t = 3;
                             				var time = document.getElementById(\"autojump\");
                             				function fun(){
                             	 				t--;
                             	 				time.innerHTML=t+\"秒后页面自跳转到登入页面\";
                             	 				if(t<=0){
                             	  					location.href = \"register.php\";
                             	  					clearInterval(inter);
                             	 				}
                             				}
                             				var inter = setInterval(\"fun()\",1000);
                             				</script>";
                                    }else {
                                    	$registeredText = '<div class="contact_form">
                                    	                        <div class="form_subtitle">Register</div>
                                    	                      		<div class="clear"></div>
                                    	                            
                                    	                            <div class="form_row">
                                    	                                <strong>' . $_SESSION['ERROR'] . '</strong>
                                    	                            </div>
                                    	                            
																<div class="clear"></div>
                                    	                        
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
                             			                                <strong>登入成功</strong>
                             			                            </div>
                             										
																	<div class="clear"></div>
                             			                            
                             	                            			<div class="form_row">
                             	                            				<span id="autojump">3秒后页面自动跳转回主页</span>
                             	                            			</div>    
                             			                    </div>';
                             			echo $registeredText;
										echo "<script language=\"javascript\"> 
                             				var t = 3;
                             				var time = document.getElementById(\"autojump\");
                             				function fun(){
                             	 				t--;
                             	 				time.innerHTML=t+\"秒后页面自跳转回主页\";
                             	 				if(t<=0){
                             	  					location.href = \"../index.php\";
                             	  					clearInterval(inter);
                             	 				}
                             				}
                             				var inter = setInterval(\"fun()\",1000);
                             				</script>";
                             		}
                             		else {
                             			$registeredText = '<div class="contact_form">
                             			                        <div class="form_subtitle">Login Failed</div>
                             			                      		<div class="clear"></div>
                             			                            
                             			                            <div class="form_row">
                             			                                <strong>Please check your user name and password</strong>
                             			                            </div>
                             			                            
																	<div class="clear"></div>
                             			                        
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
                             	                                <strong>您已登出系统</strong>
                             	                            </div>
                             	
                             	
                             	                            <div class="form_row">
                             	                            	<span id="autojump">3 秒后页面自动跳转回主页</span>
                             	                            </div>
                             	                        
                             	                    </div>';
                             	echo $registeredText;
                             	                   	
                             	echo "<script language=\"javascript\"> 
                             		var t = 3;
                             		var time = document.getElementById(\"autojump\");
                             		function fun(){
                             	 		t--;
                             	 		time.innerHTML=t+\"秒后页面自动跳转回页面\";
                             	 		if(t<=0){
                             	  			location.href = \"../index.php\";
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
			                                <label class="contact"><strong>手机号码:</strong></label>
			                                <input type="text" class="contact_input" name="phone" />
			                            </div>
			
			
			                            <div class="form_row">
			                                <label class="contact"><strong>密码:</strong></label>
			                                <input type="password" class="contact_input" name="password" />
			                            </div>
			
			
			                            <div class="form_row">
			                                <input type="submit" class="register" value="登入" />
			                            </div>
		                            </form>
	                         <?php }
	                         	else{
	                         ?>
	     	                        <form name="register" method="post" action=<?php echo $_SERVER['PHP_SELF'] . '?action=logout' ?>>
	     	                        
	     	                        	<div class="clear"></div>
	     	                        	                            
        	                            <div class="form_row">
        	                                <strong>您已登入</strong>
        	                            </div>
        	                            
        	                            <div class="clear"></div>
	     	                        	
	     	                            <div class="form_row">
	     	                                <input type="submit" class="register" value="登出" />
	     	                            </div>
	     	                        </form>
 	                    	<?php } ?>
                    </div>
                    
                    <div class="contact_form">
                        <div class="form_subtitle">register account</div>
                            <form name="register" method="post" action=<?php echo $_SERVER['PHP_SELF'] . '?action=register' ?>>
                            <div class="form_row">
                                <label class="contact"><strong>手机号码:</strong></label>
                                <input type="text" class="contact_input" name="phone" />
                            </div>


                            <div class="form_row">
                                <label class="contact"><strong>密码:</strong></label>
                                <input type="password" class="contact_input" name="password" />
                            </div>


                            <div class="form_row">
                                <input type="submit" class="register" value="注册" />
                            </div>
                        </form>
                    </div>

                <?php
                    }
                ?>

        	<div class="clear"></div>
        </div><!--end of left content-->


        <div class="right_content">
        	
        	<!-- here we first show accont information-->
					<div class="title">
						<span class="title_icon"><img src="images/bullet3.gif" alt="" title="" /></span>帐户信息
					</div>
					<div class="about">
						<p>
							<!-- cancel the img now <img src="images/about.gif" alt="" title="" class="right" />-->
							<?php
								if($dbClient->loggedIn()){
									echo ("欢迎:" . $_SESSION['phone']);
									echo "<br />";
									echo ("<a href=\"register.php?action=logout\"><span>登出</span></a>");
								}else{
									$loginSting = "<a href=\"register.php\"><span>登入/注册</span></a>";
									echo $loginSting;
								}
							?>	
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









