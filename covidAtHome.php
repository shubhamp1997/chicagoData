
<?php
$nis = "hesun";
$password= "092700Jimmy";
$que = "SELECT G.A AS \"CASES AT HOME\", D.D_MONTH, D.D_YEAR
FROM \"G.AGRAWAL\".\"DATEVALUES\" D,
(SELECT (SUM(C.CASES_TOTAL)-SUM(D.HOSP_TOTAL)) AS A, T.D_ID AS B
FROM \"G.AGRAWAL\".\"COVID_CASES\" C, \"G.AGRAWAL\".\"COVID_HOSP\" D, \"G.AGRAWAL\".\"DATEVALUES\" T
WHERE C.D_ID=T.D_ID
AND D.D_ID=T.D_ID
GROUP BY T.D_ID)G
WHERE G.B=D.D_ID";
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
    $temp=$row[2] . $row[1];
    $arrayName = array("label" =>"$temp" ,"y"=>$row[0]);
    array_push($data,$arrayName);
    $i++;
}
$que = "SELECT D.D_MONTH, D.D_YEAR, SUM(C.CASES_TOTAL)
FROM \"G.AGRAWAL\".\"COVID_CASES\" C, \"G.AGRAWAL\".\"DATEVALUES\" D
WHERE C.D_ID=D.D_ID
GROUP BY D.D_MONTH, D.D_YEAR
ORDER BY D.D_MONTH, D.D_YEAR";
$result=oci_parse($conn,$que);
oci_execute($result);
$data1=array();
$total=array();
while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
    $temp=$row[1] . $row[0];
    $arrayName = array("label" =>"$temp" ,"y"=>$row[2]);
    array_push($data1,$arrayName);
    $i++;
}
array_push($total,$data1[3]);
array_push($total,$data1[7]);
array_push($total,$data1[0]);
array_push($total,$data1[8]);
array_push($total,$data1[6]);
array_push($total,$data1[5]);
array_push($total,$data1[1]);
array_push($total,$data1[11]);
array_push($total,$data1[10]);
array_push($total,$data1[9]);
array_push($total,$data1[2]);
array_push($total,$data1[4]);
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
		text: "Covid Cases At Home"
	},
	axisY:{
		includeZero: true,
    title:"Cases",
    titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
  axisY2:{
    includeZero:true,
    title:"total cases",
    titleFontColor: "#5A5757",
		lineColor: "#5A5757",
		labelFontColor: "#5A5757",
		tickColor: "#5A5757"
  }
  ,
  axisX:{
    title:"Year/Month"
  },
	data: [{
		type: "column", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
    name:"Total Cases",
    showInLegend:true,
		dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
	},{
    type:"spline",
		axisYType: "secondary",
    name:"Cases at Home",
    showInLegend:true,
    dataPoints: <?php echo json_encode($total, JSON_NUMERIC_CHECK); ?>
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
As can be seen in the graph, the number of covid cases that were treated at home and the total number of covid cases
has been following the same trend. The only places we can observe that this is different is when the total number of
covid cases starts to increase. This can most easily be seen for 2020 October. This shows that relatively more number
of people got treated at home as compared to other months. For 2020 June we can see that this ratio is very less and
so more ratio of people were hospitalised or died. This is due to the request by the government to not overcrowd the
hospitals during the time of peak covid cases and so people adhering to it and staying at home when and if possible.
<br><br>
</body>
<div align="center">
<form method="get" action="homePage.php">
    <button type="submit">HomePage</button>
</form>
</div>
</html>
