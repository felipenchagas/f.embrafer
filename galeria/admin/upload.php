<?php
require_once '../class/Foto.php';
$foto = new Foto();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $foto_url = md5(uniqid(time())) . '.jpg';
    if (move_uploaded_file($_FILES['file']['tmp_name'], "../fotos/" . $foto_url)) {
        $foto_album = $_REQUEST['album_id'];
        $foto->setUrl($foto_url);
        $foto->setAlbum($foto_album);
        $foto_id = $foto->incluir();
        echo json_encode(array('foto_url' => $foto_url, 'foto_id' => $foto_id));
    }
}

