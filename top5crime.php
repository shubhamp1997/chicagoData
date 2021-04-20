<?php
$nis = "hesun";
$password= "092700Jimmy";
$que = "SELECT COUNT(C.C_ID) AS \"No. of Cases\", A.PRIMARY_TYPE, D.D_YEAR
FROM \"G.AGRAWAL\".\"CRIME\" C, \"G.AGRAWAL\".\"HAPPENS_AT\" H, \"G.AGRAWAL\".\"DATEVALUES\" D, \"G.AGRAWAL\".\"ARCHIVE\" A
WHERE A.IUCR = C.IUCR AND H.C_ID = C.C_ID AND D.D_ID = H.D_ID AND D_YEAR<2021 AND D_YEAR>2016
AND A.PRIMARY_TYPE IN
                    (SELECT A.PRIMARY_TYPE
                        FROM (SELECT * FROM (SELECT COUNT(C.C_ID) AS CNT, A.PRIMARY_TYPE
                                    FROM \"G.AGRAWAL\".\"CRIME\" C, \"G.AGRAWAL\".\"ARCHIVE\" A
                                    WHERE A.IUCR=C.IUCR
                                    GROUP BY A.PRIMARY_TYPE
                                    ORDER BY COUNT(C.C_ID) DESC)Z WHERE ROWNUM<=5 ORDER BY Z.CNT DESC) X,
                                \"G.AGRAWAL\".\"ARCHIVE\" A
                        WHERE A.PRIMARY_TYPE=X.PRIMARY_TYPE)
GROUP BY A.PRIMARY_TYPE,D.D_YEAR
ORDER BY D.D_YEAR,COUNT(C.C_ID) DESC";
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
<h2>Query Result</h2>

<?php
$result=oci_parse($conn,$que);
oci_execute($result);
$assault=array();
$battery=array();
$cDmage=array();
$dPractice=array();
$theft=array();
while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
  if($row[1]=="ASSAULT"){
    $arrayName = array("label" =>"$row[2]" ,"y"=>$row[0]);
    array_push($assault,$arrayName);
  }
  if($row[1]=="BATTERY"){
    $arrayName = array("label" =>"$row[2]" ,"y"=>$row[0]);
    array_push($battery,$arrayName);
  }
  if($row[1]=="CRIMINAL DAMAGE"){
    $arrayName = array("label" =>"$row[2]" ,"y"=>$row[0]);
    array_push($cDmage,$arrayName);
  }
  if($row[1]=="DECEPTIVE PRACTICE"){
    $arrayName = array("label" =>"$row[2]" ,"y"=>$row[0]);
    array_push($dPractice,$arrayName);
  }
  if($row[1]=="THEFT"){
    $arrayName = array("label" =>"$row[2]" ,"y"=>$row[0]);
    array_push($theft,$arrayName);
  }
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
	theme: "light2",
	title:{
		text: "Top 5 Crimes Each Year in Chicago"
	},
	axisY:{
		includeZero: true
	},
	legend:{
		cursor: "pointer",
		verticalAlign: "center",
		horizontalAlign: "right",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Assaults",
    indexLabel:"{y}",
		showInLegend: true,
		dataPoints: <?php echo json_encode($assault, JSON_NUMERIC_CHECK); ?>
	},{
		type: "column",
		name: "Battery",
    indexLabel:"{y}",
		showInLegend: true,
		dataPoints: <?php echo json_encode($battery, JSON_NUMERIC_CHECK); ?>
	},{
		type: "column",
		name: "Criminal Damage",
    indexLabel:"{y}",
		showInLegend: true,
		dataPoints: <?php echo json_encode($cDmage, JSON_NUMERIC_CHECK); ?>
	},{
		type: "column",
		name: "Deceptive Pratice",
    indexLabel:"{y}",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dPractice, JSON_NUMERIC_CHECK); ?>
	},{
		type: "column",
		name: "Theft",
    indexLabel:"{y}",
		showInLegend: true,
		dataPoints: <?php echo json_encode($theft, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}

}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<h2>Conclusion</h2>
From the above Bar Graph, we can observe that Theft has been the highest contributor to the total number of
crimes in Chicago over the years consistently followed by Battery. This drastically changes in the year 2020
when the world was hit by the COVID pandemic. Cases of theft dropped the most as compared to the previous numbers.
Though the cases of Battery dropped as well, they managed to surpass the cases of theft. Even though cases of all
kinds of crimes dropped, Asssaults, Criminal Damange and Deceptive practice were least affected. The drop in theft
can be associated to more people staying indoors and thus giving a less chance for the robbers to commit theft. 
<br><br>
</body>
<div align="center">
<form method="get" action="homePage.php">
    <button type="submit">HomePage</button>
</form>
</div>
</html>
