<?php
require 'koneksi.php';
$email = $_POST['email'];
$password = $_POST['password'];

$query_sql = "SElect * FROM tbl_users
WHERE email = '$email' AND password = '$password'";

$result = mysqli_query($conn, $query_sql);

if (mysqli_num_rows($result) > 0) {
    header("Location: page.html");

} else {
    echo "<center><h1>Email atau password salah. Silahkan Coba Login Kembali.</h1>
    <button><strong><a href='masuk.html'>Masuk</a></strong></button></center>";
}