<?php
$nis = "hesun";
$password= "092700Jimmy";
$que = "SELECT G.A AS \"CRIME\", G.B AS \"AVG UNEMPLOYMENT\", D.D_MONTH, D.D_YEAR
FROM \"G.AGRAWAL\".\"DATEVALUES\" D,
(SELECT COUNT(C.C_ID) AS A, AVG(L.UNEMPLOYEMENT) AS B, D.D_ID AS C
FROM \"G.AGRAWAL\".\"CRIME\" C, \"G.AGRAWAL\".\"LABOR_DATA\" L, \"G.AGRAWAL\".\"DATEVALUES\" D, \"G.AGRAWAL\".\"HAPPENS_AT\" H
WHERE C.C_ID=H.C_ID
AND H.D_ID=L.D_ID
AND L.D_ID=D.D_ID
AND D.D_YEAR>2016
AND D.D_YEAR<2021
GROUP BY D.D_ID
ORDER BY D.D_ID)G
WHERE D.D_ID=G.C";
$conn=oci_connect($nis,$password,
'oracle.cise.ufl.edu:1521/orcl');
if(empty($nis) or empty($password)){
    echo "UserID atau Password is empty<br>\n";}

if(!$conn){
    echo 'connection error';
}
?>
<html>
<body>
<h2>Query result</h2>
<?php
$result=oci_parse($conn,$que);
oci_execute($result);
$i=1;
$data=array();
$unemployment=array();
while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
    $temp=$row[3] . $row[2];
    $arrayName = array("label" =>"$temp" ,"y"=>$row[0]);
    $arrayName1 = array("label" =>"$temp" ,"y"=>$row[1]);
    array_push($data,$arrayName);
    array_push($unemployment,$arrayName1);
    $i++;
}
oci_free_statement($result);
oci_close($conn);
?>

<html>
<head>
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "Unemployment VS Crimes"
	},
  axisX:{
    title: "Year/Month"
  }
  ,
	axisY: {
		title: "cases",
    titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
  axisY2:{
    title:"population",
    titleFontColor: "#C0504E",
		lineColor: "#C0504E",
		labelFontColor: "#C0504E",
		tickColor: "#C0504E"
  },
	data: [{
		type: "line",
    name:"crime cases",
    markerSize:0,
		showInLegend: true,
		dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
	},{
    type: "line",
		axisYType: "secondary",
    name:"unemployment",
		markerSize: 0,
		showInLegend: true,
		dataPoints: <?php echo json_encode($unemployment, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();

}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<h2>Conclusion</h2>
Here we can observe that over the years, the unemployment trend as well as the Crime cases trend has been quite consistent
till January 2020, i.e. till the covid pandemic hit. The general trend of the crimes cases is that they peak every year around
the summer , i.e. around July, and then go on to decrease as the holiday seasons approach, i.e. around November and December,
and then again starts increasing the next year. We can see that the unemployment trend has no such similarity and hence can
conclude that there is no relation between the Crimes and Unemployment. What is interesting is the fact that when when Crime
cases dropped after the pandemic hit, It still followed the same trend discussed above.
<br><br>
</body>
<div align="center">
<form method="get" action="homePage.php">
    <button type="submit">HomePage</button>
</form>
</div>
</html>
