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
	$response = $OpenLDBWS->GetDepartureBoard(5,"RAY","WAT");
	
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
	echo "From " . $fromStation . " to " . $toStation . "<br>";
	
	
	foreach ($service_res as $value)
	{
		echo('<table style="width:100%">');
		echo("<tr>");
		$value_arr = (array)$value;
		$origin = $value_arr['origin'];
		$origin_arr = (array)$origin;
		//var_dump($origin_arr);
		// 
		echo ("<td>Platform: " . $value_arr['platform'] . "</td>");
		echo ("<td>Standard departure: " . $value_arr['std'] . "</td>");
		echo ("<td>Expected departure: " . $value_arr['etd'] . "</td>");
		echo("</tr>");
		echo("<tr>");
		echo ("<td>" . $value_arr['length'] . " coaches </td>");
		echo("</tr>");
		echo("</table>");
	}
	echo ("</div>");
	echo ("<div class='currentTime'></div>");
	echo ("</div>");
	
	// $origin = $service[0];
	// $origin_res = (array)$origin;
?>
	</body>
</html>