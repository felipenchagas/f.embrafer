<?php

@session_start();
if ($_SESSION['LOGADO'] == FALSE) {
    @header('location:login.php');
    exit;
}
require_once '../class/Util.php';
require_once '../class/Album.php';
require_once '../class/Foto.php';

function posicao() {
    $foto = new Foto();
    $foto->updatePos();
}

function atualizarLegenda() {
    $foto_id = intval($_POST['foto_id']);
    $foto_legenda = addslashes($_POST['foto_legenda']);
    $foto = new Foto();
    $foto->setId($foto_id);
    $foto->setLegenda($foto_legenda);
    $foto->atualizar();
}

if (isset($_REQUEST['acao']) && !empty($_REQUEST['acao'])) {
    $acao = $_REQUEST['acao'];
    if (function_exists($acao)) {
        $acao();
    }
}

