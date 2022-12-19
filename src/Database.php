<?php
class Database {
    private $database = "distribusi";
    private $host = "127.0.0.1";
    private $username = "root";
    private $password = "";

    private $maxPool = 10; 
    public $connectionPool = [];

    function __construct() {
        // Melakukan perulangan sebanyak $maxPool
        for ($i = 0; $i < $this->maxPool; $i++) {
    
            // Membuat koneksi database
            $conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            // Jika terjadi error, maka ...
            if ($conn->connect_error) {
                die("Connection  Failed: " . $conn->connect_error);
            }
    
            // Koneksi yang berhasil dibuat, dimasukkan kedalam array $connectionPool
            array_push($this->connectionPool, $conn);
        } 


        // Menyiapkan tabel
        $this->makeTables();
    }

    // Mengambil koneksi database dari $connectionPool
    function connect() {
        return array_shift($this->connectionPool);
        
    }

    // Menutup/Mengembalikan koneksi dari database ke $conectionPool
    function close($conn) {
        array_push($this->connectionPool, $conn);
    }

    // Menyiapkan tabel didalam database
    private function makeTables() {
        $conn = $this->connect();

        $tableSession = "CREATE TABLE IF NOT EXISTS session (
            ID INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
            SESSION_ID INT NOT NULL
        );";

        $tableAdmin = "CREATE TABLE IF NOT EXISTS admin (
            ID INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
            USERNAME VARCHAR(255) NOT NULL,
            PASSWORD VARCHAR(255) NOT NULL
        );";

        $tableDaftarIkan = "CREATE TABLE IF NOT EXISTS daftar_ikan (
            ID INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
            NAMA_IKAN VARCHAR(255) NOT NULL,
            HARGA INT NOT NULL,
            STOK_KG INT NOT NULL
        );";

        $tableRiwayat = "CREATE TABLE IF NOT EXISTS riwayat (
            ID INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
            ID_IKAN INT NOT NULL,
            NAMA_ORANG VARCHAR(255) NOT NULL,
            PENJUALAN BOOLEAN NOT NULL,
            JUMLAH_KG INT NOT NULL,
            JUMLAH_HARGA INT NOT NULL,
            TANGGAL DATE NOT NULL
        );";

        if ($conn->query($tableSession) != TRUE) {
            echo "Error creating table: " . $conn->error;
        }
        if ($conn->query($tableAdmin) != TRUE) {
            echo "Error creating table: " . $conn->error;
        }
        if ($conn->query($tableDaftarIkan) != TRUE) {
            echo "Error creating table: " . $conn->error;
        }
        if ($conn->query($tableRiwayat) != TRUE) {
            echo "Error creating table: " . $conn->error;
        }

        $this->close($conn);
    }
}

$db = new Database();
?>