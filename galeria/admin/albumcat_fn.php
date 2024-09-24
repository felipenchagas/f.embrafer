<?php

@session_start();
if ($_SESSION['LOGADO'] == FALSE) {
    @header('location:login.php');
    exit;
}
require_once '../class/Util.php';
require_once '../class/Albumcat.php';

function incluir() {
    $nome = $_POST['albumcat_nome'];
    $cad = new Albumcat();
    $cad->setNome($nome);
    $cad->incluir();
    Util :: redirect("albumcat.php");
}

function atualizar() {
    $a = new Albumcat();
    $a->setNome($_POST['albumcat_nome']);
    $a->setId($_POST['albumcat_id']);
    $a->atualizar();
   // Util :: redirect("albumcat.php?id=" . $a->getId() . "&ok");
}

function remover() {
    if (isset($_REQUEST['id'])) {
        $id = intval($_REQUEST['id']);
        $remover = new Albumcat();
        $remover->setId($id);
        $remover->remover();
        Util :: redirect("albumcat.php");
    }
}

if (isset($_REQUEST['acao']) && !empty($_REQUEST['acao'])) {
    $acao = $_REQUEST['acao'];
    if (function_exists($acao)) {
        $acao();
    }
}

