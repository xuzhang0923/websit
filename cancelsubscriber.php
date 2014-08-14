<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>拼车</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link rel="stylesheet" href="lightbox.css" type="text/css" media="screen" />

		<script src="js/prototype.js" type="text/javascript"></script>
		<script src="js/scriptaculous.js?load=effects" type="text/javascript"></script>
		<script src="js/lightbox.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/java.js"></script>
	</head>

<body>
<div id="wrap">

    <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/flower_shop/elements/menu.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/flower_shop/base/config.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/flower_shop/base/db_client.php';
        	require_once $_SERVER['DOCUMENT_ROOT'] . '/flower_shop/base/tools.php';
        
        $dbClient = new DB_Client();
		$tools = new Tools();
    ?>
			
			<?php
			if (isset($_GET['action'])) {
				switch ($_GET['action']) {
					case 'cancelSubscribe' :
						
						if($dbClient->loggedIn())
						{
							if(isset($_GET['id']) && isset($_GET['day']) && isset($_GET['fromto']) && isset($_GET['publisher']))
							{
								if(!$dbClient->cancelSubscriber($_GET['id'],$_GET['publisher'],$_GET['day'],$_GET['fromto']))
								{
									$_SESSION['message'] = $_SESSION['error'];
								}else{
									$_SESSION['message'] = "你已成功退订此车";
								}
							}
							
						}else
						{
							$_SESSION['message'] = "请登入后再执行相应操作";								
						}
						
						unset($_GET['id']);

						break;

					default :
						$_SESSION['message'] = "Invalid Request";
						break;
				}
			}else{
				$_SESSION['message'] = "Invalid Request";
			}

			?>

			<div class="center_content">

				<div class="left_content">

					<div class="title">
						<span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>退乘
					</div>

					<div class="prod_det_box">
						<div class="box_top"></div>
						<div class="box_center">
							<div class="prod_title">
								退乘结果
							</div>
							<p class="details">
								<?php echo $_SESSION['message']; ?>
							</p>
							<p class="details">
                             	  <span id="autojump">3秒后页面自动跳转回主页</span>
                             </p>	           
                                     	
                             <script language="javascript"> 
                             		var t = 3;
                             		var time = document.getElementById("autojump");
                             		function fun(){
                             	 		t--;
                             	 		time.innerHTML=t+"秒后页面自动跳回主页";
                             	 		if(t<=0){
                             	  			location.href = "index.php";
                             	  			clearInterval(inter);
                             	 		}
                             		}
                             		var inter = setInterval("fun()",1000);
                             </script>
							<div class="clear"></div>
						</div>

						<div class="box_bottom"></div>
					</div>

				</div>
				<!-- end of left content -->
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
									echo ("<a href=\"login/register.php?action=logout\"><span>登出</span></a>");
								}else{
									$loginSting = "<a href=\"login/register.php\"><span>登入/注册</span></a>";
									echo $loginSting;
								}
							?>	
						</p>

					</div>

				</div><!--end of right content-->

				<div class="clear"></div>
			</div><!--end of center content-->

			<div class="footer">
				<div class="left_footer"><img src="images/footer_logo.gif" alt="" title="">
				</div>
			</div>

		</div>

	</body>
</html>