<?php
include 'Database.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
class Controller
{
    private $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    function isAdmin($username, $password)
    {
        $conn = $this->db->connect();

        $sql = "SELECT * FROM admin WHERE USERNAME='$username' AND PASSWORD='$password'";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $this->db->close($conn);

            if ($row["USERNAME"] == $username && $row["PASSWORD"] == $password) {
                return 1;
            }
        }

        return 0;
    }

    function isSession($session_id)
    {
        $conn = $this->db->connect();

        // Hapus sesi yang kadaluwarsa
        $this->deleteExpiredSession();

        $sql = "SELECT * FROM session WHERE SESSION_ID='$session_id';";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $this->db->close($conn);

            if ($row["SESSION_ID"] == $session_id) {
                return 1;
            }
        }

        return 0;
    }

    function deleteExpiredSession()
    {
        $conn = $this->db->connect();

        $sql = "DELETE FROM session WHERE TANGGAL < now();";

        $conn->query($sql);
        $this->db->close($conn);
    }

    function setSession()
    {
        $conn = $this->db->connect();

        $sid = rand(1000, 9999);
        $sql = "INSERT INTO session (
            SESSION_ID,
            TANGGAL
        ) VALUES (
            $sid,
            now() + INTERVAL 24 HOUR
        );";

        $conn->query($sql);
        $this->db->close($conn);
        setcookie("sessionid", $sid, time() + (86400 * 30), "/");

        return $sid;
    }


    function increaseStock($id_ikan, $jumlah_kg)
    {
        $conn = $this->db->connect();
        $ikan = $this->getFishById($id_ikan);
        if (!$ikan) {
            return;
        }

        $stok = (int) $ikan["stok"] + $jumlah_kg;
        $sql = "UPDATE daftar_ikan SET STOK_KG=$stok WHERE ID=$id_ikan";

        if ($conn->query($sql) != TRUE) {
            echo "Failed change stock: " . $conn->error;
        }

        $this->db->close($conn);
    }

    function decreaseStock($id_ikan, $jumlah_kg)
    {
        $conn = $this->db->connect();
        $ikan = $this->getFishById($id_ikan);
        if (!$ikan) {
            return;
        }

        $stok = (int) $ikan["stok"] - $jumlah_kg;

        if ($stok < 0)
            return false;

        $sql = "UPDATE daftar_ikan SET STOK_KG=$stok WHERE ID=$id_ikan";

        if ($conn->query($sql) != TRUE) {
            echo "Failed change stock: " . $conn->error;
        }

        $this->db->close($conn);
    }

    function getAllFish()
    {
        $conn = $this->db->connect();
        $sql = "SELECT * FROM daftar_ikan;";
        $result = $conn->query($sql);

        if ($result == false) {
            return false;
        }

        $fishList = [];
        while ($row = $result->fetch_assoc()) {
            $this->db->close($conn);


            array_push($fishList, [
                "id" => $row["ID"],
                "nama_ikan" => $row["NAMA_IKAN"],
                "harga" => $row["HARGA"],
                "stok" => $row["STOK_KG"]
            ]);
        }

        return $fishList;
    }

    function addFish($nama_ikan, $harga)
    {
        $conn = $this->db->connect();

        if ($this->getFishByName($nama_ikan)) {
            return;
        }

        $sql = "INSERT INTO daftar_ikan (
            NAMA_IKAN,
            HARGA,
            STOK_KG
        ) VALUES (
            '$nama_ikan',
            $harga,
            0
        );";

        if ($conn->query($sql) != TRUE) {
            echo "Failed add fish: " . $conn->error;
            return 0;
        }


        $this->db->close($conn);
        return 1;
    }

    function getFishById($id)
    {
        $conn = $this->db->connect();
        $sql = "SELECT * FROM daftar_ikan WHERE ID=$id;";
        $result = $conn->query($sql);

        if ($result == false) {
            return false;
        }

        while ($row = $result->fetch_assoc()) {
            $this->db->close($conn);


            return [
                "id" => $row["ID"],
                "nama_ikan" => $row["NAMA_IKAN"],
                "harga" => $row["HARGA"],
                "stok" => $row["STOK_KG"]
            ];
        }
    }

    function getFishByName($nama_ikan)
    {
        $conn = $this->db->connect();
        $sql = "SELECT * FROM daftar_ikan WHERE NAMA_IKAN='$nama_ikan';";
        $result = $conn->query($sql);

        if ($result == false) {
            return false;
        }

        while ($row = $result->fetch_assoc()) {
            $this->db->close($conn);
            return [
                "id" => $row["ID"],
                "nama_ikan" => $row["NAMA_IKAN"],
                "harga" => $row["HARGA"],
                "stok" => $row["STOK_KG"]
            ];
        }
    }

    function getAllTransactions()
    {
        $conn = $this->db->connect();
        $sql = "SELECT riwayat.NAMA_ORANG, daftar_ikan.NAMA_IKAN, riwayat.PENJUALAN, riwayat.JUMLAH_KG, riwayat.JUMLAH_HARGA, riwayat.TANGGAL FROM riwayat INNER JOIN daftar_ikan ON riwayat.ID_IKAN=daftar_ikan.ID;";
        $result = $conn->query($sql);

        if ($result == false) {
            return false;
        }

        $transactions = [];
        while ($row = $result->fetch_assoc()) {
            $this->db->close($conn);

            array_push($transactions, [
                "nama_orang" => $row["NAMA_ORANG"],
                "nama_ikan" => $row["NAMA_IKAN"],
                "penjualan" => $row["PENJUALAN"],
                "jumlah_kg" => $row["JUMLAH_KG"],
                "jumlah_harga" => $row["JUMLAH_HARGA"],
                "tanggal" => $row["TANGGAL"]
            ]);
        }

        return $transactions;
    }

    function getDayTransactions()
    {
        $conn = $this->db->connect();
        $sql = "SELECT riwayat.NAMA_ORANG, daftar_ikan.NAMA_IKAN, riwayat.PENJUALAN, riwayat.JUMLAH_KG, riwayat.JUMLAH_HARGA, riwayat.TANGGAL FROM riwayat INNER JOIN daftar_ikan ON riwayat.ID_IKAN=daftar_ikan.ID WHERE riwayat.TANGGAL=CAST(Date(Now()) as Date);";
        $result = $conn->query($sql);

        if ($result == false) {
            return false;
        }

        $transactions = [];
        while ($row = $result->fetch_assoc()) {
            $this->db->close($conn);

            array_push($transactions, [
                "nama_orang" => $row["NAMA_ORANG"],
                "nama_ikan" => $row["NAMA_IKAN"],
                "penjualan" => $row["PENJUALAN"],
                "jumlah_kg" => $row["JUMLAH_KG"],
                "jumlah_harga" => $row["JUMLAH_HARGA"],
                "tanggal" => $row["TANGGAL"]
            ]);
        }

        return $transactions;
    }

    function getMonthTransactions()
    {
        $conn = $this->db->connect();
        $sql = "SELECT riwayat.NAMA_ORANG, daftar_ikan.NAMA_IKAN, riwayat.PENJUALAN, riwayat.JUMLAH_KG, riwayat.JUMLAH_HARGA, riwayat.TANGGAL FROM riwayat INNER JOIN daftar_ikan ON riwayat.ID_IKAN=daftar_ikan.ID WHERE MONTH(riwayat.TANGGAL)=MONTH(Now());";
        $result = $conn->query($sql);

        if ($result == false) {
            return false;
        }

        $transactions = [];
        while ($row = $result->fetch_assoc()) {
            $this->db->close($conn);

            array_push($transactions, [
                "nama_orang" => $row["NAMA_ORANG"],
                "nama_ikan" => $row["NAMA_IKAN"],
                "penjualan" => $row["PENJUALAN"],
                "jumlah_kg" => $row["JUMLAH_KG"],
                "jumlah_harga" => $row["JUMLAH_HARGA"],
                "tanggal" => $row["TANGGAL"]
            ]);
        }

        return $transactions;
    }

    function getYearTransactions()
    {
        $conn = $this->db->connect();
        $sql = "SELECT PENJUALAN, JUMLAH_KG, JUMLAH_HARGA, TANGGAL, MONTH(TANGGAL) as BULAN FROM riwayat WHERE YEAR(riwayat.TANGGAL)=YEAR(now());";
        $result = $conn->query($sql);

        if ($result == false) {
            return false;
        }

        $transactions = [];
        while ($row = $result->fetch_assoc()) {
            $this->db->close($conn);

            array_push($transactions, [
                "penjualan" => $row["PENJUALAN"],
                "jumlah_kg" => $row["JUMLAH_KG"],
                "jumlah_harga" => $row["JUMLAH_HARGA"],
                "tanggal" => $row["TANGGAL"],
                "bulan" => $row["BULAN"]
            ]);
        }

        return $transactions;
    }

    function addTransaction($id_ikan, $nama_orang, $jenis, $jumlah_kg)
    {
        $conn = $this->db->connect();
        $ikan = $this->getFishById($id_ikan);
        $harga = (int) $ikan["harga"] * $jumlah_kg;

        if (!$this->getFishById($id_ikan)) {
            echo "Ikan tidak terdaftar";
            return;
        }

        $isValid = true;
        if ($jenis == 0) {
            $this->increaseStock($id_ikan, $jumlah_kg);
        } else {
            $isValid = $this->decreaseStock($id_ikan, $jumlah_kg);
        }

        if (!$isValid)
            return 0;

        $sql = "INSERT INTO riwayat (
            ID_IKAN,
            NAMA_ORANG,
            PENJUALAN,
            JUMLAH_KG,
            JUMLAH_HARGA,
            TANGGAL
        ) VALUES (
            $id_ikan,
            '$nama_orang',
            $jenis,
            $jumlah_kg,
            $harga,
            now()
        );";

        if ($conn->query($sql) != TRUE) {
            return 0;
        } else {
        }

        $this->db->close($conn);
        return 1;
    }
}

$controller = new Controller($db);