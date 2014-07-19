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
			if (isset($_GET['action'])) {
				switch ($_GET['action']) {
					case 'cancelSubscribe' :
						
						if($dbClient->loggedIn())
						{
							if(isset($_GET['id']))
							{
								if(!$dbClient->cancelSubscriber($_GET['id']))
								{
									$_SESSION['message'] = $_SESSION['error'];
								}else{
									$_SESSION['message'] = "You have successfully unsubscribe from this car";
								}
							}
							
						}else
						{
							$_SESSION['message'] = "You are login yet. Please log in and then perform the action";								
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

					<!-- here we show published car information -->
					<div class="title">
						<span class="title_icon"><img src="images/bullet3.gif" alt="" title="" /></span>Published Car Information
					</div>
					<div class="about">
						
						<?php
							if(!$dbClient->loggedIn())
							{
								$loginSting = "You need log in first";
								echo $loginSting;
							}
							else{
						?>
								<div class="feat_prod_box_details">
									<table class="cart_table">
										<tr class="cart_title">
											<td>day</td>
											<td>time</td>
											<td>FromTo</td>
											<td>LeftSeat</td>
											<td>More</td>
										</tr>
										
										<?php
										
											$publisedCar = $dbClient->retrievePublishedInformationByPublisher($_SESSION['phone']);
											if(mysql_num_rows($publisedCar))
											{
												$resultArray = mysql_fetch_array($publisedCar);
												while($resultArray)
												{
													$outPut = "<tr>
														<td>" . $resultArray['day'] . "</td>
														<td>" . $resultArray['time'] . "</td>
														<td>" . $resultArray['fromto'] . "</td>
														<td>" . $resultArray['totalseat'] . "</td>
														<td><a href=\"#\">more</a></td>
														</tr>";
													echo $outPut;
													$resultArray = mysql_fetch_array($publisedCar);
												}
											}
											

										?>
									</table>
								</div>
						<?php
							}
						?>

					</div>
					<!-- here we show subscribed car information -->
					<div class="title">
						<span class="title_icon"><img src="images/bullet3.gif" alt="" title="" /></span>Subscribed Car Information
					</div>
					<div class="about">
						<?php
							if(!$dbClient->loggedIn())
							{
								$loginSting = "You need log in first";
								echo $loginSting;
							}
							else{
						?>
								<div class="feat_prod_box_details">
									<table class="cart_table">
										<tr class="cart_title">
											<td>day</td>
											<td>FromTo</td>
											<td>Publisher</td>
											<td>Cancel</td>
										</tr>
										
										<?php
										
											$subscribedCar = $dbClient->retrieveSubscribedInformationBySubscriber($_SESSION['phone']);
											if(mysql_num_rows($subscribedCar))
											{
												$resultArray = mysql_fetch_array($subscribedCar);
												while($resultArray)
												{
													$outPut = "<tr>
														<td>" . $resultArray['day'] . "</td>
														<td>" . $resultArray['fromto'] . "</td>
														<td>" . $resultArray['publisher'] . "</td>
														<td><a href=\"" .
														'cancelsubscriber.php?subscriber=' . $_SESSION['phone'] . "&publisher=" . $resultArray['publisher'] . "&day=" . $resultArray['day'] . "&fromto=" . $resultArray['fromto'].
														"\">Cancel</a></td>
														</tr>";
													echo $outPut;
													$resultArray = mysql_fetch_array($subscribedCar);
												}
											}
										?>
									</table>
								</div>
						<?php
							}
						?>
						
					</div>
					<!-- here we show fast publish car information -->
					<div class="title">
						<span class="title_icon"><img src="images/bullet3.gif" alt="" title="" /></span>Fast Publish a Car
					</div>
					<div class="about">
						
						<?php
							if(!$dbClient->loggedIn())
							{
						?>
							You need to login first.
						<?php
							}else{
								date_default_timezone_set("Asia/Shanghai");
						?>

						<form name="register" method="post" action="?action=publishInformation">
							<div class="form_row">
								<label class="contact"><strong>Day:</strong></label>
								<br/>
								<select name="day">
									<option value= "0"> <?php echo date("Y-m-d") . date("N") ?> </option>
									<option value= "1"> <?php echo date("Y-m-d",strtotime("+1 day")) . date("N",strtotime("+1 day")) ?> </option>
									<option value= "2"> <?php echo date("Y-m-d",strtotime("+2 day")) . date("N",strtotime("+2 day")) ?> </option>
									<option value= "3"> <?php echo date("Y-m-d",strtotime("+3 day")) . date("N",strtotime("+3 day")) ?> </option>
									<option value= "4"> <?php echo date("Y-m-d",strtotime("+4 day")) . date("N",strtotime("+4 day")) ?> </option>
									<option value= "5"> <?php echo date("Y-m-d",strtotime("+5 day")) . date("N",strtotime("+5 day")) ?> </option>
									<option value= "6"> <?php echo date("Y-m-d",strtotime("+6 day")) . date("N",strtotime("+6 day")) ?> </option>
								</select>
							</div>
							
							<div class="form_row">
								<label class="contact"><strong>Time:</strong></label>
								<br/>
								<select name="time">
									<option value= "1"> 5:00 - 6:00 </option>
									<option value= "2"> 6:00 - 7:00 </option>
									<option value= "3"> 7:00 - 8:00 </option>
									<option value= "4"> 8:00 - 9:00 </option>
									<option value= "5"> 16:00 - 17:00 </option>
									<option value= "6"> 17:00 - 18:00 </option>
									<option value= "7"> 18:00 - 19:00 </option>
								</select>
							</div>
							
							<div class="form_row">
								<label class="contact"><strong>From To</strong></label>
								<br/>
								<select name="fromto">
									<option value= "1"> Beijing - Yixian </option>
									<option value= "2"> Yixian - Beijing </option>
								</select>
							</div>
							
							<div class="form_row" >
								<label class="contact"><strong>total seat</strong></label>
								<br/>
								<input type="text" class="contact_input" name="seatnumber" />
							</div>
							
							<div class="form_row">
								<label class="contact"><strong>Detials</strong></label>
								<br/>
								<input type="text" class="contact_input" name="details" />
							</div>
							
							<div class="form_row">
								<label class="contact"><strong>Submit</strong></label>
								<br/>
								<input type="submit" class="register" value="publish" />
							</div>
						</form>
					</div>
					<?php
					}
					?>

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