<?php
include 'Connections/travelo.php';
// Start the session
session_start();

if (isset($_POST['login'])) {

  $name = $_POST['name'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM `users` WHERE user = '$name' AND password = $password";
  $result = mysql_query($sql, $travelo) or die(mysql_error());

  if (mysql_num_rows($result)) {
    //  get user info .......
    $row = mysql_fetch_assoc($result);
    $_SESSION['user'] = $row;
    header('Location: dashboard.php');
  } else {
    echo "<script>
alert('الحساب غير متاح');
</script>";
  }
}
?>

<!doctype html>
<html dir='rtl' lang="ar">

<head>
  <meta charset="utf-8">
  <title>travelo</title>
  <link rel="stylesheet" href="./assets/css/mdb.rtl.min.css">
</head>

<body class="bg-info">


  <div class="card w-25 mx-auto bg-light mt-5 pt-5 d-flex justify-content-center">
    <form class="card-body form" action="index.php" method="POST" name="loginForm">
      <img src="assets/img/logo.png" class="w-100 h-100">
      <div class="form-group">

        <label class="control-label" for="name">الاسم</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">

      </div>
      <div class="form-group">

        <label class="control-label" for="pwd">كلمة السر</label>
        <input name="password" type="password" class="form-control" id="pwd" placeholder="Enter password">
      </div>

      <div class="form-group">
        <button name="login" type="submit" value="login" class="btn btn-info w-100 my-3">Submit</button>

      </div>
    </form>

  </div>
</body>

</html>