
<?php
$nis = "hesun";
$password= "092700Jimmy";
$que = "SELECT I.A AS \"0-17 Cases\",
I.B AS \"18-29 Cases\",
I.C AS \"30-39 Cases\",
I.D AS \"40-49 Cases\",
I.E AS \"50-59 Cases\",
I.F AS \"60-69 Cases\",
I.G AS \"70-79 Cases\",
I.H AS \"80-100 Cases\",
D.D_MONTH,
D.D_YEAR
FROM \"G.AGRAWAL\".\"DATEVALUES\" D,
(
SELECT D.D_ID,
SUM(C.Cases_0_17) AS A ,
SUM(C.CASES_18_29)AS B,
SUM(C.Cases_30_39)AS C,
SUM(C.CASES_40_49)AS D,
SUM(C.CASES_50_59)AS E,
SUM(C.CASES_60_69)AS F,
SUM(C.CASES_70_79)AS G,
SUM(C.CASES_80) AS H
FROM \"G.AGRAWAL\".\"COVID_CASES\" C, \"G.AGRAWAL\".\"DATEVALUES\" D
WHERE C.D_ID=D.D_ID
GROUP BY D.D_ID
)I
WHERE D.D_ID=I.D_ID";
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
$origin=array();
$a17=array();
$a29=array();
$a39=array();
$a49=array();
$a59=array();
$a69=array();
$a79=array();
$a100=array();
while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
    $temp=$row[9] . $row[8];
    $arrayName = array("label" =>"$temp" ,"y"=>$row[0]);
    array_push($a17,$arrayName);
    $arrayName = array("label" =>"$temp" ,"y"=>$row[1]);
    array_push($a29,$arrayName);
    $arrayName = array("label" =>"$temp" ,"y"=>$row[2]);
    array_push($a39,$arrayName);
    $arrayName = array("label" =>"$temp" ,"y"=>$row[3]);
    array_push($a49,$arrayName);
    $arrayName = array("label" =>"$temp" ,"y"=>$row[4]);
    array_push($a59,$arrayName);
    $arrayName = array("label" =>"$temp" ,"y"=>$row[5]);
    array_push($a69,$arrayName);
    $arrayName = array("label" =>"$temp" ,"y"=>$row[6]);
    array_push($a79,$arrayName);
    $arrayName = array("label" =>"$temp" ,"y"=>$row[7]);
    array_push($a100,$arrayName);
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
		text: "Covid Cases with Age Group"
	},
	axisY:{
		includeZero: true,
    title:"population"
	},
  axisX:{
    title:"Year/Month"
  },
	data: [{
		type: "stackedColumn",
    name: "age 0-17",
		showInLegend: true,
		dataPoints: <?php echo json_encode($a17, JSON_NUMERIC_CHECK); ?>
	},{
		type: "stackedColumn",
    name: "age 18-29",
		showInLegend: true,
		dataPoints: <?php echo json_encode($a29, JSON_NUMERIC_CHECK); ?>
	},{
		type: "stackedColumn",
    name: "age 30-39",
		showInLegend: true,
		dataPoints: <?php echo json_encode($a39, JSON_NUMERIC_CHECK); ?>
	},{
		type: "stackedColumn",
    name: "age 40-49",
		showInLegend: true,
		dataPoints: <?php echo json_encode($a49, JSON_NUMERIC_CHECK); ?>
	},{
		type: "stackedColumn",
    name: "age 50-59",
		showInLegend: true,
		dataPoints: <?php echo json_encode($a59, JSON_NUMERIC_CHECK); ?>
	},{
		type: "stackedColumn",
    name: "age 60-69",
		showInLegend: true,
		dataPoints: <?php echo json_encode($a69, JSON_NUMERIC_CHECK); ?>
	},{
		type: "stackedColumn",
    name: "age 70-79",
		showInLegend: true,
		dataPoints: <?php echo json_encode($a79, JSON_NUMERIC_CHECK); ?>
	},{
		type: "stackedColumn",
    name: "age 80-100",
		showInLegend: true,
		dataPoints: <?php echo json_encode($a100, JSON_NUMERIC_CHECK); ?>
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
This interesting graph shows us the covid cases trends for every age group throughout the year.
It shows that even though the older generations were much more suciptible to corona virus,
it was actually the younger generation which had the most cases, this difference can be observed
very clearly in 2020 october, where the cases from the age group 18 - 39 is approx 27000, around twice than the
cases for 40-59 which is approx 16000.
<br>
</body>
<div align="center">
<form method="get" action="homePage.php">
    <button type="submit">HomePage</button>
</form>
</div>
</html>
