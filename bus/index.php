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

$maxRows_bus = 10;
$pageNum_bus = 0;


if (isset($_GET['pageNum_bus'])) {
  $pageNum_bus = $_GET['pageNum_bus'];
}
$startRow_bus = $pageNum_bus * $maxRows_bus;


$query_bus = "SELECT * FROM bus";
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query_bus .= " WHERE id = $id";
}
$query_limit_bus = sprintf("%s LIMIT %d, %d", $query_bus, $startRow_bus, $maxRows_bus);
$bus = mysql_query($query_limit_bus, $travelo) or die(mysql_error());
$row_bus = mysql_fetch_assoc($bus);

if (isset($_GET['totalRows_bus'])) {
  $totalRows_bus = $_GET['totalRows_bus'];
} else {
  $all_bus = mysql_query($query_bus);
  $totalRows_bus = mysql_num_rows($all_bus);
}
$totalPages_bus = ceil($totalRows_bus/$maxRows_bus)-1;

$queryString_bus = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_bus") == false && 
        stristr($param, "totalRows_bus") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_bus = "&" . htmlentities(implode("&", $newParams));
  }
}

$queryString_bus = sprintf("&totalRows_bus=%d%s", $totalRows_bus, $queryString_bus);

require_once('../sidenav.php');
?>

<h2>البصات</h2>
<a href="add.php" class="mt-2 btn btn-primary">إضافة</a>
<hr>
<table class="table table-bordered table-responsive mt-2">
  <tr>
    <td>#</td>
    <td>الاسم</td>
    <td>اللوحات</td>
    <td>المقاعد</td>
    <td>سعر التزكرة</td>
    <td> الرحلة</td>
    <td>محجوز</td>
    <td>التاريخ</td>
    <td>التفاصيل</td>
    <td>الشركات</td>
    <td>إجراء</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_bus['id']; ?></td>
      <td><?php echo $row_bus['name']; ?></td>
      <td><?php echo $row_bus['plate']; ?></td>
      <td><a href="../seats/index.php?bus=<?php echo $row_bus['id']; ?>"><?php echo $row_bus['seats']; ?></a></td>
      <td><?php echo $row_bus['ticketPrice']; ?></td>
      <td><a href="../trips/index.php?id=<?php echo $row_bus['trip']; ?>"><?php echo $row_bus['trip']; ?></a></td>
      <td><?php echo $row_bus['status']; ?></td>
      <td><?php echo $row_bus['date']; ?></td>
      <td><?php echo $row_bus['details']; ?></td>
      <td><a href="../company/index.php?id=<?php echo $row_bus['company']; ?>"><?php echo $row_bus['company']; ?></a></td>
      <td><a href="edit.php?id=<?php echo $row_bus['id']; ?>"><i class="fas fa-edit fa-fw me-3 text-info"></i></a>  | <a href="delete.php?id=<?php echo $row_bus['id']; ?>">  <i class="fas fa-trash fa-fw me-3 text-danger"></i></a></td> 
    </tr>
    <?php } while ($row_bus = mysql_fetch_assoc($bus)); ?>
</table>
<table border="0">
  <tr>
    <td><?php if ($pageNum_bus > 0) { // Show if not first page ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_bus=%d%s", $currentPage, 0, $queryString_bus); ?>">الأول</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_bus > 0) { // Show if not first page ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_bus=%d%s", $currentPage, max(0, $pageNum_bus - 1), $queryString_bus); ?>">السابق</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_bus < $totalPages_bus) { // Show if not last page ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_bus=%d%s", $currentPage, min($totalPages_bus, $pageNum_bus + 1), $queryString_bus); ?>">اللاحق</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_bus < $totalPages_bus) { // Show if not last page ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_bus=%d%s", $currentPage, $totalPages_bus, $queryString_bus); ?>">اخر سجل</a>
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
mysql_free_result($bus);
?>
