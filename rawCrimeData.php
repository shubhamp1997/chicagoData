<?php
$nis = "hesun";
$password= "092700Jimmy";
$que = "SELECT * FROM \"G.AGRAWAL\".\"CRIME\"";
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
<h2>Raw Crime Data</h2>
<div align="left">
<form method="get" action="homePage.php">
    <button type="submit">HomePage</button>
</form>
</div>
<?php
$result=oci_parse($conn,$que);
oci_execute($result);
echo "C_ID&nbsp&nbsp Block_Name &nbsp&nbsp C_Date&nbsp&nbsp
      IUCR&nbsp&nbsp Arrest&nbsp&nbsp Community Area&nbsp&nbsp
      Domestic&nbsp&nbsp  Ward&nbsp&nbsp  District&nbsp&nbsp
      Beat&nbsp&nbsp   Location Description<br>  \n";
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
