
<?php
$nis = "hesun";
$password= "092700Jimmy";
$que = "WITH TOTS(CNT, D_ID) AS
        (SELECT COUNT(C.C_ID), D.D_ID
            FROM \"G.AGRAWAL\".\"CRIME\" C, \"G.AGRAWAL\".\"DATEVALUES\" D, \"G.AGRAWAL\".\"HAPPENS_AT\" H
            WHERE C.C_ID = H.C_ID AND D.D_ID = H.D_ID AND D.D_YEAR>2016 AND D.D_YEAR<2021
            GROUP BY D.D_ID),

    GCASES(CNT, D_ID) AS
        (SELECT COUNT(C.C_ID), D.D_ID
            FROM \"G.AGRAWAL\".\"CRIME\" C, \"G.AGRAWAL\".\"DATEVALUES\" D, \"G.AGRAWAL\".\"HAPPENS_AT\" H, \"G.AGRAWAL\".\"ARCHIVE\" A
            WHERE C.C_ID = H.C_ID AND D.D_ID = H.D_ID AND C.IUCR = A.IUCR AND D.D_YEAR>2016 AND D.D_YEAR<2021
                AND (A.A_DESCRIPTION LIKE '%FIREARM%' OR A.A_DESCRIPTION LIKE '%HANDGUN%'
                    OR A.A_DESCRIPTION LIKE '%AMMUNITION%' OR A.A_DESCRIPTION LIKE '%BULLET%'
                    OR A.A_DESCRIPTION LIKE '%ARMED%' OR A.PRIMARY_TYPE LIKE '%WEAPONS%')
            GROUP BY D.D_ID)

SELECT TOTS.CNT AS \"TOTAL CASES\", GCASES.CNT AS \"GUN RELATED CASES\",
    ROUND((GCASES.CNT/TOTS.CNT)*100,2) AS \"GUN RELATED CRIME RATE\", D.D_ID, D.D_MONTH, D.D_YEAR
    FROM \"G.AGRAWAL\".\"DATEVALUES\" D, GCASES, TOTS
    WHERE GCASES.D_ID = TOTS.D_ID AND TOTS.D_ID = D.D_ID
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
$gun=array();
$rate=array();
$total=array();
while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
    $temp=$row[5] . $row[4];
    $arrayName = array("label" =>"$temp" ,"y"=>$row[0]);
    $arrayName1 = array("label" =>"$temp" ,"y"=>$row[1]);
    $arrayName2 = array("label" =>"$temp" ,"y"=>$row[2]);
    array_push($total,$arrayName);
    array_push($gun,$arrayName1);
    array_push($rate,$arrayName2);
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
		text: "Gun Related Crime Cases"
	},
  axisX:{
    title: "Year/Month"
  }
  ,
	axisY: {
		title: "Cases",
    titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
  axisY2:{
    title:"Rate",
    titleFontColor: "#9ACD32",
		lineColor: "#9ACD32",
		labelFontColor: "#9ACD32",
		tickColor: "#9ACD32"
  },
	data: [{
		type: "line",
    name:"total cases",
    markerSize:0,
		showInLegend: true,
		dataPoints: <?php echo json_encode($total, JSON_NUMERIC_CHECK); ?>
	},{
    type: "line",
    name:"gun cases",
		markerSize: 0,
		showInLegend: true,
		dataPoints: <?php echo json_encode($gun, JSON_NUMERIC_CHECK); ?>
  },{
    type: "line",
    name:"gun related crime rate",
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
<div id="chartContainer"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<h2>Conclusion</h2>
As can be seen in the above graph, the number of gun related crime cases were consistent over the years
tho they increased after the start of pandemic. The gun related crime rate can be seen decreasing during
the holiday season every year just like the total number of cases does. Tho the gun related crime rate is
seen decreasing over the years, it suddenly shot up when the pandemic hit in 2020. One reason for this is
because crimes like theft decreased and so the crime rate for gun related incidents increased. Another major 
fact for this is that instead of decreasing like all other crimes did during the pandemic, these cases remained
the same and even increased a bit.
<br><br>
</body>
<div align="center">
<form method="get" action="homePage.php">
    <button type="submit">HomePage</button>
</form>
</div>
</html>
