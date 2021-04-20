<?php
$nis = "hesun";
$password= "092700Jimmy";
$que = "SELECT L.M, D.D_MONTH, D.D_YEAR
FROM \"G.AGRAWAL\".\"DATEVALUES\" D,
(SELECT COUNT(C.ARREST) AS M, D.D_ID
FROM \"G.AGRAWAL\".\"CRIME\" C, \"G.AGRAWAL\".\"DATEVALUES\" D, \"G.AGRAWAL\".\"HAPPENS_AT\" H
WHERE C.ARREST='true'
AND C.DISTRICT = (SELECT A.DISTRICT
                     FROM (SELECT COUNT(C.C_ID) AS CNT, C.DISTRICT
                           FROM \"G.AGRAWAL\".\"CRIME\" C
                           GROUP BY C.DISTRICT
                           ORDER BY COUNT(C.C_ID) DESC)A
                     WHERE ROWNUM=1)
AND C.C_ID=H.C_ID
AND H.D_ID=D.D_ID
GROUP BY D.D_ID)L
WHERE L.D_ID=D.D_ID
AND D.D_YEAR>2016";
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
		text: "Monthly arrests in the district with the highest criminal cases"
	},
	axisY:{
		includeZero: true,
    title:"Cases"
	},
  axisX:{
    title:"Year/Month"
  },
	data: [{
		type: "line", //change type to bar, line, area, pie, etc
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
<h2>Conclustion </h2>
The above graph shows the trend for monthly arrests, meaning, of all the total cases, in how many cases there is an
arrest in the district with the most crimes reported in chicago, the Complex SQL query in this graph is implemented in
such a way that first it will determine which district has the highes overall crime, and then it will calculate monthly
arrests in that district and then show it in a monthly trend basis.
</body>
<br><br>
<div align="center">
<form method="get" action="homePage.php">
    <button type="submit">HomePage</button>
</form>
</div>
</html>
