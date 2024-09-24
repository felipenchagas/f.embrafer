<?php

@session_start();
if ($_SESSION['LOGADO'] == FALSE) {
    @header('location:login.php');
    exit;
}
require_once '../class/Util.php';
require_once '../class/Album.php';
require_once '../class/Foto.php';

function incluir() {

    $album_nome = $_POST['album_nome'];
    $album_albumcat = $_POST['album_albumcat'];
    $album = new Album();
    $album->setNome($album_nome);
    $album->setCategoria($album_albumcat);
    $album->setFX($_POST['album_fx']);
    $album->incluir();
    $album_id = @mysql_insert_id();
    Util :: redirect("album_editar.php?id=$album_id");
}

function atualizar() {
    $album = new Album();
    $album->setNome($_POST['album_nome']);
    $album->setDesc($_POST['album_desc']);
    $album->setCategoria($_POST['album_albumcat']);
    $album->setFX($_POST['album_fx']);
    $album->setId($_POST['album_id']);
    $album->atualizar();
    Util :: redirect("album.php?id=" . $album->getId() . "&ok");
}

function remover() {
    if (isset($_REQUEST['id'])) {
        $id = intval($_REQUEST['id']);
        $r = new Album();
        $r->setId($id);
        $r->remover();
        Util :: redirect("album.php");
    }
}

function removerFoto() {
    $album_id = $_REQUEST['album_id'];
    foreach ($_POST['fotos'] as $foto_id) {
        $foto = new Foto();
        $foto->setId("$foto_id");
        $foto->remover();
    }
    Util :: redirect("album_editar.php?id=$album_id");
}

if (isset($_REQUEST['acao']) && !empty($_REQUEST['acao'])) {
    $acao = $_REQUEST['acao'];
    if (function_exists($acao)) {
        $acao();
    }
}

