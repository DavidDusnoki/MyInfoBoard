<html>
	<head>
		<link href="style.css" rel="stylesheet" type="text/css" />
		<script>
			function startTime() {
				var today = new Date();
				var h = today.getHours();
				var m = today.getMinutes();
				var s = today.getSeconds();
				m = checkTime(m);
				s = checkTime(s);
				document.getElementsByClassName('currentTime')[0].innerHTML =
				h + ":" + m + ":" + s;
				var t = setTimeout(startTime, 500);
			}
			function checkTime(i) {
				if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
				return i;
			}
		</script>
	</head>
	<body onload="startTime()">
<?php
	require("OpenLDBWS.php");
	$OpenLDBWS = new OpenLDBWS("43f1277a-bbae-41d6-8211-38146bbd7e17");
	$response = $OpenLDBWS->GetDepBoardWithDetails(5,"RAY","WAT");
	
	$array = (array)$response;
	$result = (array)$array['GetStationBoardResult'];
  
	$fromStation = $result['locationName'];
	$toStation = $result['filterLocationName'];
	$trainServices = $result['trainServices'];
	$trainServices_res = (array)$trainServices;
	$service = $trainServices_res['service'];
	$service_res = (array)$service;
	
	echo ("<div id='main'>");
	echo ("<div class='trains'>");
	
	echo ("
		<div class='trains-title'>
		From " . $fromStation . " to " . $toStation . "<br>
		</div>
	");
	
	
	foreach ($service_res as $value)
	{
		//echo('<table style="width:100%; background:#0ECEAB; font:#FFFFFF;">');
		echo('<table style="width:100%">');
		$value_arr = (array)$value;
		$origin = $value_arr['origin'];
		$origin_arr = (array)$origin;
		$location = $origin_arr['location'];
		$location_arr = (array)$location;
		$subsequentCallingPoints = $value_arr['subsequentCallingPoints'];
		$subsequentCallingPoints_arr = (array)$subsequentCallingPoints;
		$callingPointList = $subsequentCallingPoints_arr['callingPointList'];
		$callingPointList_arr = (array)$callingPointList;
		$callingPoint = $callingPointList_arr['callingPoint'];
		$callingPoint_arr = (array)$callingPoint;
		$firstPoint = $callingPoint_arr[0];
		$firstPoint_arr = (array)$firstPoint;
		$lastPoint = end($callingPoint_arr);
		$lastPoint_arr = (array)$lastPoint;
		//var_dump($callingPoint_arr);
		// vars
		$length = 4;
		
		// clean
		$keys = array_keys($value_arr);
		if(in_array("length", $keys))
		{
			$length = $value_arr['length'];
		}
		/*if(!isset($value_arr['length']) && !is_array($value_arr['length']))
		{
			$length = $value_arr['length'];
		}*/
		
		//var_dump($origin_arr);
		// 
		echo ("
			<tr>
				<td>
					Platform: " . $value_arr['platform'] . "
					<br>
					From: " . $location_arr['locationName'] . "
				</td>
				<td>
					" . $length . " coaches
					<br>
					Next station: " . $firstPoint_arr['locationName'] . "
				</td>
				<td>
					Standard departure: " . $value_arr['std'] . "
					<br>
					Standard arrival: " . $lastPoint_arr['st'] . "
				</td>
				<td>
					Expected departure: " . $value_arr['etd'] . "
					<br>
					Expected arrival: " . $lastPoint_arr['et'] . "
				</td>
			</tr>
		");
		echo("</table>");
	}
	echo ("</div>");
	echo ("<div class='time'><div class='currentTime'></div></div>");
	echo ("</div>");
	
	// $origin = $service[0];
	// $origin_res = (array)$origin;
?>
	</body>
</html>