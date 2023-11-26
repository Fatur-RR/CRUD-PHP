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

// Fungsi untuk mengambil data berdasarkan ID
function ambilDataById($id_buku) {
    global $conn;
    $sql = "SELECT * FROM buku WHERE id_buku = '$id_buku'";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

// Proses ambil data berdasarkan ID
if (isset($_GET['id_buku'])) {
    $id_buku = $_GET['id_buku'];
    $dataById = ambilDataById($id_buku);
}

// Proses update data
if (isset($_POST['update'])) {
    $id_buku = $_POST['id_buku'];
    $Kategori = $_POST['Kategori'];
    $nama_buku = $_POST['nama_buku'];
    $Harga = $_POST['Harga'];
    $Stok = $_POST['Stok'];
    $Penerbit = $_POST['Penerbit'];

    $sql = "UPDATE buku SET Kategori='$Kategori', nama_buku='$nama_buku', Harga='$Harga', Stok='$Stok', Penerbit='$Penerbit' WHERE id_buku='$id_buku'";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Data Buku</title>
</head>

<body>

    <!-- Form edit data -->
    <form method="post" class="mb-3">
        <div class="mb-3">
            <input type="hidden" name="id_buku" class="form-control" value="<?= $dataById['id_buku']; ?>">
            <label for="Kategori" class="form-label">Kategori:</label>
            <input type="text" name="Kategori" class="form-control" value="<?= $dataById['Kategori']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="nama_buku" class="form-label">Nama Buku:</label>
            <input type="text" name="nama_buku" class="form-control" value="<?= $dataById['nama_buku']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="Harga" class="form-label">Harga:</label>
            <input type="text" name="Harga" class="form-control" value="<?= $dataById['Harga']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="Stok" class="form-label">Stok:</label>
            <input type="text" name="Stok" class="form-control" value="<?= $dataById['Stok']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="Penerbit" class="form-label">Penerbit:</label>
            <input type="text" name="Penerbit" class="form-control" value="<?= $dataById['Penerbit']; ?>" required>
        </div>
        <button type="submit" name="update" class="btn btn-success">Update Data</button>
    </form>

</body>

</html>

<?php
// Menutup koneksi
$conn->close();
?>