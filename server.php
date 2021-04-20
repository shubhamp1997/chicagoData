
<?php
$nis = isset($_POST['nis']) == true ? $_POST['nis'] : '';
$password= isset($_POST['password']) == true ? $_POST['password'] : '';
$que = isset($_POST['que']) == true ? $_POST['que'] : '';
$conn=oci_connect($nis,$password,
'oracle.cise.ufl.edu:1521/orcl');
if(empty($nis) or empty($password)){
    echo "UserID atau Password is empty<br>\n";}

if(!$conn){
    echo 'connection error';
}else{
    //echo 'connection successful';
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
    // Use the uppercase column names for the associative array indices
    //$j=0;
    //echo $i.". ";
    //while($j<count($row)){
    //    echo $row[$j] ." ";
    //    $j++;
    //}
    $temp=$row[1] . $row[2];
    $arrayName = array("label" =>"$temp" ,"y"=>$row[0]);
    array_push($data,$arrayName);
    //echo "<br>\n";
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
		text: "Labor Data Monthly"
	},
	axisY:{
		includeZero: true,
    title:"population"
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
</body>
<form method="get" action="project.php">
    <button type="submit">HomePage</button>
</form>
</html>
