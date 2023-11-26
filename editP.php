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
function ambilDataById($id_penerbit) {
    global $conn;
    $sql = "SELECT * FROM penerbit WHERE id_penerbit = '$id_penerbit'";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

// Proses ambil data berdasarkan ID
if (isset($_GET['id_penerbit'])) {
    $id_penerbit = $_GET['id_penerbit'];
    $dataById = ambilDataById($id_penerbit);
}

// Proses update data
if (isset($_POST['update'])) {
    $id_penerbit = $_POST['id_penerbit'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kota = $_POST['kota'];
    $telepon = $_POST['telepon'];

    $sql = "UPDATE penerbit SET nama='$nama', alamat='$alamat', kota='$kota', telepon='$telepon' WHERE id_penerbit='$id_penerbit'";
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
            <input type="hidden" name="id_penerbit" class="form-control" value="<?= $dataById['id_penerbit']; ?>">
            <label for="nama" class="form-label">Nama:</label>
            <input type="text" name="nama" class="form-control" value="<?= $dataById['nama']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat:</label>
            <input type="text" name="alamat" class="form-control" value="<?= $dataById['alamat']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="kota" class="form-label">Kota:</label>
            <input type="text" name="kota" class="form-control" value="<?= $dataById['kota']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon:</label>
            <input type="text" name="telepon" class="form-control" value="<?= $dataById['telepon']; ?>" required>
        </div>
        <button type="submit" name="update" class="btn btn-success">Update Data</button>
    </form>

</body>

</html>

<?php
// Menutup koneksi
$conn->close();
?>