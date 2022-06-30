<?php

require("config.php");

function sensor($data){
    $jml = strlen($data);
    $jumlah_sensor=$jml - 3;
    $setelah_angka_ke=$jml-$jumlah_sensor - 1;
 
//ambil 4 angka di tengah yan akan disensor
$censored = mb_substr($data, $setelah_angka_ke, $jumlah_sensor);
 
//pecah kelompok angka pertama dan terakhir
$pecah=explode($censored,$data);

$hide = "x";
for($i = 1 ; $i < $jumlah_sensor; $i++ ) {
    $hide .= "x";
}
 
//gabung angka perama dan terakhir dengan angka tengah yang telah di sensor
$hasil=$pecah[0].$hide.$pecah[1];
 
//tampilkan
return $hasil;
}

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
        $F["username"] = sensor($getFoto['username']);
        
        array_push($response["data"], $F);
    }
    
} else {
    $response["kode"] = 0;
    $response["pesan"] = "Data tidak tersedia";
}

echo json_encode($response);
mysqli_close($conn);

?>