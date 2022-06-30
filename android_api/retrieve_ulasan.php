<?php

require("config.php");

$query_insert = "SELECT * FROM ulasan ORDER BY id DESC";
$result = mysqli_query($conn, $query_insert);
$cek = mysqli_affected_rows($conn);

if ($cek > 0){
    $response["kode"] = 1;
    $response["pesan"] = "Data tersedia";
    $response["data"] = array();

    while($ambil = mysqli_fetch_object($result)){
        $F["id_user"] = $ambil->id_user;
        $F["ulasan"] = $ambil->ulasan;
        $id = $F['id_user'];
        $getFoto = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$id'"));
        $F["foto_profil"] = $getFoto['foto_profil'];
        $F["username"] = $getFoto['username'];
        
        array_push($response["data"], $F);
    }
    
} else {
    $response["kode"] = 0;
    $response["pesan"] = "Data tidak tersedia";
}

echo json_encode($response);
mysqli_close($conn);

?>