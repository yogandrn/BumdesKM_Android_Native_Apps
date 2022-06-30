<?php

require("config.php");

$query_insert = "SELECT * FROM places ORDER BY created_at DESC";
$result = mysqli_query($conn, $query_insert);
$cek = mysqli_affected_rows($conn);

if ($cek > 0){
    $response = [];
    while($ambil = mysqli_fetch_object($result)){
        $F["id"] = $ambil->id;
        $F["name"] = $ambil->name;
        $F["description"] = $ambil->description;
        $F["price"] = $ambil->price;
        $F["stars"] = $ambil->stars;
        $F["people"] = $ambil->people;
        $F["selected_people"] = $ambil->selected_people;
        $F["image"] = $ambil->image;
        $F["location"] = $ambil->location;
        
        array_push($response, $F);
    }
    
} else {
    $response= ["Data tidak tersedia"];
}

echo json_encode($response);
mysqli_close($conn);

?>