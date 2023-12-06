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

$maxRows_cities = 10;
$pageNum_cities = 0;
if (isset($_GET['pageNum_cities'])) {
  $pageNum_cities = $_GET['pageNum_cities'];
}
$startRow_cities = $pageNum_cities * $maxRows_cities;


$query_cities = "SELECT * FROM cities";
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query_cities .= " WHERE id = $id";
}
$query_limit_cities = sprintf("%s LIMIT %d, %d", $query_cities, $startRow_cities, $maxRows_cities);
$cities = mysql_query($query_limit_cities, $travelo) or die(mysql_error());
$row_cities = mysql_fetch_assoc($cities);

if (isset($_GET['totalRows_cities'])) {
  $totalRows_cities = $_GET['totalRows_cities'];
} else {
  $all_cities = mysql_query($query_cities);
  $totalRows_cities = mysql_num_rows($all_cities);
}
$totalPages_cities = ceil($totalRows_cities/$maxRows_cities)-1;

$queryString_cities = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_cities") == false && 
        stristr($param, "totalRows_cities") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_cities = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_cities = sprintf("&totalRows_cities=%d%s", $totalRows_cities, $queryString_cities);
?>
  <?php
  require_once('../sidenav.php');
  ?>
<h2>المدن</h2>
<a href="add.php" class="mt-2 btn btn-primary">إضافة</a>
<hr>
<table class="table table-bordered table-responsive mt-2">
  <tr>
    <td>#</td>
    <td>الاسم</td>
    <td>التفاصيل</td>
    <td>إجراء</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_cities['id']; ?></td>
      <td><?php echo $row_cities['name']; ?></td>
      <td><?php echo $row_cities['details']; ?></td>
      <td><a href="edit.php?id=<?php echo $row_cities['id']; ?>"><i class="fas fa-edit fa-fw me-3 text-info"></i></a>  | <a href="delete.php?id=<?php echo $row_cities['id']; ?>">  <i class="fas fa-trash fa-fw me-3 text-danger"></i></a></td> 
    </tr>
    <?php } while ($row_cities = mysql_fetch_assoc($cities)); ?>
</table>
<table border="0">
  <tr>
    <td><?php if ($pageNum_cities > 0) { // Show if not first page ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_cities=%d%s", $currentPage, 0, $queryString_cities); ?>">الأول</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_cities > 0) { // Show if not first page ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_cities=%d%s", $currentPage, max(0, $pageNum_cities - 1), $queryString_cities); ?>">السابق</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_cities < $totalPages_cities) { // Show if not last page ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_cities=%d%s", $currentPage, min($totalPages_cities, $pageNum_cities + 1), $queryString_cities); ?>">اللاحق</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_cities < $totalPages_cities) { // Show if not last page ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_cities=%d%s", $currentPage, $totalPages_cities, $queryString_cities); ?>">اخر سجل</a>
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
mysql_free_result($cities);
?>
