<!DOCTYPE html>
<html>
<head>
    <title>Form Pendaftaran Pesan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <?php
    include "koneksi.php";

    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama_lengkap = input($_POST["nama_lengkap"]);
        $no_hp = input($_POST["no_hp"]);
        $jumlah_orang = input($_POST["jumlah_orang"]);
        $tanggal = input($_POST["tanggal"]);
        $waktu = input($_POST["waktu"]);
        $pesanan = input($_POST["pesanan"]);

        $sql = "INSERT INTO pesan (nama_lengkap, no_hp, jumlah_orang, tanggal, waktu, pesanan) VALUES ('$nama_lengkap', '$no_hp', '$jumlah_orang', '$tanggal', '$waktu', '$pesanan')";

        $hasil = mysqli_query($kon, $sql);

        if ($hasil) {
            header("Location:index.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'> Data Gagal disimpan: " . mysqli_error($kon) . "</div>";
        }
    }
    ?>
    <h2>Input Data Pesan</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Nama Lengkap:</label>
            <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan Nama Lengkap" required>
        </div>
        <div class="form-group">
            <label>No HP:</label>
            <input type="text" name="no_hp" class="form-control" placeholder="Masukkan No HP" required>
        </div>
        <div class="form-group">
            <label>Jumlah Orang:</label>
            <input type="number" name="jumlah_orang" class="form-control" placeholder="Masukkan Jumlah Orang" required>
        </div>
        <div class="form-group">
            <label>Tanggal:</label>
            <input type="date" name="tanggal" class="form-control" placeholder="Masukkan Tanggal" required>
        </div>
        <div class="form-group">
            <label>Waktu:</label>
            <input type="time" name="waktu" class="form-control" placeholder="Masukkan Waktu" required>
        </div>
        <div class="form-group">
            <label>Pesanan:</label>
            <textarea name="pesanan" class="form-control" rows="5" placeholder="Masukkan Pesanan" required></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
