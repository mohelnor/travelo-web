<?php require_once('../Connections/travelo.php');
// Start the session
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: /travelo/');
}
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_bookings = 5;
$pageNum_bookings = 0;
if (isset($_GET['pageNum_bookings'])) {
  $pageNum_bookings = $_GET['pageNum_bookings'];
}
$startRow_bookings = $pageNum_bookings * $maxRows_bookings;


$query_bookings = "SELECT * FROM bookings";
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query_bookings .= " WHERE id = $id";
}
$query_limit_bookings = sprintf("%s LIMIT %d, %d", $query_bookings, $startRow_bookings, $maxRows_bookings);
$bookings = mysql_query($query_limit_bookings, $travelo) or die(mysql_error());
$row_bookings = mysql_fetch_assoc($bookings);

if (isset($_GET['totalRows_bookings'])) {
  $totalRows_bookings = $_GET['totalRows_bookings'];
} else {
  $all_bookings = mysql_query($query_bookings);
  $totalRows_bookings = mysql_num_rows($all_bookings);
}
$totalPages_bookings = ceil($totalRows_bookings / $maxRows_bookings) - 1;

$queryString_bookings = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (
      stristr($param, "pageNum_bookings") == false &&
      stristr($param, "totalRows_bookings") == false
    ) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_bookings = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_bookings = sprintf("&totalRows_bookings=%d%s", $totalRows_bookings, $queryString_bookings);
?>
<?php
require_once('../sidenav.php');
?>

<h2>الحجوزات</h2>
<a href="add.php" class="mt-1 btn btn-primary">إضافة</a>
<hr>
<div class="table-responsive">

  <table class="table table-bordered mt-2">
    <tr>
      <td>#</td>
      <td>المستخدم</td>
      <td>الأسم رباعي</td>
      <td>الهاتف</td>
      <td>الرحلات</td>
      <td>البصات</td>
      <td>المقعد</td>
      <td>الأمتعة</td>
      <td>السعر</td>
      <td>الموقغ</td>
      <td>التوقيت</td>
      <td>تاريخ التسجيل</td>
       <td>إجراء</td>
    </tr>
    <?php if ($totalRows_bookings > 0) { // Show if recordset not empty 
  ?>
    <?php do { ?>
      <tr class=" <?php
        if ($row_bookings['payed'] == 1) {
          echo 'bg-success text-white';
        }
        ?>">
        <td><?php echo $row_bookings['id']; ?></td>
        <td><a href="../users/index.php?id=<?php echo $row_bookings['user']; ?>"><?php echo $row_bookings['user']; ?></a></td>
        <td><?php echo $row_bookings['fullname']; ?></td>
        <td><?php echo $row_bookings['phone']; ?></td>
        <td><a href="../trips/index.php?id=<?php echo $row_bookings['trip']; ?>"><?php echo $row_bookings['trip']; ?></a></td>
        <td><a href="../bus/?id=<?php echo $row_bookings['bus']; ?>"><?php echo $row_bookings['bus']; ?></a></td>
        <td><a href="../seats/index.php?id=<?php echo $row_bookings['seat']; ?>"><?php echo $row_bookings['seat']; ?></a></td>
        <td><?php echo $row_bookings['luggage']; ?></td>
        <td><?php echo $row_bookings['price']; ?></td>
        <td><a href="../citys/index.php?id=<?php echo $row_bookings['location']; ?>"><?php echo $row_bookings['location']; ?></a></td>
        <td><?php echo $row_bookings['due']; ?></td>
        <td><?php echo $row_bookings['created']; ?></td>
        <td><a href="edit.php?id=<?php echo $row_bookings['id']; ?>"><i class="fas fa-edit fa-fw me-3 text-info"></i></a> | <a href="delete.php?id=<?php echo $row_bookings['id']; ?>"> <i class="fas fa-trash fa-fw me-3 text-danger"></i></a></td>
      </tr>
    <?php } while ($row_bookings = mysql_fetch_assoc($bookings)); ?>
  <?php } // Show if recordset not empty 
  ?>
</table>
</div>
<table border="0">
  <tr>
    <td><?php if ($pageNum_bookings > 0) { // Show if not first page 
        ?>
        <a class="btn mx-1" href="<?php printf("%s?pageNum_bookings=%d%s", $currentPage, 0, $queryString_bookings); ?>">الأول</a>
        <?php } // Show if not first page 
      ?>
    </td>
    <td><?php if ($pageNum_bookings > 0) { // Show if not first page 
        ?>
        <a class="btn mx-1" href="<?php printf("%s?pageNum_bookings=%d%s", $currentPage, max(0, $pageNum_bookings - 1), $queryString_bookings); ?>">السابق</a>
      <?php } // Show if not first page 
      ?>
    </td>
    <td><?php if ($pageNum_bookings < $totalPages_bookings) { // Show if not last page 
        ?>
        <a class="btn mx-1" href="<?php printf("%s?pageNum_bookings=%d%s", $currentPage, min($totalPages_bookings, $pageNum_bookings + 1), $queryString_bookings); ?>">اللاحق</a>
      <?php } // Show if not last page 
      ?>
    </td>
    <td><?php if ($pageNum_bookings < $totalPages_bookings) { // Show if not last page 
        ?>
        <a class="btn mx-1" href="<?php printf("%s?pageNum_bookings=%d%s", $currentPage, $totalPages_bookings, $queryString_bookings); ?>">اخر سجل</a>
      <?php } // Show if not last page 
      ?>
    </td>
  </tr>
</table>
</div>
</main>
<!--Main layout-->
<!-- End your project here-->
</body>

</html>
<?php
mysql_free_result($bookings);
?>