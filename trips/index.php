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

$maxRows_trips = 10;
$pageNum_trips = 0;
if (isset($_GET['pageNum_trips'])) {
  $pageNum_trips = $_GET['pageNum_trips'];
}
$startRow_trips = $pageNum_trips * $maxRows_trips;


$query_trips = "SELECT * FROM trips";
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query_trips .= " WHERE id = $id";
}
$query_limit_trips = sprintf("%s LIMIT %d, %d", $query_trips, $startRow_trips, $maxRows_trips);
$trips = mysql_query($query_limit_trips, $travelo) or die(mysql_error());
$row_trips = mysql_fetch_assoc($trips);

if (isset($_GET['totalRows_trips'])) {
  $totalRows_trips = $_GET['totalRows_trips'];
} else {
  $all_trips = mysql_query($query_trips);
  $totalRows_trips = mysql_num_rows($all_trips);
}
$totalPages_trips = ceil($totalRows_trips / $maxRows_trips) - 1;

$queryString_trips = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (
      stristr($param, "pageNum_trips") == false &&
      stristr($param, "totalRows_trips") == false
    ) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_trips = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_trips = sprintf("&totalRows_trips=%d%s", $totalRows_trips, $queryString_trips);
?>
<?php
require_once('../sidenav.php');
?>

<h2>الرحلات</h2>
<a href="add.php" class="mt-2 btn btn-primary">إضافة</a>
<hr>
<table class="table table-bordered table-responsive mt-2">
  <tr>
    <td>#</td>
    <td>الموقغ</td>
    <td>الوجهه</td>
    <td>الزمن</td>
    <td>التوقيت</td>
    <td>الشركات</td>
    <td>إجراء</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_trips['id']; ?></td>
      <td><a href="../citys/index.php?id=<?php echo $row_trips['location']; ?>"><?php echo $row_trips['location']; ?></a></td>
      <td><a href="../citys/index.php?id=<?php echo $row_trips['destination']; ?>"><?php echo $row_trips['destination']; ?></a></td>
      <td><?php echo $row_trips['time']; ?></td>
      <td><?php echo $row_trips['due']; ?></td>
      <td><a href="../company/index.php?id=<?php echo $row_trips['company']; ?>"><?php echo $row_trips['company']; ?></a></td>
      <td> <a href="/travelo/trips/edit.php?id=<?php echo $row_trips['id']; ?>"><i class="fas fa-edit fa-fw me-3 text-info"></i></a>  | <a href="/travelo/trips/delete.php?id=<?php echo $row_trips['id']; ?>"> <i class="fas fa-trash fa-fw me-3 text-danger"></i></a></td> 
    </tr>
  <?php } while ($row_trips = mysql_fetch_assoc($trips)); ?>
</table>
<table border="0">
  <tr>
    <td><?php if ($pageNum_trips > 0) { // Show if not first page 
        ?>
        <a class="btn mx-1" href="<?php printf("%s?pageNum_trips=%d%s", $currentPage, 0, $queryString_trips); ?>">الأول</a>
      <?php } // Show if not first page 
      ?>
    </td>
    <td><?php if ($pageNum_trips > 0) { // Show if not first page 
        ?>
        <a class="btn mx-1" href="<?php printf("%s?pageNum_trips=%d%s", $currentPage, max(0, $pageNum_trips - 1), $queryString_trips); ?>">السابق</a>
      <?php } // Show if not first page 
      ?>
    </td>
    <td><?php if ($pageNum_trips < $totalPages_trips) { // Show if not last page 
        ?>
        <a class="btn mx-1" href="<?php printf("%s?pageNum_trips=%d%s", $currentPage, min($totalPages_trips, $pageNum_trips + 1), $queryString_trips); ?>">اللاحق</a>
      <?php } // Show if not last page 
      ?>
    </td>
    <td><?php if ($pageNum_trips < $totalPages_trips) { // Show if not last page 
        ?>
        <a class="btn mx-1" href="<?php printf("%s?pageNum_trips=%d%s", $currentPage, $totalPages_trips, $queryString_trips); ?>">اخر سجل</a>
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
mysql_free_result($trips);
?>