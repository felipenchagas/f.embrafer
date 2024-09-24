<?php

@session_start();
if ($_SESSION['LOGADO'] == FALSE) {
    @header('location:login.php');
    exit;
}
require_once '../class/Util.php';
require_once '../class/Slide.php';

function incluir() {
    $slide = new Slide();
    if (isset($_FILES['slide_foto']['name']) && !empty($_FILES['slide_foto']['name'])) {
        $slide->upload();
    }
    $slide->slide_link = $_POST['slide_link'];
    $slide->incluir();
    Util :: redirect("slide.php?ok");
}

function atualizar() {
    $a = new Slide();
    $a->set($_POST['slide_id']);
    if (isset($_FILES['slide_foto']['name']) && !empty($_FILES['slide_logo']['name'])) {
        $a->removerFoto();
        $a->upload();
    }
    $a->slide_link = $_POST['slide_link'];
    $a->atualizar();
    Util :: redirect("slide.php");
}

function remover() {
    if (isset($_REQUEST['id'])) {
        $id = intval($_REQUEST['id']);
        $r = new Slide();
        $r->setId($id);
        $r->removerFoto();
        $r->remover();
        Util :: redirect("slide.php");
    }
}

function uplink() {
    $a = new Slide();
    $a->slide_id = $_POST['slide_id'];
    if (isset($_FILES['slide_foto']['name']) && !empty($_FILES['slide_logo']['name'])) {
        $a->removerFoto();
        $a->upload();
    }
    $a->slide_link = $_POST['slide_link'];
    $a->atualizar();
}

if (isset($_REQUEST['acao']) && !empty($_REQUEST['acao'])) {
    $acao = $_REQUEST['acao'];
    if (function_exists($acao)) {
        $acao();
    }
}
