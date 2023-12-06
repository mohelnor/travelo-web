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

$maxRows_seats = 10;
$pageNum_seats = 0;
if (isset($_GET['pageNum_seats'])) {
  $pageNum_seats = $_GET['pageNum_seats'];
}
$startRow_seats = $pageNum_seats * $maxRows_seats;

$colname_seats = "-1";
$query_seats = "SELECT * FROM seats";

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query_seats .= " WHERE id = $id";
}

if (isset($_GET['bus'])) {
  $colname_seats = $_GET['bus'];
  $query_seats = sprintf("SELECT * FROM seats WHERE bus = %s", GetSQLValueString($colname_seats, "int"));
}

$query_limit_seats = sprintf("%s LIMIT %d, %d", $query_seats, $startRow_seats, $maxRows_seats);
$seats = mysql_query($query_limit_seats, $travelo) or die(mysql_error());
$row_seats = mysql_fetch_assoc($seats);

if (isset($_GET['totalRows_seats'])) {
  $totalRows_seats = $_GET['totalRows_seats'];
} else {
  $all_seats = mysql_query($query_seats);
  $totalRows_seats = mysql_num_rows($all_seats);
}
$totalPages_seats = ceil($totalRows_seats/$maxRows_seats)-1;


$queryString_seats = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_seats") == false && 
        stristr($param, "totalRows_seats") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_seats = "&" . htmlentities(implode("&", $newParams));
  }
}

$queryString_seats = sprintf("&totalRows_seats=%d%s", $totalRows_seats, $queryString_seats);

?>
  <?php
  require_once('../sidenav.php');
  ?>
<h2>المقاعد</h2>
<a href="add.php" class="mt-2 btn btn-primary">إضافة</a><hr>

<table class="table table-bordered table-responsive mt-2">
  <tr>
    <td>#</td>
    <td>المقعد</td>
    <td>البصات</td>
    <td>محجوز</td>
    <td>التاريخ</td>
    <td>إجراء</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_seats['id']; ?></td>
      <td><?php echo $row_seats['seat']; ?></td>
      <td><a href="../bus/index.php?id=<?php echo $row_seats['bus']; ?>"><?php echo $row_seats['bus']; ?></a></td>
      <td><?php echo $row_seats['taken']; ?></td>
      <td><?php echo $row_seats['date']; ?></td>
      
        <td><a href="/travelo/seats/edit.php?id=<?php echo $row_seats['id']; ?>"><i class="fas fa-edit fa-fw me-3 text-info"></i></a>  | <a href="/travelo/seats/delete.php?id=<?php echo $row_seats['id']; ?>"> <i class="fas fa-trash fa-fw me-3 text-danger"></i></a></td> 
    </tr>
    <?php } while ($row_seats = mysql_fetch_assoc($seats)); ?>
</table>
<table border="0">
  <tr>
    <td><?php if ($pageNum_seats > 0) { // Show if not first page ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_seats=%d%s", $currentPage, 0, $queryString_seats); ?>">الأول</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_seats > 0) { // Show if not first page ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_seats=%d%s", $currentPage, max(0, $pageNum_seats - 1), $queryString_seats); ?>">السابق</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_seats < $totalPages_seats) { // Show if not last page ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_seats=%d%s", $currentPage, min($totalPages_seats, $pageNum_seats + 1), $queryString_seats); ?>">اللاحق</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_seats < $totalPages_seats) { // Show if not last page ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_seats=%d%s", $currentPage, $totalPages_seats, $queryString_seats); ?>">اخر سجل</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
        </div>
    </main>
    <!--Main layout-->
    <!-- End your project here-->
</body>

</html>
<?php
mysql_free_result($seats);
?>
