<?php
$nis = "hesun";
$password= "092700Jimmy";
$que = "SELECT G.U, G.E, G.L, D.D_MONTH, D.D_YEAR
FROM \"G.AGRAWAL\".\"DATEVALUES\" D,
(SELECT AVG(L.UNEMPLOYEMENT) AS U,  AVG(L.EMPLOYEMENT) AS E,  AVG(L.UNEMPLOYEMENT),  AVG(L.LABOR_FORCE) AS L , D.D_ID AS C
FROM \"G.AGRAWAL\".\"DATEVALUES\" D, \"G.AGRAWAL\".\"LABOR_DATA\" L
WHERE D.D_YEAR>2018
AND D.D_ID=L.D_ID
GROUP BY D.D_ID)G
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
$unemployment=array();
$laborForce=array();
$employment=array();
$unemploymentRate=array();
while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
  // Use the uppercase column names for the associative array indices
  $temp=$row[4] . $row[3];
  $arrayName1 = array("label" =>$temp ,"y"=>$row[0]);
  $arrayName2 = array("label" =>$temp,"y"=>$row[2]);
  $arrayName3 = array("label" =>$temp ,"y"=>$row[1]);
  array_push($unemployment,$arrayName1);
  array_push($laborForce,$arrayName2);
  array_push($employment,$arrayName3);
}
$que="SELECT G.U, D.D_MONTH, D.D_YEAR
FROM \"G.AGRAWAL\".\"DATEVALUES\" D,
(SELECT AVG(L.UNEMPLOYEMENT_RATE) AS U, D.D_ID AS C
FROM \"G.AGRAWAL\".\"DATEVALUES\" D, \"G.AGRAWAL\".\"LABOR_DATA\" L
WHERE D.D_YEAR>2018
AND D.D_ID=L.D_ID
GROUP BY D.D_ID)G
WHERE D.D_ID=G.C";
$result=oci_parse($conn,$que);
oci_execute($result);
$uRate=array();
while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
  // Use the uppercase column names for the associative array indices
  $temp=$row[2] . $row[1];
  $arrayName1 = array("label" =>$temp ,"y"=>$row[0]);
  array_push($uRate,$arrayName1);
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

var chart = new CanvasJS.Chart("chartContainer1", {
	animationEnabled: true,
	exportEnabled: true,
  zoonEnabled:true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Complete Labor Data"
	},
	axisY:{
		includeZero: true,
    title:"population"
	},
  axisX:{
    title:"Year/Month"
  },
	data: [{
		type: "line",
    indexLabelFontColor: "#5A5757",
		indexLabelPlacement: "outside",
    name: "unemployment",
    showInLegend:true,
		dataPoints: <?php echo json_encode($unemployment, JSON_NUMERIC_CHECK); ?>
	},{
    type:"line",
    name: "employment",
    showInLegend:true,
    dataPoints: <?php echo json_encode($employment, JSON_NUMERIC_CHECK); ?>
  },{
    type:"line",
    name: "labor force",
    showInLegend:true,
    dataPoints: <?php echo json_encode($laborForce, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();

var chart2 = new CanvasJS.Chart("chartContainer2", {
	animationEnabled: true,
	exportEnabled: true,
  zoonEnabled:true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Unemployment Rate"
	},
	axisY:{
		includeZero: true,
    title:"Rate"
	},
  axisX:{
    title:"Year/Month"
  },
	data: [{
		type: "line",
    indexLabelFontColor: "#5A5757",
		indexLabelPlacement: "outside",
    name:"unemployment rate",
    showInLegend:true,
		dataPoints: <?php echo json_encode($uRate, JSON_NUMERIC_CHECK); ?>
	}]
});
chart2.render();

}

</script>
</head>
<body>
<div id="chartContainer1" style="height: 370px; width: 100%;"></div>
<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
<div align="center">
<form method="get" action="homePage.php">
    <button type="submit">HomePage</button>
</form>
</div>
</html>
