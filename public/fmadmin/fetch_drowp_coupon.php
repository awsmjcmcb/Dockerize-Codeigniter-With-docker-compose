
<?php
    include("includes/header.php");
	require("includes/function.php");
	require("language/language.php");


$sql="SELECT * FROM tbl_scratch_coupons id='54'";

$result = mysqli_query($mysqli,$sql);

echo "<table border='1' style='width:1000'>
<tr>
<th>id</th>
<th>title</th>
<th>amount</th>

</tr>";

$row = mysql_fetch_array($result); 
  echo "<tr>";
  echo "<td>" . $row['id'] . "</td>";
   echo "<td>" . $row['title'] . "</td>";
    echo "<td>" . $row['amount'] . "</td>";

  echo "</tr>";

echo "</table>";
?>