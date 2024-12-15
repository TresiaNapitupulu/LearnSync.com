<?php
// Konfigurasi database
$host = "localhost";
$dbname = "materi_unggah";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda

// Koneksi ke database
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Proses form saat dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $semester = $_POST['semester'];
    $matkul = $_POST['matkul'];
    $materi = $_POST['materi'];
    $uploadDir = 'uploads/'; // Folder penyimpanan file
    $fileName = basename($_FILES['file']['name']);
    $targetFilePath = $uploadDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Validasi input
    if (!empty($semester) && !empty($matkul) && !empty($materi) && !empty($fileName)) {
        // Validasi jenis file
        $allowedTypes = ['jpg', 'png', 'jpeg', 'gif', 'pdf', 'docx', 'xlsx', 'pptx'];
        if (in_array(strtolower($fileType), $allowedTypes)) {
            // Pindahkan file ke folder
            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
                // Simpan ke database
                $stmt = $conn->prepare("INSERT INTO uploads (semester, matkul, materi, file_name, file_path) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $semester, $matkul, $materi, $fileName, $targetFilePath);
                if ($stmt->execute()) {
                    echo "<script>
                            document.getElementById('notificationSuccess').style.display = 'block';
                          </script>";
                } else {
                    echo "<script>
                            document.getElementById('notificationError').style.display = 'block';
                          </script>";
                }
                $stmt->close();
            } else {
                echo "<script>
                        document.getElementById('notificationError').style.display = 'block';
                      </script>";
            }
        } else {
            echo "Invalid file type. Only " . implode(", ", $allowedTypes) . " are allowed.";
        }
    } else {
        echo "All fields are required.";
    }
}

$conn->close();
?>
