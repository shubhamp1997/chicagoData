<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      $name = "Tom";
      $age=35;
      echo "<h1> Jimmy's site</h1>";
      echo "<hr>";
      echo "There was a man called $name<br>";
      echo "$name's age is $age."
    ?>
    <button>click me</button>

     <form action="site.php" method="get">
       Name: <input type="text" name="name">
       <input type="submit">
     </form>
     <br>
     <?php
      echo $_GET["name"];
      ?>
  </body>
  <?php
  oci_connect("hesun", "092700Jimmy",
  "oracle.cise.ufl.edu:1521/orcl");
  ?>

</html>
