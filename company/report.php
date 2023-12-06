<?php require_once('../Connections/travelo.php'); 
// Start the session
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: /travelo/');
}

$query_company = "SELECT * FROM company";
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query_company .= " WHERE id = $id";
}
$company = mysql_query($query_company, $travelo) or die(mysql_error());
$row_company = mysql_fetch_assoc($company);

?>
<?php
require_once('../sidenav.php');
?>
<a href="#" onClick="print()" class="mt-2 btn btn-dark d-print-none">طباعة</a>
<table class="table table-bordered table-responsive mt-2">
  <tr>
    <td>#</td>
    <td>الاسم</td>
    <td>الهاتف</td>  
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_company['id']; ?></td>
      <td><?php echo $row_company['name']; ?></td>
      <td><?php echo $row_company['phone']; ?></td> </tr>
    <?php } while ($row_company = mysql_fetch_assoc($company)); ?>
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
