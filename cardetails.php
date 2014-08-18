<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>拼车信息</title>
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
    		require_once 'global.php';
        require_once 'elements/menu.php';
        require_once 'base/config.php';
        require_once 'base/db_client.php';
        	require_once 'base/tools.php';
        
        $dbClient = new DB_Client();
		$tools = new Tools();
    ?>
			
			<?php
			
			$_SESSION['message']="";
			$outputString="";
			if (isset($_GET['action'])) {
				switch ($_GET['action']) {
					case 'cardetails' :
						
						if($dbClient->loggedIn())
						{
							if(isset($_GET['day']) && isset($_GET['fromto']) && isset($_SESSION['phone']))
							{
								$outputString = "<table class=\"left_cart_table\">" .
													"<tr><td>信息发布人</td><td>" . $_SESSION['phone'] . "</td></tr>".
													"<tr><td>出发日期</td><td>" . $_GET['day'] . "</td></tr>".
													"<tr><td>始--终</td><td>" . $tools->getStartAndEnd($_GET['fromto']) . "</td></tr>";
							
								//constuct output string
								$result = $dbClient->retreivePublishedInfromationBySubscribedCar($_SESSION['phone'], $_GET['day'], $_GET['fromto']);
								if(mysql_num_rows($result) > 0)
								{

									$fecthedArray = mysql_fetch_array($result);
									while($fecthedArray)
									{
										$outputString .= "<tr><td> customer </td><td> " . $fecthedArray['subscriber'] . "</td></tr>";
										$fecthedArray = mysql_fetch_array($result);
									}
								}
								
								$outputString.="</table>";
								
							}else{
								$_SESSION['message'] = "parameter is not enought";
							}
							
						}else
						{
							$_SESSION['message'] = "请登入后再查询相关信息";								
						}
						
						 break;
// 						
					 case 'removePublishedCar' :
						
						if($dbClient->loggedIn())
						{
							if(isset($_POST['day']) && isset($_POST['fromto']) && isset($_SESSION['phone']))
							{
								//constuct output string
								$result = $dbClient->deletePublishCar($_SESSION['phone'], $_POST['day'], $_POST['fromto']);
								$_SESSION['message']= "<p class=left_text_area>您已成功移除此次发车信息</p>";								
							}else{
								$_SESSION['message'] = "parameter is not enought";
							}
							
							unset($_POST['day']);
							unset($_POST['fromto']);
						}else
							{
								$_SESSION['message'] = "请登入系统后再执行此操作";
							}
						
						break;

					default :
						$_SESSION['message'] = "无效操作";
						break;
				}
			}else{
				$_SESSION['message'] = "无效操作";
			}
			?>

			<div class="center_content">

				<div class="left_content">

					<div class="title">
						<span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>Details of this travel
					</div>

					<div class="prod_det_box">
						<div class="box_top"></div>
						<div class="box_center">
							<?php
								if($outputString == "")
								{
									echo $_SESSION['message'];
								}else{
									echo $outputString;
								
								
									$outputString = "<form method=\"post\" action=\"?action=removePublishedCar\">" . 
															"<input type=\"hidden\" name=\"phone\" value=\"" . $_SESSION['phone'] . "\"/>" .
															"<input type=\"hidden\" name=\"day\" value=\"" . $_GET['day'] . "\"/>" .
															"<input type=\"hidden\" name=\"fromto\" value=\"" . $_GET['fromto'] . "\"/>" .
			                           						 "<div class=\"form_row\">" .
			                           						 	"<input type=\"submit\" class=\"register\" value=\"删除\"/>".
			                            						 "</div>".
		                            						"</form>";
									unset($_GET['day']);
									unset($_GET['fromto']);
									echo $outputString;
								}
							?>
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