
<?php
$nis = "hesun";
$password= "092700Jimmy";
$que = "SELECT F.A AS \"TOTAL CRIME\", G.B AS \"APARTMENT ARREST\", J.K AS \"STREET ARREST\", D.D_MONTH, D.D_YEAR
FROM \"G.AGRAWAL\".\"DATEVALUES\" D,
(SELECT COUNT(C.C_ID) AS A, H.D_ID
FROM \"G.AGRAWAL\".\"CRIME\" C, \"G.AGRAWAL\".\"HAPPENS_AT\" H
WHERE (C.LOCATION_DESCRIPTION='APARTMENT' OR C.LOCATION_DESCRIPTION='STREET')
AND C.C_ID=H.C_ID
GROUP BY H.D_ID)F,
(SELECT COUNT(C.ARREST) AS B, H.D_ID
FROM \"G.AGRAWAL\".\"CRIME\" C, \"G.AGRAWAL\".\"HAPPENS_AT\" H
WHERE C.LOCATION_DESCRIPTION='APARTMENT'
AND C.ARREST='true'
AND C.C_ID=H.C_ID
GROUP BY H.D_ID)G,
(SELECT COUNT(C.ARREST) AS K, H.D_ID
FROM \"G.AGRAWAL\".\"CRIME\" C, \"G.AGRAWAL\".\"HAPPENS_AT\" H
WHERE C.LOCATION_DESCRIPTION='STREET'
AND C.ARREST='true'
AND C.C_ID=H.C_ID
GROUP BY H.D_ID)J
WHERE G.D_ID=D.D_ID
AND F.D_ID=D.D_ID
AND J.D_ID=D.D_ID
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
$i=1;
$apart=array();
$street=array();
$total=array();
while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
    $temp=$row[4] . $row[3];
    $arrayName = array("label" =>"$temp" ,"y"=>$row[0]);
    $arrayName1 = array("label" =>"$temp" ,"y"=>$row[1]);
    $arrayName2 = array("label" =>"$temp" ,"y"=>$row[2]);
    array_push($total,$arrayName);
    array_push($apart,$arrayName1);
    array_push($street,$arrayName2);
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
		text: "Apartment Arrest VS Street Arrest"
	},
  axisX:{
    title: "Year/Month"
  }
  ,
	axisY: {
		title: "Arrests",
    titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
  axisY2:{
    title:"Total Arrests",
    titleFontColor: "#9ACD32",
		lineColor: "#9ACD32",
		labelFontColor: "#9ACD32",
		tickColor: "#9ACD32"
  },
	data: [{
		type: "line",
    name:"Apartment",
    axisYIndex:0,
    markerSize:0,
		showInLegend: true,
		dataPoints: <?php echo json_encode($apart, JSON_NUMERIC_CHECK); ?>
	},{
    type: "line",
    name:"Street",
    axisYIndex:1,
		markerSize: 0,
		showInLegend: true,
		dataPoints: <?php echo json_encode($street, JSON_NUMERIC_CHECK); ?>
  },{
    type: "line",
    name:"Total Arrest",
    axisYType:"secondary",
    lineColor:"#9ACD32",
		markerSize: 0,
		showInLegend: true,
		dataPoints: <?php echo json_encode($total, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
}
</script>
</head>
<body>
<div id="chartContainer"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<h2>Conclusion</h2>
From the graph, we observe that apartment arrests are relatively stable compare to the street arrests and total arrests during three years.
The reason why it is stable is that aparment is fixed and not easily affected by the outer environment. It is not too random for policeman to
make the action. However, total arrests and street arrests have almost the same trend. When it's the beginning of the year, such as Janauary to March, total
arrests and street arrests are the lowest during this year. That's because Thanksgiving break, Christmas break are in the begnining of the year,
which cause the crime caese stay at a low level. Therefore, as the total crime cases decrease, the street arrests will decrease also.
</body>
<br><br>
<div align="center">
<form method="get" action="homePage.php">
    <button type="submit">HomePage</button>
</form>
</div>
</html>
