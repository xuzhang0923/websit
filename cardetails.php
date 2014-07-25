<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
		<title>Flower Shop</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link rel="stylesheet" href="lightbox.css" type="text/css" media="screen" />

		<script src="js/prototype.js" type="text/javascript"></script>
		<script src="js/scriptaculous.js?load=effects" type="text/javascript"></script>
		<script src="js/lightbox.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/java.js"></script>
	</head>

	<body>

		<div id="wrap">

			<?php
			require_once $_SERVER['DOCUMENT_ROOT'] . '/flower_shop/elements/menu.php';
			require_once $_SERVER['DOCUMENT_ROOT'] . '/flower_shop/base/config.php';
			require_once $_SERVER['DOCUMENT_ROOT'] . '/flower_shop/base/db_client.php';

			$dbClient = new DB_Client();
			?>
			
			<?php
			
			$_SESSION['message']="";
			if (isset($_GET['action'])) {
				switch ($_GET['action']) {
					case 'cardetails' :
						
						if($dbClient->loggedIn())
						{
							if(isset($_GET['day']) && isset($_GET['fromto']) && isset($_SESSION['phone']))
							{
								//constuct output string
								$outputString = "";
								$result = $dbClient->retreivePublishedInfromationBySubscribedCar($_SESSION['phone'], $_GET['day'], $_GET['fromto']);
								
								if(mysql_num_rows($result) > 0)
								{
									$fecthedArray = mysql_fetch_array($result);
									while($fecthedArray)
									{
										echo $fecthedArray['subscriber'];
										$fecthedArray = mysql_fetch_array($result);
									}
								}
								
							}else{
								$_SESSION['message'] = "parameter is not enought";
							}
							
						}else
						{
							$_SESSION['message'] = "You are login yet. Please log in and then perform the action";								
						}
						
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
						<span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>Traivel  Inforation
					</div>

					<div class="prod_det_box">
						<div class="box_top"></div>
						<div class="box_center">
							<div class="prod_title">
								Cancel Result
							</div>
							<p class="details">
								<?php echo $_SESSION['message']; ?>
							</p>
							
							<p>
								<?php echo $outPutString; ?>
							</p>
							
							<p class="details">
                             	  <span id="autojump">this page will jump to main page after 5 seconds</span>
                             </p>	           
                                     	
                             <script language="javascript"> 
                             		var t = 3;
                             		var time = document.getElementById("autojump");
                             		function fun(){
                             	 		t--;
                             	 		time.innerHTML="this page will jump to main page after "+t+" seconds";
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
						<span class="title_icon"><img src="images/bullet3.gif" alt="" title="" /></span>Account Information
					</div>
					<div class="about">
						<p>
							<!-- cancel the img now <img src="images/about.gif" alt="" title="" class="right" />-->
							<?php
								if($dbClient->loggedIn()){
									echo ("welecom : " . $_SESSION['phone']);
								}else{
									$loginSting = "<a href=\"login/register.php\"><span>log in</span></a>";
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