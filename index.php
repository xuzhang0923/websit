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
					case 'publishInformation' :
						if (isset($_POST['day']) && isset($_POST['time']) && isset($_POST['fromto']) && isset($_POST['seatnumber']) && $_POST['seatnumber'] != 0) {
							if ($dbClient -> publishInformation("123456789", $_POST['day'], $_POST['time'], $_POST['fromto'], $_POST['seatnumber'], $_POST['details'])) {
								echo "successfully pushlished the information";
							} else {
								echo $_SESSION['error'];
							}
						} else {
							echo "paramters is not enough";
						}

						break;

					case'add' :
						{
							if (isset($_POST['day']) && isset($_POST['fromto']) ) {
								if ($dbClient->subscribeCar("456789123", "123456789", $_POST['day'], $_POST['fromto'])) {
									echo "successfully subscribe the car";
								} else {
									echo $_SESSION['error'];
								}
							} else {
								echo "paramters is not enough";
							}

						}
						break;

					default :
						break;
				}

				unset($_GET['action']);
			}
			?>

			<div class="center_content">

				<div class="left_content">

					<div class="title">
						<span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>Traivel  Inforation
					</div>

					<div id="demo" class="demolayout">

						<ul id="demo-nav" class="demolayout">
							<li>
								<a class="active" href="#tab1">Beijing => Yixian</a>
							</li>
							<li>
								<a class="" href="#tab2">Yixian => Beijing</a>
							</li>
						</ul>
						<div class="tabs-container">
							<div style="display: block;" class="tab" id="tab1">
								<div class="feat_prod_box"></div>
								<?php
									$publishedInformaiton = $dbClient->retrieverInformation(date("Y-m-d"), 1);
									
									$fetchedArray = mysql_fetch_array($publishedInformaiton);
									while($fetchedArray)
									{
										$outputString = "<div class=\"feat_prod_box\">
															<div class=\"prod_det_box\">
																<div class=\"box_top\"></div>
																<div class=\"box_center\">
																	<div class=\"prod_title\">";
																		$outputString .= $fetchedArray['phone'];
													$outputString .="</div>";
										
													$outputString .= "<ul class=\"list\">";			
															$outputString .="<li> day      : " . $fetchedArray['day'] . "</li>";
															$outputString .="<li> time     : " . $fetchedArray['time'] . "</li>";
															$outputString .="<li> fromto   : " . $fetchedArray['fromto'] . "</li>";
															$outputString .="<li> totalseat: " . $fetchedArray['totalseat'] . "</li>";
															$outputString .="<li> details  : " . $fetchedArray['details'] . "</li>";
													$outputString .="</ul>";
													
													$outputString .= "<form method=\"post\" action=\"?action=add\">" . 
															"<input type=\"hidden\" name=\"day\" value=\"" . $fetchedArray['day'] . "\"/>" .
															"<input type=\"hidden\" name=\"fromto\" value=\"" . $fetchedArray['fromto'] . "\"/>" .
			                           						 "<div class=\"form_row\">" .
			                           						 	"<input type=\"submit\" class=\"register\" />".
			                            						 "</div>".
		                            						"</form>";
													$outputString .="<div class=\"clear\"></div>
																</div>
																<div class=\"box_bottom\"></div>
															</div>
															<div class=\"clear\"></div>
														</div>";
														
										echo $outputString;
										
										$fetchedArray = mysql_fetch_array($publishedInformaiton);
									}
								?>
							</div>

							<div style="display: none;" class="tab" id="tab2">
								<div class="feat_prod_box"></div>
								<?php
									$publishedInformaiton = $dbClient->retrieverInformation(date("Y-m-d"), 2);
									
									$fetchedArray = mysql_fetch_array($publishedInformaiton);
									while($fetchedArray)
									{
										$outputString = "<div class=\"feat_prod_box\">
															<div class=\"prod_det_box\">
																<div class=\"box_top\"></div>
																<div class=\"box_center\">
																	<div class=\"prod_title\">";
																		$outputString .= $fetchedArray['phone'];
													$outputString .="</div>";
										
													$outputString .= "<ul class=\"list\">";			
															$outputString .="<li> day      : " . $fetchedArray['day'] . "</li>";
															$outputString .="<li> time     : " . $fetchedArray['time'] . "</li>";
															$outputString .="<li> fromto   : " . $fetchedArray['fromto'] . "</li>";
															$outputString .="<li> totalseat: " . $fetchedArray['totalseat'] . "</li>";
															$outputString .="<li> details  : " . $fetchedArray['details'] . "</li>";
													$outputString .="</ul>";
													
										$outputString .= "<form method=\"post\" action=\"?action=add\">" . 
															"<input type=\"hidden\" name=\"day\" value=\"" . $fetchedArray['day'] . "\"/>" .
															"<input type=\"hidden\" name=\"fromto\" value=\"" . $fetchedArray['fromto'] . "\"/>" .
			                           						 "<div class=\"form_row\">" .
			                           						 	"<input type=\"submit\" class=\"register\" />".
			                            						 "</div>".
		                            						"</form>";
													
													$outputString .="<div class=\"clear\"></div>
																</div>
																<div class=\"box_bottom\"></div>
															</div>
															<div class=\"clear\"></div>
														</div>";
														
										echo $outputString;
										
										$fetchedArray = mysql_fetch_array($publishedInformaiton);
									}
								?>
							</div>

						</div>

					</div><!--end of demon-->
				</div> <!-- end of left content -->
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
									echo ("welecom" . $_SESSION['phone']);
								}else{
									echo ("you have no logged in yet, please log in first");
								}
							?>	
						</p>

					</div>

					<!-- here we show published car information -->
					<div class="title">
						<span class="title_icon"><img src="images/bullet3.gif" alt="" title="" /></span>Published Car Information
					</div>
					<div class="about">
						<p>
							You didn't sub car information
						</p>

					</div>
					<!-- here we show subscribed car information -->
					<div class="title">
						<span class="title_icon"><img src="images/bullet3.gif" alt="" title="" /></span>Subscribed Car Information
					</div>
					<div class="about">
						<p>
							You didn't subscribe to any car.
						</p>

					</div>
					<!-- here we show fast publish car information -->
					<div class="title">
						<span class="title_icon"><img src="images/bullet3.gif" alt="" title="" /></span>Fast Publish a Car
					</div>
					<div class="about">
						
						<?php
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

				</div><!--end of right content-->

				<div class="clear"></div>
			</div><!--end of center content-->

			<div class="footer">
				<div class="left_footer"><img src="images/footer_logo.gif" alt="" title="">
				</div>
			</div>

		</div>

	</body>
	
	<script type="text/javascript">
		var tabber1 = new Yetii({
			id : 'demo',
			active : '2'
		});

	</script>
</html>