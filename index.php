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

// Fungsi untuk mengambil data buku
function ambilData() {
    global $conn;
    $sql = "SELECT * FROM buku ORDER BY id_buku";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Perpustakaan</title>

    <!-- Tambahkan referensi Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <nav class="navbar navbar-expand-lg navbar-dark shadow-sm bg-dark fixed-top mb-5">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">CRUD PERPUS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
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
                </tr>
                <?php endforeach; ?>
            </tbody>
    </div>
</body>

</html>