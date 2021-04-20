
<?php
$nis = "hesun";
$password= "092700Jimmy";
$que = "SELECT D.D_MONTH, D.D_YEAR, SUM(C.CASES_TOTAL)
FROM \"G.AGRAWAL\".\"COVID_CASES\" C, \"G.AGRAWAL\".\"DATEVALUES\" D
WHERE C.D_ID=D.D_ID
GROUP BY D.D_MONTH, D.D_YEAR
ORDER BY D.D_MONTH, D.D_YEAR";
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
$data1=array();
$data=array();
while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
    $temp=$row[1] . $row[0];
    $arrayName = array("label" =>"$temp" ,"y"=>$row[2]);
    array_push($data1,$arrayName);
    $i++;
}
array_push($data,$data1[3]);
array_push($data,$data1[7]);
array_push($data,$data1[0]);
array_push($data,$data1[8]);
array_push($data,$data1[6]);
array_push($data,$data1[5]);
array_push($data,$data1[1]);
array_push($data,$data1[11]);
array_push($data,$data1[10]);
array_push($data,$data1[9]);
array_push($data,$data1[2]);
array_push($data,$data1[4]);
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
		text: "Covid Cases VS Month and Year"
	},
	axisY:{
		includeZero: true,
    title:"population"
	},
  axisX:{
    title:"Year/Month"
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
