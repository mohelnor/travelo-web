<?php
//include Conn
require '../db.php';
require '../mysql/index.php';
require '../functions.php';

if (isset($postdata) && !empty($postdata)) {
    // Extract the data.
    $user = $postdata["user"];
    // simple security for passwords
    $password = $postdata["password"] = md5($postdata["password"]);

    // query builder
    $sql = "SELECT * FROM `users` WHERE user = '$phone' or password = '$password'";
    $result = query_result($sql, $conn);

    // error no data
    $res['msg'] = 100;
    $res['res'] = $result;
    if ($result[0] > 0) {
        $otp = otp();
        // send confirm email
        // $to = $result[1][0]['email'];
        // $subject = "My subject";
        // $txt = "رمز التحقق : - " . $otp;
        // $headers = "From: webmaster@example.com" . "\r\n" .
        //     "CC: somebodyelse@example.com";

        // mail($to, $subject, $txt, $headers);
        $result[1][0]['otp'] = $otp;
        $res['msg'] = 200;
        $res['res'] = $result[1][0];
    }
} else {
    $res['msg'] = 400;
}

echo json_encode($res);
mysqli_close($conn);
