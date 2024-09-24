<?php
@session_start();
if (isset($_GET['sair'])) {
    $_SESSION['LOGADO'] = FALSE;
}
if (isset($_SESSION['LOGADO']) && $_SESSION['LOGADO'] == TRUE) {
    @header('location:index.php');
    exit;
}

require_once '../database/Connect.php';
$bd = new Conexao();
$bd->conecta();
$mensagem = "";
if (isset($_POST['usuario_login']) && !empty($_POST['usuario_senha'])) {
    $login = addslashes($_POST['usuario_login']);
    $senha = md5($_POST['usuario_senha']);
    $sql = "select * from usuario where usuario_login = '$login' AND usuario_senha = '$senha'";
    $result = mysql_query($sql);
    if ($result && mysql_num_rows($result) >= 1) {
        $rs = mysql_fetch_object($result);
        $_SESSION['LOGADO'] = TRUE;
        $_SESSION['USER']['EMAIL'] = $rs->usuario_email;
        $_SESSION['USER']['NOME'] = $rs->usuario_nome;
        $_SESSION['USER']['ID'] = $rs->usuario_id;
        header('location:index.php');
    } else {
        $_SESSION['LOGADO'] = FALSE;
        $mensagem = "Login ou senha incorretos!";
    }
}
?>  
<!DOCTYPE html>
<html>
    <head>
        <?php require_once 'header.php'; ?>   
    </head>

<!-- Botão Flutuante -->
<div class="floating-button">
  <button id="openModalBtn">Solicitar Orçamento</button>
</div>

<!-- Modal -->
<div id="contactModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Solicitar Orçamento</h2>
    
    <form action="processa_formulario.php" method="post" id="contact-form">
      <div class="input-group">
        <label for="nome">Nome Completo</label>
        <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" required>
      </div>
      
      <div class="input-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
      </div>
      
      <div class="input-group">
        <label for="telefone">Telefone</label>
        <div class="phone-fields">
          <input type="text" id="ddd" name="ddd" placeholder="DDD" maxlength="2" required>
          <input type="text" id="telefone" name="telefone" placeholder="Número" required>
        </div>
      </div>
      
<div class="form-row">
  <div class="input-group cidade">
    <label for="cidade">Cidade</label>
    <input type="text" id="cidade" name="cidade" placeholder="Digite sua cidade" required>
  </div>
  <div class="input-group estado">
    <label for="estado">Estado</label>
    <input type="text" id="estado" name="estado" placeholder="Digite" maxlength="2" required>
  </div>
</div>
      
      <div class="input-group">
        <label for="descricao">Descrição do Orçamento</label>
        <textarea id="descricao" name="descricao" placeholder="Descreva o serviço ou estrutura metálica que deseja orçar" required></textarea>
      </div>
      
      <button type="submit">Enviar</button>
    </form>
  </div>
</div>
    <body>
        <div class="container">
            <div class="row">
		<br /><br /><br />		<br /><br /><br />
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Informe seu login</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post" action="">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Informe o login" id="usuario_login" name="usuario_login" type="text" autofocus required="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Informe a senha" id="usuario_senha" name="usuario_senha" type="password" value="" required="">
                                    </div>
                                    <button type="submit"  class="btn btn-lg btn-primary btn-block">Login</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <?= $mensagem ?>
                </div>
            </div>
        </div>
        <script src="../js/jquery-1.11.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>     
    </body>
</html>
