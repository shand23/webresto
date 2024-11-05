<?php
include 'koneksi.php';

// Cek apakah parameter id_pesanan telah dikirim melalui URL
if (isset($_GET['id_pesanan'])) {
    // Ambil nilai parameter id_pesanan dari URL
    $id_pesanan = htmlspecialchars($_GET["id_pesanan"]);

    // Query untuk menghapus data dari tabel pesan berdasarkan id_pesanan
    $sql = "DELETE FROM pesan WHERE id_pesanan = $id_pesanan";

    // Eksekusi query untuk menghapus data
    if (mysqli_query($kon, $sql)) {
        // Jika berhasil dihapus, redirect ke halaman index dengan pesan sukses
        header('location:index.php?info=success&msg=Data berhasil dihapus');
        exit();
    } else {
        // Jika gagal menghapus, redirect ke halaman index dengan pesan error
        header('location:index.php?info=error&msg=Gagal menghapus data: ' . mysqli_error($kon));
        exit();
    }
} else {
    // Jika parameter id_pesanan tidak ada, redirect ke halaman index dengan pesan error
    header('location:index.php?info=error&msg=Parameter id_pesanan tidak ditemukan');
    exit();
}
?>
