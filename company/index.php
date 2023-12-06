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

$maxRows_company = 10;
$pageNum_company = 0;
if (isset($_GET['pageNum_company'])) {
  $pageNum_company = $_GET['pageNum_company'];
}
$startRow_company = $pageNum_company * $maxRows_company;


$query_company = "SELECT * FROM company";
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query_company .= " WHERE id = $id";
}
$query_limit_company = sprintf("%s LIMIT %d, %d", $query_company, $startRow_company, $maxRows_company);
$company = mysql_query($query_limit_company, $travelo) or die(mysql_error());
$row_company = mysql_fetch_assoc($company);

if (isset($_GET['totalRows_company'])) {
  $totalRows_company = $_GET['totalRows_company'];
} else {
  $all_company = mysql_query($query_company);
  $totalRows_company = mysql_num_rows($all_company);
}
$totalPages_company = ceil($totalRows_company/$maxRows_company)-1;

$queryString_company = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_company") == false && 
        stristr($param, "totalRows_company") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_company = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_company = sprintf("&totalRows_company=%d%s", $totalRows_company, $queryString_company);
?>
  <?php
  require_once('../sidenav.php');
  ?>

<h2>الشركات</h2>
<a href="add.php" class="mt-2 btn btn-primary">إضافة</a>
<hr>
<table class="table table-bordered table-responsive mt-2">
  <tr>
    <td>#</td>
    <td>الاسم</td>
    <td>الهاتف</td>  
     <td>إجراء</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_company['id']; ?></td>
      <td><?php echo $row_company['name']; ?></td>
      <td><?php echo $row_company['phone']; ?></td>
       <td><a href="edit.php?id=<?php echo $row_company['id']; ?>"> <i class="fas fa-edit fa-fw me-3 text-info"></i></a> | <a href="delete.php?id=<?php echo $row_company['id']; ?>"> <i class="fas fa-trash fa-fw me-3 text-danger"></i></a></td> 
    </tr>
    <?php } while ($row_company = mysql_fetch_assoc($company)); ?>
</table>
<table border="0">
  <tr>
    <td><?php if ($pageNum_company > 0) { // Show if not first page ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_company=%d%s", $currentPage, 0, $queryString_company); ?>">الأول</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_company > 0) { // Show if not first page ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_company=%d%s", $currentPage, max(0, $pageNum_company - 1), $queryString_company); ?>">السابق</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_company < $totalPages_company) { // Show if not last page ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_company=%d%s", $currentPage, min($totalPages_company, $pageNum_company + 1), $queryString_company); ?>">اللاحق</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_company < $totalPages_company) { // Show if not last page ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_company=%d%s", $currentPage, $totalPages_company, $queryString_company); ?>">اخر سجل</a>
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
mysql_free_result($company);
?>
