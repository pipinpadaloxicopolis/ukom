<?php

session_start();
//Memanggil Database
require('koneksi.php');

//Mengambil data dari form register
$nama_lengkap = mysqli_real_escape_string($connection, $_POST['register-name']);
$username = mysqli_real_escape_string($connection, $_POST['register-username']);
$password1 = mysqli_real_escape_string($connection, $_POST['register-password1']);
$password2 = mysqli_real_escape_string($connection, $_POST['register-password2']);
$telp = mysqli_real_escape_string($connection, $_POST['register-telp']);

//Mengecek apakah bagian konfirmasi passwordnya sama
if ($password1 != $password2)
{
	header('Location: index.php?err=passconfirm');
	return;
}

//Mengecek apakah nama lengkap atau username sudah dipakai user lain
$checkQuery = "Select * From tb_masyarakat Where nama_lengkap='$nama_lengkap' Or username='$username'";
$check = mysqli_query($connection);

if (mysqli_num_rows($check) > 0)
{
	header('Location: index.php?err=nameexist');
	return;
}

//Enkripsi Password dengan md5, kalo enkripsi yang bagus lagi ga tau caranya, yang penting projek selesai soalnya mau UN
$password = md5($password1);

//Query untuk memasukkan data user ke Database
$query = "Insert Into tb_masyarakat(nama_lengkap, username, password, telp) Values('$nama_lengkap', '$username', '$password', '$telp')";
if (mysqli_query($connection, $query))
{
	header('Location: index.php?success=pendaftaran');
}

?>