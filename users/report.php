<?php
require_once('../Connections/travelo.php');
// Start the session
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
  header('Location: /travelo/');
}

$currentPage = $_SERVER["PHP_SELF"];

$query_users = "SELECT * FROM users";
if (isset($_GET['role'])) {
  $role = $_GET['role'];
  $query_users .= " WHERE role = $role";
}

if (isset($_GET['order'])) {
  $order = $_GET['order'];
  $query_users .= " ORDER BY created DESC";
}
$users = mysql_query($query_users, $travelo) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);

?>
<?php
require_once('../sidenav.php');
?>
<div class="d-print-none">
  <a href="report.php" class="mt-2 btn btn-warning">الكل</a>
  <a href="?role='admin'" class="mt-2 btn btn-primary">المدير</a>
  <a href="?role='client'" class="mt-2 btn btn-info">الزبائن</a>
  <a href="?order=DESC" class="mt-2 btn btn-danger">تاريخ الأضافة</a>
  <a href="#" onClick="print()" class="mt-2 btn btn-dark">طباعة</a>
</div>
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
    <td class="d-print-none">تاريخ التسجيل</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_users['id']; ?></td>
      <td><?php echo $row_users['user']; ?></td>
      <td><?php echo $row_users['name']; ?></td>
      <td><?php echo $row_users['password']; ?></td>
      <td><?php echo $row_users['phone']; ?></td>
      <td><?php echo $row_users['address']; ?></td>
      <td><?php echo $row_users['city']; ?></td>
      <td><?php echo $row_users['role']; ?></td>
      <td><?php echo $row_users['created']; ?></td>
      <td class="d-print-none">
        <a href="../bookings/report.php?user=<?php echo $row_users['id']; ?>">
          قائمة الحجوزات
        </a>
      </td>
    </tr>
  <?php } while ($row_users = mysql_fetch_assoc($users)); ?>
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