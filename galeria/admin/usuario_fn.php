<?php

@session_start();
if ($_SESSION['LOGADO'] == FALSE) {
    @header('location:login.php');
    exit;
}
require_once '../class/Util.php';
require_once '../class/Usuario.php';

function incluir() {
    $nome = $_POST['usuario_nome'];
    $email = $_POST['usuario_email'];
    $login = $_POST['usuario_login'];
    $senha = md5($_POST['usuario_senha']);

    $usuario = new Usuario();
    $usuario->setNome($nome);
    $usuario->setEmail($email);
    $usuario->setLogin($login);
    $usuario->setSenha($senha);
    $usuario->incluir();
    Util :: redirect("usuario.php");
}

function atualizar() {
    $a = new Usuario();
    if (isset($_REQUEST['usuario_senha']) && !empty($_REQUEST['usuario_senha'])) {
        $senha = md5($_REQUEST['usuario_senha']);
        $a->setSenha("$senha");
    }
    $a->setNome($_POST['usuario_nome']);
    $a->setEmail($_POST['usuario_email']);
    $a->setLogin($_POST['usuario_login']);
    $a->setId($_GET['id']);
    $a->atualizar();

    Util :: redirect("usuario.php");
}

function remover() {
    if (isset($_REQUEST['id'])) {
        $id = intval($_REQUEST['id']);
        $r = new Usuario();
        $r->setId($id);
        $r->remover();

        Util :: redirect("usuario.php");
    }
}

if (isset($_REQUEST['acao']) && !empty($_REQUEST['acao'])) {
    $acao = $_REQUEST['acao'];
    if (function_exists($acao)) {
        $acao();
    }
}

