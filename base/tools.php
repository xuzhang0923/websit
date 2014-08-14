<?php
class Tools {
	
	function getTimeString($time)
	{
		$result = "";
		switch ($time) {
			case '1':
				$result = "4:00 - 5:00";
				break;
			case '2':
				$result = "5:00 - 6:00";
				break;
			case '3':
				$result = "6:00 - 7:00";
				break;
			case '4':
				$result = "7:00 - 8:00";
				break;
			case '5':
				$result = "8:00 - 9:00";
				break;
			case '6':
				$result = "9:00 - 10:00";
				break;
			case '7':
				$result = "10:00 - 11:00";
				break;
			case '8':
				$result = "11:00 - 12:00";
				break;
			case '9':
				$result = "12:00 - 13:00";
				break;
			case '10':
				$result = "13:00 - 14:00";
				break;
			case '11':
				$result = "14:00 - 15:00";
				break;
			case '12':
				$result = "15:00 - 16:00";
				break;
			case '13':
				$result = "16:00 - 17:00";
				break;
			case '14':
				$result = "17:00 - 18:00";
				break;
			case '15':
				$result = "18:00 - 19:00";
				break;
			case '16':
				$result = "19:00 - 20:00";
				break;
			case '17':
				$result = "20:00 - 21:00";
				break;
			case '18':
				$result = "21:00 - 22:00";
				break;	
		}
		
		return $result;
	}

	function getStartAndEnd($fromto)
	{
		$result = "";
		switch ($fromto) {
			case '1':
				$result = "北京 - 易县";
				break;
			case '2':
				$result = "易县 - 北京";
				break;
		}
		return $result;
	}
	
	function getWeekDay($day)
	{
		$result = "";
		switch($day)
		{
			case '1':
				$result = "一";
				break;
			case '2':
				$result = "二";
				break;
			case '3':
				$result = "三";
				break;
			case '4':
				$result = "四";
				break;
			case '5':
				$result = "五";
				break;
			case '6':
				$result = "六";
				break;
			case '7':
				$result = "日";
				break;		
		}
		
		return $result;
	}
	
	function combineDayAndWeek($day)
	{
		$year=((int)substr($day,0,4));//取得年份

		$month=((int)substr($day,5,2));//取得月份

		$day=((int)substr($day,8,2));//取得几号

		 mktime(0,0,0,$month,$day,$year);
	}

	function printCarInformation($publishedInformation) {		
		$fetchedArray = mysql_fetch_array($publishedInformation);
		while ($fetchedArray) {
			echo "
<div class=feat_prod_box>
	<div class=prod_det_box>
		";
			$outputString = "<div class=\"box_top\"></div>
		<div class=\"box_center\">
		<div class=\"prod_title\">";
			$outputString .= "车主联系方式：". $fetchedArray['phone'];
			$outputString .= "</div>";

			$outputString .= "<table class=\"left_cart_table\">";
			//$outputString .= "<tr class=\"cart_title\"><td>day</td><td>time</td><td>FromTo</td><td>LeftSeat</td></tr>";
			$outputString .= "<tr><td>" . $fetchedArray['day'] . "</td>
		<td>" . $this->getTimeString($fetchedArray['time']) . "</td>
		<td>" . $this->getStartAndEnd($fetchedArray['fromto']) . "</td>
		<td>剩余座位:   " . $fetchedArray['totalseat'] . "</td>
		</tr>";
			$outputString .= "</table>";
			$outputString .= "<div class=\"left_text_area\"><textarea class=\"left_text_area2\" rows=\"2\" name=\"details\" cols=\"40\" disabled=\"disabled\">" . $fetchedArray['details'] . "</textarea></div>";

			$outputString .= "<form method=\"post\" action=\"?action=add&tab=1\">" . "<input type=\"hidden\" name=\"phone\" value=\"" . $fetchedArray['phone'] . "\"/>" . 
																					"<input type=\"hidden\" name=\"day\" value=\"" . $fetchedArray['day'] . "\"/>" . 
																					"<input type=\"hidden\" name=\"fromto\" value=\"" . $fetchedArray['fromto'] . "\"/>" . 
																					"<div class=\"form_row\">" . "<input type=\"submit\" class=\"register\" value=\"搭车\"/>" . "
	</div>" . "</form>";
			$outputString .= "<div class=\"clear\"></div>
	</div>
	<div class=\"box_bottom\"></div>
	</div>
	<div class=\"clear\"></div>
</div>";
			echo $outputString;

			$fetchedArray = mysql_fetch_array($publishedInformation);
		}
	}

}
?>