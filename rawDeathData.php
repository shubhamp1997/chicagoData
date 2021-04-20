<?php
$nis = "hesun";
$password= "092700Jimmy";
$que = "SELECT * FROM \"G.AGRAWAL\".\"COVID_DEATHS\"";
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
<h2>Raw Death Data</h2>
<div align="left">
<form method="get" action="homePage.php">
    <button type="submit">HomePage</button>
</form>
</div>
<?php
$result=oci_parse($conn,$que);
oci_execute($result);
echo "Covid_ID&nbsp&nbsp&nbsp Covid_Date &nbsp&nbsp&nbsp Deaths Total&nbsp&nbsp&nbsp
      Age 0-17&nbsp&nbsp Age 18-29&nbsp&nbsp&nbsp Age 30-39&nbsp&nbsp&nbsp&nbsp
      Age 40-49&nbsp&nbsp  Age 50-59&nbsp&nbsp&nbsp  Age 60-69&nbsp&nbsp&nbsp
      Age 70-79&nbsp&nbsp   Age 80-100&nbsp&nbsp&nbsp   Deaths_A_U&nbsp&nbsp&nbsp&nbsp
      Deaths_F&nbsp&nbsp&nbsp     Deaths_M&nbsp&nbsp&nbsp     Deaths_G_U&nbsp&nbsp&nbsp
      D_ID<br>  \n";
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
