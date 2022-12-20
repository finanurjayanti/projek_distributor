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
        }


        $this->db->close($conn);
    }

    function increaseStock($id_ikan, $jumlah_kg)
    {
        $conn = $this->db->connect();
        $ikan = $this->getFishById($id_ikan);
        if (!$ikan) {
            return;
        }

        $stok = (int) $ikan["stok"] + $jumlah_kg;
        echo $stok;
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
        echo $stok;
        $sql = "UPDATE daftar_ikan SET STOK_KG=$stok WHERE ID=$id_ikan";

        if ($conn->query($sql) != TRUE) {
            echo "Failed change stock: " . $conn->error;
        }

        $this->db->close($conn);
    }

    function getFishById($id)
    {
        $conn = $this->db->connect();
        $sql = "SELECT * FROM daftar_ikan WHERE ID=$id;";
        $result = $conn->query($sql);

        if ($result == false) {
            return false;
        }
        ;


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
        ;

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

    function add($id_ikan, $nama_orang, $jenis, $jumlah_kg)
    {
        $conn = $this->db->connect();
        $ikan = $this->getFishById($id_ikan);
        $harga = (int) $ikan["harga"] * $jumlah_kg;

        if (!$this->getFishById($id_ikan)) {
            echo "Ikan tidak terdaftar";
            return;
        }

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
            echo "Failed add record: " . $conn->error;
        } else {
            if ($jenis == 0) {
                $this->increaseStock($id_ikan, $jumlah_kg);
            } else {
                $this->decreaseStock($id_ikan, $jumlah_kg);
            }
        }

        $this->db->close($conn);
    }
}

$controller = new Controller($db);