<?php require_once('../Connections/travelo.php'); 
// Start the session
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: /travelo/');
}

$query_cities = "SELECT * FROM cities";
$cities = mysql_query($query_cities, $travelo) or die(mysql_error());
$row_cities = mysql_fetch_assoc($cities);

?>
  <?php
  require_once('../sidenav.php');
  ?>

<a href="#" onClick="print()" class="mt-2 btn btn-dark d-print-none">طباعة</a>
<table class="table table-bordered table-responsive mt-2">
  <tr>
    <td>#</td>
    <td>الاسم</td>
    <td>التفاصيل</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_cities['id'];?></td>
      <td><a href="../trips/report.php?city=<?php echo $row_cities['name']; ?>"><?php echo $row_cities['name']; ?></a></td>
      <td><?php echo $row_cities['details']; ?></td>
    </tr>
    <?php } while ($row_cities = mysql_fetch_assoc($cities)); ?>
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
