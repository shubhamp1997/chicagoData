
<?php
$nis = "hesun";
$password= "092700Jimmy";
$que = "SELECT F.A, J.B, D.D_MONTH, D.D_YEAR
FROM \"G.AGRAWAL\".\"DATEVALUES\" D,
(SELECT COUNT(C.ARREST) AS A, H.D_ID
FROM \"G.AGRAWAL\".\"CRIME\" C, \"G.AGRAWAL\".\"HAPPENS_AT\" H
WHERE C.C_ID=H.C_ID
AND C.ARREST='true'
GROUP BY H.D_ID)F,
(SELECT COUNT(C.ARREST) AS B, H.D_ID
FROM \"G.AGRAWAL\".\"CRIME\" C, \"G.AGRAWAL\".\"HAPPENS_AT\" H
WHERE C.DOMESTIC='true'
AND C.C_ID=H.C_ID
AND C.ARREST='true'
GROUP BY H.D_ID)J
WHERE J.D_ID=D.D_ID
AND F.D_ID=D.D_ID
AND D.D_YEAR>2016
AND D.D_YEAR<2021
ORDER BY D.D_ID";
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
$data=array();
$dom=array();
while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
    $temp=$row[3] . $row[2];
    $arrayName = array("label" =>"$temp" ,"y"=>$row[0]);
    $arrayName1= array("label" =>"$temp" ,"y"=>$row[1]);
    array_push($data,$arrayName);
    array_push($dom,$arrayName1);
}
oci_free_statement($result);
oci_close($conn);
?>
</body>
</html>
<html>
<head>
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
  zoonEnabled:true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Total Arrests VS Domestic Arrests"
	},
	axisY:{
		includeZero: true,
    title:"Arrests",
    titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
  axisX:{
    title:"Year/Month"
  },
	data: [{
		type: "column", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
    name:"Domestic Arrests",
    showInLegend:true,
		dataPoints: <?php echo json_encode($dom, JSON_NUMERIC_CHECK); ?>
	},{
    type:"line",
    name:"Total Arrests",
    showInLegend:true,
    dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
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
From the graph above, we know that domestic arrests are keep at the same level during these years. It doesn't have very huge fluctuation
due to the time change. However, total arrests have a big fluctuation during these years. It falls and rises each month. The most notable
fall is in Feb, Mar 2020. Due to the covid-19 virus, the public has been required to decrease the unnecessary transportation and to decrease
face-to-face chances. Therefore, the policeman have also been affected and have to decrease the numbers of arresting crimnials.
<br><br> 
</body>
<div align="center">
<form method="get" action="homePage.php">
    <button type="submit">HomePage</button>
</form>
</div>
</html>
