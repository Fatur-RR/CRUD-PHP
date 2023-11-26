<?php
// Konfigurasi database
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "data"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fungsi untuk menambah data buku
function tambahData($id_buku, $Kategori, $nama_buku, $Harga, $Stok, $Penerbit) {
    global $conn;
    $sql = "INSERT INTO buku (id_buku, Kategori, nama_buku, Harga, Stok, Penerbit) VALUES ('$id_buku', '$Kategori', '$nama_buku', '$Harga', '$Stok', '$Penerbit')";
    return $conn->query($sql);
}

// Fungsi untuk menambah data penerbit
function tambahDataPenerbit($id_penerbit, $nama, $alamat, $kota, $telepon) {
    global $conn;
    $sql = "INSERT INTO penerbit (id_penerbit, nama, alamat, kota, telepon) VALUES ('$id_penerbit', '$nama', '$alamat', '$kota', '$telepon')";
    return $conn->query($sql);
}


// Fungsi untuk mengambil data buku
// Fungsi untuk mengambil data buku
function ambilData() {
    global $conn;
    $sql = "SELECT * FROM buku ORDER BY id_buku";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fungsi untuk mengambil data penerbit
function ambilDataPenerbit() {
    global $conn;
    $sql = "SELECT * FROM penerbit ORDER BY id_penerbit";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}




// Fungsi untuk menghapus data buku
function hapusData($id_buku) {
    global $conn;
    $sql = "DELETE FROM buku WHERE id_buku='$id_buku'";
    return $conn->query($sql);
}
// Fungsi untuk menghapus data penerbit
function hapusDataPenerbit($id_penerbit) {
    global $conn;
    $sql = "DELETE FROM penerbit WHERE id_penerbit='$id_penerbit'";
    return $conn->query($sql);
}

function cariData($keyword) {
    global $conn;
    $sql = "SELECT * FROM buku WHERE 
            id_buku LIKE '%$keyword%' OR 
            Kategori LIKE '%$keyword%' OR 
            nama_buku LIKE '%$keyword%' OR 
            Harga LIKE '%$keyword%' OR 
            Stok LIKE '%$keyword%' OR 
            Penerbit LIKE '%$keyword%'";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Proses tambah data buku
if (isset($_POST['tambah'])) {
    $id_buku = $_POST['id_buku'];
    $Kategori = $_POST['Kategori'];
    $nama_buku = $_POST['nama_buku'];
    $Harga = $_POST['Harga'];
    $Stok = $_POST['Stok'];
    $Penerbit = $_POST['Penerbit'];
    tambahData($id_buku, $Kategori,  $nama_buku, $Harga, $Stok, $Penerbit);
}

// Proses tambah data penerbit
if (isset($_POST['tambahPenerbit'])) {
    $id_penerbit = $_POST['id_penerbit'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kota = $_POST['kota'];
    $telepon = $_POST['telepon'];
    tambahDataPenerbit($id_penerbit, $nama,  $alamat, $kota, $telepon);
}

// Proses hapus data buku
if (isset($_GET['hapus'])) {
    $id_buku = $_GET['hapus'];
    hapusData($id_buku);
}
// Proses hapus data penerbit
if (isset($_GET['hapus'])) {
    $id_penerbit = $_GET['hapus'];
    hapusDataPenerbit($id_penerbit);
}

// Proses pencarian data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $keyword = $_POST['search'];
    $data = cariData($keyword);
}



// Ambil data buku dari database
if (isset($data) && !empty($data)) {
    $tampilData = $data;
} else {
    $tampilData = ambilData();
}

// Ambil data penerbit dari database
if (isset($data) && !empty($data)) {
    $tampilDataPenerbit = $data;
} else {
    $tampilDataPenerbit = ambilDataPenerbit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <!-- Tambahkan referensi Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm bg-dark fixed-top mb-5">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">CRUD PERPUS</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin.php">Admin</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pengadaan.php">Pengadaan</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

     <!-- Form pencarian data -->
     <form method="post" class="mb-3 pt-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari Buku" required>
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    <!-- Form tambah data menggunakan Bootstrap -->
    
    <form method="post" class="mb-3">
        <h2>Tambah Data Buku</h2>
        <div class="mb-3">
            <label for="id_buku" class="form-label">ID Buku:</label>
            <input type="text" name="id_buku" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="Kategori" class="form-label">Kategori:</label>
            <input type="text" name="Kategori" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nama_buku" class="form-label">Nama Buku:</label>
            <input type="text" name="nama_buku" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="Harga" class="form-label">Harga:</label>
            <input type="text" name="Harga" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="Stok" class="form-label">Stok:</label>
            <input type="text" name="Stok" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="Penerbit" class="form-label">Penerbit:</label>
            <input type="text" name="Penerbit" class="form-control" required>
        </div>
        <button type="submit" name="tambah" class="btn btn-success">Tambah Data</button>
    </form>
    
    <form method="post" class="mb-3">
        <h2>Tambah Data Penerbit</h2>
        <div class="mb-3">
            <label for="id_penerbit" class="form-label">ID Penerbit:</label>
            <input type="text" name="id_penerbit" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama:</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat:</label>
            <input type="text" name="alamat" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="kota" class="form-label">Kota:</label>
            <input type="text" name="kota" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="telepon" class="form-label">telepon:</label>
            <input type="text" name="telepon" class="form-control" required>
        </div>
        <button type="submit" name="tambahPenerbit" class="btn btn-success">Tambah Data</button>
    </form>

    <!-- Tabel data -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Buku</th>
                <th>Kategori</th>
                <th>Nama Buku</th>
                <th>Harga </th>
                <th>Stok </th>
                <th>Penerbit </th>
                <th>Aksi </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tampilData as $row): ?>
                <tr>
                    <td><?= $row['id_buku']; ?></td>
                    <td><?= $row['Kategori']; ?></td>
                    <td><?= $row['nama_buku']; ?></td>
                    <td><?= $row['Harga']; ?></td>
                    <td><?= $row['Stok']; ?></td>
                    <td><?= $row['Penerbit']; ?></td>
                    <td>
                        <a href="index.php?hapus=<?= $row['id_buku']; ?>" class="btn btn-danger">Hapus</a>
                        <a href="edit.php?id_buku=<?= $row['id_buku']; ?>" class="btn btn-warning">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        
        <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Penerbit</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Kota </th>
                <th>Telepon </th>
                <th>Aksi </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tampilDataPenerbit as $row): ?>
                <tr>
                    <td><?= $row['id_penerbit']; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['alamat']; ?></td>
                    <td><?= $row['kota']; ?></td>
                    <td><?= $row['telepon']; ?></td>
                    <td>
                        <a href="index.php?hapus=<?= $row['id_penerbit']; ?>" class="btn btn-danger">Hapus</a>
                        <a href="editP.php?id_penerbit=<?= $row['id_penerbit']; ?>" class="btn btn-warning">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<!-- Tambahkan referensi Bootstrap JS dan Popper.js (diperlukan untuk beberapa fitur Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


<?php
// Menutup koneksi
$conn->close();
?>
