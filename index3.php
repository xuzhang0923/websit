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

    <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/flower_shop/elements/menu.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/flower_shop/base/config.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/flower_shop/base/db_client.php';
        
        $dbClient = new DB_Client();
    ?>
    
	<script type="text/javascript">
		var liElement = document.getElementsByName('menu4');
		if(liElement.length > 0)
		{
			liElement[0].className='selected';
		}
	</script>
			
			<?php
			if (isset($_GET['action'])) {
				switch ($_GET['action']) {
					case 'publishInformation' :
						if (isset($_SESSION['phone']) && isset($_POST['day']) && isset($_POST['time']) && isset($_POST['fromto']) && isset($_POST['seatnumber']) && $_POST['seatnumber'] != 0) {
							if ($dbClient -> publishInformation($_SESSION['phone'], $_POST['day'], $_POST['time'], $_POST['fromto'], $_POST['seatnumber'], $_POST['details'])) {
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
							if (isset($_POST['day']) && isset($_POST['fromto'] )&& isset($_POST['phone']) && isset($_SESSION['phone']) ) {
								if ($dbClient->subscribeCar($_SESSION['phone'], $_POST['phone'], $_POST['day'], $_POST['fromto'])) {
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
				header("Location: ". MACHINE_NAME . "/flower_shop/index.php");
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
											echo "<div class=feat_prod_box> <div class=prod_det_box>"	;
											$outputString = "<div class=\"box_top\"></div>
																	<div class=\"box_center\">
																		<div class=\"prod_title\">";
																			$outputString .= $fetchedArray['phone'];
														$outputString .="</div>";
											
														$outputString .= "<table class=\"left_cart_table\">";	
															    //$outputString .= "<tr class=\"cart_title\"><td>day</td><td>time</td><td>FromTo</td><td>LeftSeat</td></tr>";
																$outputString .= "<tr><td>day:   " . $fetchedArray['day'] . "</td>
																					 <td>time:   " . $fetchedArray['time'] . "</td>
																					 <td>fromto:    " . $fetchedArray['fromto'] . "</td>
																					 <td>leftseat:   " . $fetchedArray['totalseat'] . "</td>
																			      </tr>";			
														$outputString .="</table>";
														$outputString .="<div class=\"left_text_area\"><textarea class=\"left_text_area2\" rows=\"2\" name=\"details\" cols=\"45\" disabled=\"disabled\">" . $fetchedArray['details'] . "</textarea></div>";
														
														$outputString .= "<form method=\"post\" action=\"?action=add&tab=1\">" . 
																"<input type=\"hidden\" name=\"phone\" value=\"" . $fetchedArray['phone'] . "\"/>" .
																"<input type=\"hidden\" name=\"day\" value=\"" . $fetchedArray['day'] . "\"/>" .
																"<input type=\"hidden\" name=\"fromto\" value=\"" . $fetchedArray['fromto'] . "\"/>" .
				                           						 "<div class=\"form_row\">" .
				                           						 	"<input type=\"submit\" class=\"register\" value=\"register\"/>".
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
							</div><!-- end of table 1 -->

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
													
										$outputString .= "<form method=\"post\" action=\"?action=add&tab=2\">" . 
															"<input type=\"hidden\" name=\"phone\" value=\"" . $fetchedArray['phone'] . "\"/>" .
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
							</div><!-- end of table 2 -->
						</div><!--end of table container-->
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
														<td><a href=\"cardetails.php?action=cardetails&day=" .$resultArray['day']. "&fromto=". $resultArray['fromto'] . "\">more</a></td>
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
														'cancelsubscriber.php?action=cancelSubscribe&id=' . $resultArray['id']. "&day=" . $resultArray['day'] . "&fromto=" . $resultArray['fromto'] . "&publisher=" . $resultArray['publisher'] . 
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
							
								<label class="contact"><strong>Day:</strong></label>
								<select name="day">
									<option value= "0"> <?php echo date("Y-m-d") . date("N") ?> </option>
									<option value= "1"> <?php echo date("Y-m-d",strtotime("+1 day")) . date("N",strtotime("+1 day")) ?> </option>
									<option value= "2"> <?php echo date("Y-m-d",strtotime("+2 day")) . date("N",strtotime("+2 day")) ?> </option>
									<option value= "3"> <?php echo date("Y-m-d",strtotime("+3 day")) . date("N",strtotime("+3 day")) ?> </option>
									<option value= "4"> <?php echo date("Y-m-d",strtotime("+4 day")) . date("N",strtotime("+4 day")) ?> </option>
									<option value= "5"> <?php echo date("Y-m-d",strtotime("+5 day")) . date("N",strtotime("+5 day")) ?> </option>
									<option value= "6"> <?php echo date("Y-m-d",strtotime("+6 day")) . date("N",strtotime("+6 day")) ?> </option>
								</select>
								<br/>
								<label class="contact"><strong>Time:</strong></label>
								<select name="time" class="timeselect">
									<option value= "1"> 5:00 - 6:00 </option>
									<option value= "2"> 6:00 - 7:00 </option>
									<option value= "3"> 7:00 - 8:00 </option>
									<option value= "4"> 8:00 - 9:00 </option>
									<option value= "5"> 16:00 - 17:00 </option>
									<option value= "6"> 17:00 - 18:00 </option>
									<option value= "7"> 18:00 - 19:00 </option>
								</select>
								<br/>					
								<label class="contact"><strong>From To</strong></label>
								<select name="fromto" class="fromtoselect">
									<option value= "1"> Beijing - Yixian </option>
									<option value= "2"> Yixian - Beijing </option>
								</select>
								<br/>							
								<label class="contact"><strong>total seat</strong></label>
								<textarea rows="1" name="seatnumber" cols="30" placeholder="type how many seat for your car"></textarea>
                                    
								<br/>							
								<label class="contact"><strong>Detials</strong></label>
								<textarea rows="3" name="details" cols="30" placeholder="Type message here"></textarea>
							
							<div class="form_row">
								<input type="submit" class="register" value="publish" />
							</div>
							
							<div class="clear"></div>
						</form>
					</div>
					<?php
					}
					?>

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

		</div>

	</body>
	
	<script type="text/javascript">
		var tabber1 = new Yetii({
			id : 'demo',
			active : '<?php if(isset($_GET['tab']))
							{
								echo $_GET['tab'];
							}else{	
								echo 1;
							}
							unset($_GET['tab']);
					?>'
		});

	</script>
</html>