<?php
class Tools {

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
			$outputString .= $fetchedArray['phone'];
			$outputString .= "</div>";

			$outputString .= "<table class=\"left_cart_table\">";
			//$outputString .= "<tr class=\"cart_title\"><td>day</td><td>time</td><td>FromTo</td><td>LeftSeat</td></tr>";
			$outputString .= "<tr><td>day:   " . $fetchedArray['day'] . "</td>
		<td>time:   " . $fetchedArray['time'] . "</td>
		<td>fromto:    " . $fetchedArray['fromto'] . "</td>
		<td>leftseat:   " . $fetchedArray['totalseat'] . "</td>
		</tr>";
			$outputString .= "</table>";
			$outputString .= "<div class=\"left_text_area\"><textarea class=\"left_text_area2\" rows=\"2\" name=\"details\" cols=\"45\" disabled=\"disabled\">" . $fetchedArray['details'] . "</textarea></div>";

			$outputString .= "<form method=\"post\" action=\"?action=add&tab=1\">" . "<input type=\"hidden\" name=\"phone\" value=\"" . $fetchedArray['phone'] . "\"/>" . "<input type=\"hidden\" name=\"day\" value=\"" . $fetchedArray['day'] . "\"/>" . "<input type=\"hidden\" name=\"fromto\" value=\"" . $fetchedArray['fromto'] . "\"/>" . "<div class=\"form_row\">" . "<input type=\"submit\" class=\"register\" value=\"register\"/>" . "
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