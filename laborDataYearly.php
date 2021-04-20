
<?php
$nis = "hesun";
$password= "092700Jimmy";
$que = "SELECT SUM(L.LABOR_FORCE), D.D_YEAR
FROM \"G.AGRAWAL\".\"LABOR_DATA\" L, \"G.AGRAWAL\".\"DATEVALUES\" D
WHERE L.D_ID=D.D_ID GROUP BY D.D_YEAR ORDER BY D.D_YEAR";
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
while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
    $arrayName = array("label" =>"$row[1]" ,"y"=>$row[0]);
    array_push($data,$arrayName);
    $i++;
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
		text: "Labor Data Yearly"
	},
	axisY:{
		includeZero: true,
    title:"population"
	},
  axisX:{
    title:"Year"
  },
	data: [{
		type: "column", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
		indexLabelFontColor: "#5A5757",
		indexLabelPlacement: "outside",
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
</body>
<div align="center">
<form method="get" action="homePage.php">
    <button type="submit">HomePage</button>
</form>
</div>
</html>
