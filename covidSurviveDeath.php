
<?php
$nis = "hesun";
$password= "092700Jimmy";
$que = "SELECT G.A AS \"SURVIVED\", G.F AS \"DEATHS\", D.D_MONTH, D.D_YEAR
FROM \"G.AGRAWAL\".\"DATEVALUES\" D,
(SELECT (SUM(C.CASES_TOTAL)-SUM(D.DEATHS_TOTAL)) AS A, SUM(D.DEATHS_TOTAL) AS F, T.D_ID AS B
FROM \"G.AGRAWAL\".\"COVID_CASES\" C, \"G.AGRAWAL\".\"COVID_DEATHS\" D, \"G.AGRAWAL\".\"DATEVALUES\" T
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
$death=array();
while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
    $temp=$row[3] . $row[2];
    $arrayName = array("label" =>"$temp" ,"y"=>$row[0]);
    $arrayName1 = array("label" =>"$temp" ,"y"=>$row[1]);
    array_push($data,$arrayName);
    array_push($death,$arrayName1);
    $i++;
}
$que = "SELECT G.A AS \"SURVIVED\", G.F AS \"DEATHS\",ROUND(G.M,2) AS \"MORTALITY RATE PER 1000 PEOPLE\", D.D_MONTH, D.D_YEAR
FROM \"G.AGRAWAL\".\"DATEVALUES\" D,
(SELECT
(SUM(C.CASES_TOTAL)-SUM(D.DEATHS_TOTAL)) AS A,
 SUM(D.DEATHS_TOTAL) AS F,
 (SUM(D.DEATHS_TOTAL)/SUM(C.CASES_TOTAL)*1000) AS M,
 T.D_ID AS B
FROM \"G.AGRAWAL\".\"COVID_CASES\" C, \"G.AGRAWAL\".\"COVID_DEATHS\" D, \"G.AGRAWAL\".\"DATEVALUES\" T
WHERE C.D_ID=T.D_ID
AND D.D_ID=T.D_ID
GROUP BY T.D_ID)G
WHERE G.B=D.D_ID";
$result=oci_parse($conn,$que);
oci_execute($result);
$rate=array();
while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
    $temp=$row[4] . $row[3];
    $arrayName = array("label" =>"$temp" ,"y"=>$row[2]);
    array_push($rate,$arrayName);
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
		text: "Survive VS Death Cases"
	},
  axisX:{
    title: "Year/Month"
  }
  ,
	axisY: [{
		title: "Survived Cases",
    titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},{
    title:"Death cases",
    titleFontColor: "#C0504E",
		lineColor: "#C0504E",
		labelFontColor: "#C0504E",
		tickColor: "#C0504E"
  }],
  axisY2:{
    title:"Mortality Rate",
    titleFontColor: "#9ACD32",
		lineColor: "#9ACD32",
		labelFontColor: "#9ACD32",
		tickColor: "#9ACD32"
  },
	data: [{
		type: "line",
    name:"Survived",
    axisYIndex:0,
    markerSize:0,
		showInLegend: true,
		dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
	},{
    type: "line",
    name:"Death",
    axisYIndex:1,
		markerSize: 0,
		showInLegend: true,
		dataPoints: <?php echo json_encode($death, JSON_NUMERIC_CHECK); ?>
  },{
    type: "line",
    name:"Mortality Rate",
    axisYType:"secondary",
    lineColor:"#9ACD32",
		markerSize: 0,
		showInLegend: true,
		dataPoints: <?php echo json_encode($rate, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
}
</script>
</head>
<body>
<div id="chartContainer">
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div>
<h2>Conclusion</h2>
From the above graph, we can clearly obeserve that even though the values of all three categories are relatively very different,
 they all follow the same trend in a manner, and are interdependent on each other. We can see that in the beginning when the covid
 cases started coming, both, the survived cases and Death rate rose, and as soon as the total cases started droppin after june, we
 see a steep decline in all the graphs, we can also observe that the Mortality rate has been a very balanced factor between the deaths
  and the survived throughout the pandamic. The mortality rate shows the number of people died every 1000 people, we can see previously
   when public was unaware of the importance of social distancing etc, they mortality rate was pretty high, but then it fell pretty
   rapidly as the public became more aware.
 </div>
 <br>
 <div align="center">
 <form method="get" action="homePage.php">
     <button type="submit">HomePage</button>
 </form>
 </div>
</body>
</html>
