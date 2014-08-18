<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
    		require_once 'global.php';
        require_once 'elements/menu.php';
        require_once 'base/config.php';
        require_once 'base/db_client.php';
        	require_once 'base/tools.php';
        
        $dbClient = new DB_Client();
		$tools = new Tools();
    ?>
    

			
			<?php
			$page=0;
			if(isset($_GET['page']))
			{
				$page=$_GET['page'];
			}
			
			echo "<script type=\"text/javascript\">	
				var liElement = document.getElementsByName('menu". $page ."');
				if(liElement.length > 0)
				{
					liElement[0].className='selected';
				}
				</script>";
			if (isset($_GET['action'])) {
				switch ($_GET['action']) {
					case 'publishInformation' :
						if (isset($_SESSION['phone']) && isset($_POST['day']) && isset($_POST['time']) && isset($_POST['fromto']) && isset($_POST['seatnumber']) && $_POST['seatnumber'] != 0) {
							if ($dbClient -> publishInformation($_SESSION['phone'], $_POST['day'], $_POST['time'], $_POST['fromto'], $_POST['seatnumber'], $_POST['details'])) {
								echo "发布信息成功";
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
									echo "拼车成功";
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
				//header("Location: ". MACHINE_NAME . "/flower_shop/index.php");
			}
			?>

			<div class="center_content">

				<div class="left_content">

					<div class="title">
						<span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>拼车信息
					</div>
					
					<div class="clear"></div>

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

										$publishedInformaiton = $dbClient->retrieverInformation(date("Y-m-d",strtotime("+". $page ." day")), 1);						
			
										$tools->printCarInformation($publishedInformaiton);
									
									?>
							</div><!-- end of table 1 -->

							<div style="display: none;" class="tab" id="tab2">
								<div class="feat_prod_box"></div>
								<?php

									$publishedInformaiton = $dbClient->retrieverInformation(date("Y-m-d",strtotime("+". $page ." day")), 2);	
							
									$tools->printCarInformation($publishedInformaiton);
								?>
							</div><!-- end of table 2 -->
						</div><!--end of table container-->
					</div><!--end of demon-->
				</div> <!-- end of left content -->
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

					<!-- here we show published car information -->
					<div class="title">
						<span class="title_icon"><img src="images/bullet3.gif" alt="" title="" /></span>已发布拼车信息
					</div>
					<div class="about">
						
						<?php
							if(!$dbClient->loggedIn())
							{
								$loginSting = "登入系统后方可浏览此信息";
								echo $loginSting;
							}
							else{
						?>
								<div class="feat_prod_box_details">
									<table class="cart_table">
										<tr class="cart_title">
											<td>发车日期</td>
											<td>发车时间</td>
											<td>始-终</td>
											<td>剩余座位</td>
											<td>更多</td>
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
														<td>" . $tools->getTimeString($resultArray['time']) . "</td>
														<td>" . $tools->getStartAndEnd($resultArray['fromto']) . "</td>
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
						<span class="title_icon"><img src="images/bullet3.gif" alt="" title="" /></span>搭车信息
					</div>
					<div class="about">
						<?php
							if(!$dbClient->loggedIn())
							{
								$loginSting = "登入系统后方可浏览此信息";
								echo $loginSting;
							}
							else{
						?>
								<div class="feat_prod_box_details">
									<table class="cart_table">
										<tr class="cart_title">
											<td>发车日期</td>
											<td>始-终</td>
											<td>信息发布人</td>
											<td>退乗</td>
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
														<td>" . $tools->getStartAndEnd($resultArray['fromto']) . "</td>
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
						<span class="title_icon"><img src="images/bullet3.gif" alt="" title="" /></span>发布拼车信息
					</div>
					<div class="about">
						
						<?php
							if(!$dbClient->loggedIn())
							{
								$loginSting = "登入系统后方可浏览此信息";
								echo $loginSting;
							}else{
								date_default_timezone_set("Asia/Shanghai");
						?>

						<form name="register" method="post" action="?action=publishInformation">
							
								<label class="contact"><strong>Day:</strong></label>
								<select name="day">
									<option value= "0"> <?php echo date("Y-m-d") . "(". $tools->getWeekDay(date("N")) .")" ?> </option>
									<option value= "1"> <?php echo date("Y-m-d",strtotime("+1 day")) . "(". $tools->getWeekDay(date("N",strtotime("+1 day"))) .")"  ?> </option>
									<option value= "2"> <?php echo date("Y-m-d",strtotime("+2 day")) . "(". $tools->getWeekDay(date("N",strtotime("+2 day"))) .")" ?> </option>
									<option value= "3"> <?php echo date("Y-m-d",strtotime("+3 day")) . "(". $tools->getWeekDay(date("N",strtotime("+3 day"))) .")" ?> </option>
									<option value= "4"> <?php echo date("Y-m-d",strtotime("+4 day")) . "(". $tools->getWeekDay(date("N",strtotime("+4 day"))) .")" ?> </option>
									<option value= "5"> <?php echo date("Y-m-d",strtotime("+5 day")) . "(". $tools->getWeekDay(date("N",strtotime("+5 day"))) .")" ?> </option>
									<option value= "6"> <?php echo date("Y-m-d",strtotime("+6 day")) . "(". $tools->getWeekDay(date("N",strtotime("+6 day"))) .")" ?> </option>
								</select>
								<br/>
								<label class="contact"><strong>Time:</strong></label>
								<select name="time" class="timeselect">
									<?php
										for($i=1;$i<=18;$i++)
										{
											echo "<option value=\"" . $i . "\">" . $tools->getTimeString($i) . "</option>";
										}
									?>
								</select>
								<br/>					
								<label class="contact"><strong>From To</strong></label>
								<select name="fromto" class="fromtoselect">
									<option value= "1"> <?php echo $tools->getStartAndEnd(1) ?> </option>
									<option value= "2"> <?php echo $tools->getStartAndEnd(2) ?> </option>
								</select>
								<br/>							
								<label class="contact"><strong>total seat</strong></label>
								<textarea rows="1" name="seatnumber" cols="30" placeholder="输入空余座位数"></textarea>
                                    
								<br/>							
								<label class="contact"><strong>Detials</strong></label>
								<textarea rows="3" name="details" cols="30" placeholder="输入额外信息"></textarea>
							
							<div class="form_row">
								<input type="submit" class="register" value="发布拼车信息" />
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
		    	      
		    	      <!-- <div class="right_footer">
		    	      <a href="#">home</a>
		    	      <a href="#">about us</a>
		    	      <a href="#">services</a>
		    	      <a href="#">privacy policy</a>
		    	      <a href="#">contact us</a>
		    	     
		    	      </div>   -->
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