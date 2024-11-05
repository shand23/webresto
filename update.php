<?php
include 'koneksi.php';

// Fungsi untuk mencegah inputan karakter yang tidak sesuai
function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Cek apakah ada nilai yang dikirim menggunakan metode GET dengan nama id_pesanan
if (isset($_GET['id_pesanan'])) {
    $id_pesanan = input($_GET["id_pesanan"]);

    // Query untuk mengambil data pesan berdasarkan id_pesanan
    $sql = "SELECT * FROM pesan WHERE id_pesanan='$id_pesanan'";
    $hasil = mysqli_query($kon, $sql);
    $data = mysqli_fetch_assoc($hasil);
}

// Cek apakah ada kiriman form dari method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pesanan = input($_POST["id_pesanan"]);
    $nama_lengkap = input($_POST["nama_lengkap"]);
    $no_hp = input($_POST["no_hp"]);
    $jumlah_orang = input($_POST["jumlah_orang"]);
    $tanggal = input($_POST["tanggal"]);
    $waktu = input($_POST["waktu"]);
    $pesanan = input($_POST["pesanan"]);

    // Query update data pada tabel pesan
    $sql = "UPDATE pesan SET
            nama_lengkap='$nama_lengkap',
            no_hp='$no_hp',
            jumlah_orang='$jumlah_orang',
            tanggal='$tanggal',
            waktu='$waktu',
            pesanan='$pesanan'
            WHERE id_pesanan='$id_pesanan'";

    // Mengeksekusi atau menjalankan query di atas
    $hasil = mysqli_query($kon, $sql);

    // Kondisi apakah berhasil atau tidak dalam mengeksekusi query di atas
    if ($hasil) {
        header("Location:index.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'> Data Gagal diupdate: " . mysqli_error($kon) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pesan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h2>Edit Data Pesan</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="id_pesanan" value="<?php echo isset($data['id_pesanan']) ? $data['id_pesanan'] : ''; ?>">
        <div class="form-group">
            <label>Nama Lengkap:</label>
            <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan Nama Lengkap" required value="<?php echo isset($data['nama_lengkap']) ? $data['nama_lengkap'] : ''; ?>">
        </div>
        <div class="form-group">
            <label>No HP:</label>
            <input type="text" name="no_hp" class="form-control" placeholder="Masukkan No HP" required value="<?php echo isset($data['no_hp']) ? $data['no_hp'] : ''; ?>">
        </div>
        <div class="form-group">
            <label>Jumlah Orang:</label>
            <input type="number" name="jumlah_orang" class="form-control" placeholder="Masukkan Jumlah Orang" required value="<?php echo isset($data['jumlah_orang']) ? $data['jumlah_orang'] : ''; ?>">
        </div>
        <div class="form-group">
            <label>Tanggal:</label>
            <input type="date" name="tanggal" class="form-control" placeholder="Masukkan Tanggal" required value="<?php echo isset($data['tanggal']) ? $data['tanggal'] : ''; ?>">
        </div>
        <div class="form-group">
            <label>Waktu:</label>
            <input type="time" name="waktu" class="form-control" placeholder="Masukkan Waktu" required value="<?php echo isset($data['waktu']) ? $data['waktu'] : ''; ?>">
        </div>
        <div class="form-group">
            <label>Pesanan:</label>
            <textarea name="pesanan" class="form-control" rows="5" placeholder="Masukkan Pesanan" required><?php echo isset($data['pesanan']) ? $data['pesanan'] : ''; ?></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
