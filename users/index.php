<?php
require_once('../Connections/travelo.php');
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

$maxRows_users = 10;
$pageNum_users = 0;
if (isset($_GET['pageNum_users'])) {
  $pageNum_users = $_GET['pageNum_users'];
}
$startRow_users = $pageNum_users * $maxRows_users;


$query_users = "SELECT * FROM users";
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query_users .= " WHERE id = $id ";
}
$query_limit_users = sprintf("%s LIMIT %d, %d", $query_users, $startRow_users, $maxRows_users);
$users = mysql_query($query_limit_users, $travelo) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);

if (isset($_GET['totalRows_users'])) {
  $totalRows_users = $_GET['totalRows_users'];
} else {
  $all_users = mysql_query($query_users);
  $totalRows_users = mysql_num_rows($all_users);
}
$totalPages_users = ceil($totalRows_users / $maxRows_users) - 1;

$queryString_users = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (
      stristr($param, "pageNum_users") == false &&
      stristr($param, "totalRows_users") == false
    ) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_users = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_users = sprintf("&totalRows_users=%d%s", $totalRows_users, $queryString_users);
?>
<?php
require_once('../sidenav.php');
?>
<h2>المستخدمين</h2>
<a href="add.php" class="mt-2 btn btn-primary">إضافة</a>
<hr>
<table class="table table-bordered table-responsive mt-2">
  <tr>
    <td>#</td>
    <td>المستخدم</td>
    <td>الاسم</td>
    <td>كلمة المرور</td>
    <td>الهاتف</td>
    <td>العنوان</td>
    <td>المدينة</td>
    <td>الصلاحية</td>
    <td>تاريخ التسجيل</td>
    <td>إجراء</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_users['id']; ?></td>
      <td><?php echo $row_users['user']; ?></td>
      <td><?php echo $row_users['name']; ?></td>
      <td><?php echo $row_users['password']; ?></td>
      <td><?php echo $row_users['phone']; ?></td>
      <td><?php echo $row_users['address']; ?></td>
      <td><a href="../citys/index.php?id=<?php echo $row_users['city']; ?>"><?php echo $row_users['city']; ?></a></td>
      <td><?php echo $row_users['role']; ?></td>
      <td><?php echo $row_users['created']; ?></td>
      <td><a href="/travelo/users/edit.php?id=<?php echo $row_users['id']; ?>"><i class="fas fa-edit fa-fw me-3 text-info"></i></a> | <a href="/travelo/users/delete.php?id=<?php echo $row_users['id']; ?>"> <i class="fas fa-trash fa-fw me-3 text-danger"></i></a></td> 
    </tr>
  <?php } while ($row_users = mysql_fetch_assoc($users)); ?>
</table>
<table border="0">
  <tr>
    <td><?php if ($pageNum_users > 0) { // Show if not first page 
        ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_users=%d%s", $currentPage, 0, $queryString_users); ?>">الأول</a>
      <?php } // Show if not first page 
      ?>
    </td>
    <td><?php if ($pageNum_users > 0) { // Show if not first page 
        ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_users=%d%s", $currentPage, max(0, $pageNum_users - 1), $queryString_users); ?>">السابق</a>
      <?php } // Show if not first page 
      ?>
    </td>
    <td><?php if ($pageNum_users < $totalPages_users) { // Show if not last page 
        ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_users=%d%s", $currentPage, min($totalPages_users, $pageNum_users + 1), $queryString_users); ?>">اللاحق</a>
      <?php } // Show if not last page 
      ?>
    </td>
    <td><?php if ($pageNum_users < $totalPages_users) { // Show if not last page 
        ?>
         <a class="btn mx-1" href="<?php printf("%s?pageNum_users=%d%s", $currentPage, $totalPages_users, $queryString_users); ?>">اخر سجل</a>
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
mysql_free_result($users);
?>