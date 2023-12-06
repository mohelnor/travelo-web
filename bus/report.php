<?php virtual('/travelo/Connections/travelo.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$query_bus = "SELECT * FROM bus";
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query_bus = sprintf("SELECT * FROM bus WHERE id = %s", GetSQLValueString($id, "int"));
}

if (isset($_GET['trip'])) {
  $trip = $_GET['trip'];
  $query_bus = sprintf("SELECT * FROM bus WHERE trip = %s", GetSQLValueString($trip, "int"));
}

$bus = mysql_query($query_bus, $travelo) or die(mysql_error());
$row_bus = mysql_fetch_assoc($bus);
$totalRows_bus = mysql_num_rows($bus);

require_once('../sidenav.php');
?>

<div class="d-print-none">

  <a href="report.php" class="mx-2 btn btn-warning">الكل</a>
  <a href="#" onClick="print()" class="mt-2 btn btn-dark">طباعة</a>
</div>
<table class="table table-bordered table-responsive mt-2">
  <tr>
    <td>#</td>
    <td>الاسم</td>
    <td>اللوحات</td>
    <td> الرحلة</td>
    <td>المقاعد</td>
    <td>سعر التزكرة</td>
    <td>مقاعد محجوزة</td>
    <td>التاريخ</td>
    <td>التفاصيل</td>
    <td>الشركات</td>
    </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_bus['id']; ?></td>
      <td><?php echo $row_bus['name']; ?></td>
      <td><?php echo $row_bus['plate']; ?></td>
      <td><a href="../trips/report.php?id=<?php echo $row_bus['trip']; ?>"><?php echo $row_bus['trip']; ?></a></td>
      <td><a href="../seats/report.php?bus=<?php echo $row_bus['id']; ?>"><?php echo $row_bus['seats']; ?></a></td>
      <td><?php echo $row_bus['ticketPrice']; ?></td>
      <td><?php echo $row_bus['status']; ?></td>
      <td><?php echo $row_bus['date']; ?></td>
      <td><?php echo $row_bus['details']; ?></td>
      <td><?php echo $row_bus['company']; ?></td>
    </tr>
    <?php } while ($row_bus = mysql_fetch_assoc($bus)); ?>
</table>
        </div>
    </main>
    <!--Main layout-->
    <!-- End your project here-->
</body>

</html>
<?php
mysql_free_result($bus);
?>
