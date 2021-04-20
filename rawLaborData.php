<?php
$nis = "hesun";
$password= "092700Jimmy";
$que = "SELECT * FROM \"G.AGRAWAL\".\"LABOR_DATA\"";
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
<h2>Raw Labor Data</h2>
<div align="left">
<form method="get" action="homePage.php">
    <button type="submit">HomePage</button>
</form>
</div>
<?php
$result=oci_parse($conn,$que);
oci_execute($result);
echo "Labor ID &nbsp&nbsp&nbsp&nbsp&nbsp Unemployment&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
      Labor Force&nbsp&nbsp&nbsp&nbsp&nbsp Employment&nbsp&nbsp&nbsp&nbsp&nbsp Unemployment Rate&nbsp&nbsp&nbsp&nbsp&nbsp D_ID<br>\n";
while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
  $j=0;
  while($j<count($row)){
      echo $row[$j] ."&nbsp&nbsp&nbsp&nbsp&nbsp";
      $j++;
  }
  echo "<br>\n";
}
oci_free_statement($result);
oci_close($conn);
?>
</body>
</html>
