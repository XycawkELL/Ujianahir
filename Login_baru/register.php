<?php
// Panggil file koneksi
require 'koneksi.php';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi_password'];

    // Cek apakah password dan konfirmasi sama
    if ($password !== $konfirmasi) {
        echo "<script>alert('Password tidak cocok!'); window.history.back();</script>";
        exit;
    }

    // Enkripsi password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah username/email sudah pernah daftar
    $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('Username atau Email sudah terdaftar!'); window.history.back();</script>";
        exit;
    }

    // Masukkan ke database
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pendaftaran Berhasil! Silakan Sign In.'); window.location.href='Login.html';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>