<?php
include 'koneksi.php';

// Proses delete data jika ada request penghapusan
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id_pesanan'])) {
    $id_pesanan = htmlspecialchars($_GET["id_pesanan"]);

    $sql = "DELETE FROM pesan WHERE id_pesanan='$id_pesanan'";
    $hasil = mysqli_query($kon, $sql);

    if ($hasil) {
        header("Location:index.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'> Data Gagal dihapus: " . mysqli_error($kon) . "</div>";
    }
}

// Proses pencarian
if (isset($_GET['search'])) {
    $keyword = $_GET['search'];
    $sql = "SELECT * FROM pesan WHERE nama_lengkap LIKE '%$keyword%' OR no_hp LIKE '%$keyword%' OR pesanan LIKE '%$keyword%'";
} else {
    $sql = "SELECT * FROM pesan ORDER BY id_pesanan DESC";
}

$result = mysqli_query($kon, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pelanggan Reservasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <span class="navbar-brand mb-0 h1">Noodles & Co.</span>
</nav>
<div class="container">
    <br>
    <h4><center>DATA PELANGGAN RESERVASI</center></h4>
    <!-- Form pencarian -->
    <form action="index.php" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Cari..." name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </div>
    </form>
    <table class="my-3 table table-bordered">
        <thead>
            <tr class="table-primary">
                <th>No</th>
                <th>
                    Nama
                    <button class="btn btn-link" onclick="sortTable('nama_lengkap')">↑↓</button>
                </th>
                <th>
                    No HP
                    <button class="btn btn-link" onclick="sortTable('no_hp')">↑↓</button>
                </th>
                <th>
                    Jumlah Orang
                    <button class="btn btn-link" onclick="sortTable('jumlah_orang')">↑↓</button>
                </th>
                <th>
                    Tanggal
                    <button class="btn btn-link" onclick="sortTable('tanggal')">↑↓</button>
                </th>
                <th>
                    Waktu
                    <button class="btn btn-link" onclick="sortTable('waktu')">↑↓</button>
                </th>
                <th>
                    Pesanan
                    <button class="btn btn-link" onclick="sortTable('pesanan')">↑↓</button>
                </th>
                <th colspan='2'>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            while ($data = mysqli_fetch_array($result)) {
                $no++;
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $data["nama_lengkap"]; ?></td>
                <td><?php echo $data["no_hp"]; ?></td>
                <td><?php echo $data["jumlah_orang"]; ?></td>
                <td><?php echo $data["tanggal"]; ?></td>
                <td><?php echo $data["waktu"]; ?></td>
                <td><?php echo $data["pesanan"]; ?></td>
                <td>
                    <a href="update.php?id_pesanan=<?php echo htmlspecialchars($data['id_pesanan']); ?>" class="btn btn-warning" role="button">Update</a>
                    <!-- Menggunakan parameter id_pesanan -->
                    <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?action=delete&id_pesanan=<?php echo $data['id_pesanan']; ?>" class="btn btn-danger" role="button">Delete</a>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <a href="create.php" class="btn btn-primary" role="button">Tambah Data</a>
</div>
<script>
    function sortTable($nama_lengkap) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.querySelector('table');
        switching = true;
        // Set the sorting direction to ascending:
        dir = "asc";
        /* Make a loop that will continue until
        no switching has been done: */
        while (switching) {
            // Start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /* Loop through all table rows (except the
            first, which contains table headers): */
            for (i = 1; i < (rows.length - 1); i++) {
                // Start by saying there should be no switching:
                shouldSwitch = false;
                /* Get the two elements you want to compare,
                one from current row and one from the next: */
                x = rows[i].querySelectorAll("td")[$nama_lengkap];
                y = rows[i + 1].querySelectorAll("td")[$nama_lengkap];
                /* Check if the two rows should switch place,
                based on the direction, asc or desc: */
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else
                if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                /* If a switch has been marked, make the switch
                and mark that a switch has been done: */
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                // Each time a switch is done, increase this count by 1:
                switchcount ++;
            } else {
                /* If no switching has been done AND the direction is "asc",
                set the direction to "desc" and run the while loop again. */
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
        // Change the arrow direction
        var arrow = document.querySelector('th.' + $nama_lengkap + ' button');
        arrow.innerHTML = dir; // Change the arrow text to "asc" or "desc"
    }
</script>

</body>
</html>