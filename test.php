<?php
$conn=oci_connect('hesun','092700Jimmy',
'oracle.cise.ufl.edu:1521/orcl');
if(!$conn){
    echo 'connection error';
}else{
    echo 'connection successful';
}
?>
<html>
<body>
<h2>Test result</h2>
<?php
$result=oci_parse($conn,"select country.name, capital from country 
join city on country.capital=city.name where latitude>0 and city.population<10000");
oci_execute($result);
$i=1;
while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
    // Use the uppercase column names for the associative array indices
    $j=0;
    echo $i.". ";
    while($j<count($row)){
        echo $row[$j] ." ";
        $j++;
    }
    echo "<br>\n";
    $i++;
}
?>
</body>
</html>