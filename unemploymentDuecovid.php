<?php
$nis = "hesun";
$password= "092700Jimmy";
$que = "SELECT K.U AS \"UNEMPLOYMENT\", K.CT AS \"COVID CASES\", D.D_MONTH, D.D_YEAR
FROM \"G.AGRAWAL\".\"DATEVALUES\" D,
(
SELECT O.U, P.CT, O.A FROM
(
SELECT AVG(L.UNEMPLOYEMENT) AS U, D.D_ID AS A
FROM \"G.AGRAWAL\".\"DATEVALUES\" D, \"G.AGRAWAL\".\"LABOR_DATA\" L
WHERE D.D_YEAR>2018
AND D.D_ID=L.D_ID
GROUP BY D.D_ID
)O
LEFT OUTER JOIN
(
SELECT SUM(C.CASES_TOTAL) AS CT, D.D_ID AS B
FROM \"G.AGRAWAL\".\"DATEVALUES\" D, \"G.AGRAWAL\".\"COVID_CASES\" C
WHERE D.D_ID=C.D_ID
GROUP BY D.D_ID
)P
ON O.A = P.B
)K
WHERE K.A=D.D_ID";
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
$covid=array();
while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
    $temp=$row[3] . $row[2];
    $arrayName = array("label" =>"$temp" ,"y"=>$row[0]);
    if(!isset($row[1])){
      $arrayName1 = array("label" =>"$temp" ,"y"=>0);
    }else{
      $arrayName1 = array("label" =>"$temp" ,"y"=>$row[1]);
    }
    array_push($data,$arrayName);
    array_push($covid,$arrayName1);
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
		text: "Unemployment Due to Covid"
	},
  axisX:{
    title: "Year/Month"
  }
  ,
	axisY: {
		title: "population",
    titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
  axisY2:{
    title:"covid cases",
    titleFontColor: "#C0504E",
		lineColor: "#C0504E",
		labelFontColor: "#C0504E",
		tickColor: "#C0504E"
  },
	data: [{
		type: "line",
    markerSize:0,
    name:"unemployment",
		showInLegend: true,
		dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
	},{
    type: "line",
    markerSize:0,
    axisYType:"secondary",
    name:"covis cases",
		showInLegend: true,
		dataPoints: <?php echo json_encode($covid, JSON_NUMERIC_CHECK); ?>
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
As we can observe from the initial phases of the graph, that is from 2019 to 2020, the unemployment number was pretty
consistent without any signs of future changes. But as we can observe from the red line, as soon as covid struck,
within a month or so, we can see that there was an exponential increase in unemployment and people were getting laid off due to
panic in the industries. But as soon as work from home concept got introduced and people got comfortable with it
and the supporting technologies, industries adapted and so unemployment rates started to go down even tho the covid cases were rising.
<br><br>
</body>
<div align="center">
<form method="get" action="homePage.php">
    <button type="submit">HomePage</button>
</form>
</div>
</html>
