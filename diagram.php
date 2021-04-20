<html>
<picture align="center">
    <img src="diagram.png" height="600" width="900">
</picture>

<div class="form" align="center">
  Total Labor Tuples:
  <?php
  $nis = "hesun";
  $password= "092700Jimmy";
  $que = "SELECT COUNT(*) AS \"TOTAL LABOR DATA\" FROM \"G.AGRAWAL\".\"LABOR_DATA\"";
  $conn=oci_connect($nis,$password,
  'oracle.cise.ufl.edu:1521/orcl');
  if(empty($nis) or empty($password)){
      echo "UserID atau Password is empty<br>\n";}

  if(!$conn){
      echo 'connection error';
  }
  $result=oci_parse($conn,$que);
  oci_execute($result);
  while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
      echo $row[0];
  }
  ?>
</div>

  <div class="form" align="center">
    Total Crime Tuples:
    <?php
    $nis = "hesun";
    $password= "092700Jimmy";
    $que = "SELECT COUNT(*) AS \"TOTAL CRIME DATA\" FROM \"G.AGRAWAL\".\"CRIME\"";
    $conn=oci_connect($nis,$password,
    'oracle.cise.ufl.edu:1521/orcl');
    if(empty($nis) or empty($password)){
        echo "UserID atau Password is empty<br>\n";}

    if(!$conn){
        echo 'connection error';
    }
    $result=oci_parse($conn,$que);
    oci_execute($result);
    while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
        echo $row[0];
    }
    ?>
  </div>
  <div class="form" align="center">
    Total Covid Tuples:
    <?php
    $nis = "hesun";
    $password= "092700Jimmy";
    $que = "SELECT COUNT(*) AS \"TOTAL COVID DATA\" FROM \"G.AGRAWAL\".\"COVID_CASES\"";
    $conn=oci_connect($nis,$password,
    'oracle.cise.ufl.edu:1521/orcl');
    if(empty($nis) or empty($password)){
        echo "UserID atau Password is empty<br>\n";}

    if(!$conn){
        echo 'connection error';
    }
    $result=oci_parse($conn,$que);
    oci_execute($result);
    while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
        echo $row[0];
    }
    $que = "SELECT COUNT(*) FROM \"G.AGRAWAL\".\"HAPPENS_AT\"";
    $result=oci_parse($conn,$que);
    oci_execute($result);
    echo "<br>\nTotal Tuples in happens_at table: ";
    while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
        echo $row[0];
    }
    $que = "SELECT COUNT(*) FROM \"G.AGRAWAL\".\"ARCHIVE\"";
    $result=oci_parse($conn,$que);
    oci_execute($result);
    echo "<br>\nTotal Tuples in archive table: ";
    while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
        echo $row[0];
    }
    $que = "SELECT COUNT(*) FROM \"G.AGRAWAL\".\"DATEVALUES\"";
    $result=oci_parse($conn,$que);
    oci_execute($result);
    echo "<br>\nTotal Tuples in datevalues table: ";
    while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
        echo $row[0];
    }
    ?>
  </div>
  <div align="center">
  <form method="get" action="homePage.php">
      <button type="submit">HomePage</button>
  </form>
  </div>
</html>
