<?php
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    // Jangan lupa hapus debugging ini setelah selesai
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // Simpan password dengan hashing
    $password_hashed = password_hash($password, PASSWORD_BCRYPT);

    $query_sql = "INSERT INTO tbl_users (username, email, password) VALUES ('$username', '$email', '$password_hashed')";

    if (mysqli_query($conn, $query_sql)) {
        // Redirect ke masuk.html
        header("Location: masuk.html");
        exit();
    } else {
        echo "Pendaftaran Gagal: " . mysqli_error($conn);
    }
}
?>
