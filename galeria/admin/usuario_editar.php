<?php
@session_start();
if ($_SESSION['LOGADO'] == FALSE) {
    @header('location:login.php');
    exit;
}
require_once '../class/Usuario.php';
$id = intval($_GET['id']);
$edit = new Usuario();
$edit->setId($id);
$edit->getUsuario();
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
        <div class="nav navbar-inverse">
            <?php require_once 'menu.php'; ?>       
        </div>
        <br />
        <div class="container">
            <form class="form-horizontal" method="post" action="usuario_fn.php?acao=atualizar&id=<?= $edit->usuario_id ?>">
                <div class="rows">    
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div>
                                <h2 class="panel-title" style="font-family: 'Oswald', sans-serif;">Atualizar Usuário</h2>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="letras">
                                <div class="col-md-8">
                                    <div class="form-group well well-sm">
                                        <label for="usuario_nome" class="text-primary" >Nome</label>
                                        <input type="text" class="form-control" id="usuario_nome"  name="usuario_nome" placeholder="Nome" value="<?= $edit->usuario_nome ?>">
                                    </div>  

                                    <div class="form-group well well-sm">
                                        <label for="usuario_email" class="text-primary">Email</label>
                                        <input type="text" class="form-control" id="usuario_email"  name="usuario_email" placeholder="Email" value="<?= $edit->usuario_email ?>">
                                    </div>                    

                                    <div class="form-group well well-sm">
                                        <label for="usuario_login" class="text-primary">Login</label>
                                        <input type="text" class="form-control" id="usuario_login"  name="usuario_login" placeholder="Login" value="<?= $edit->usuario_login ?>">
                                    </div>
                                    <div class="form-group well well-sm">
                                        <label for="usuario_senha" class="text-primary">Senha</label>
                                        <input type="password" class="form-control" id="usuario_senha"  name="usuario_senha" placeholder="Senha">
                                    </div>

                                    <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Atualizar</button>
                                </div>
                                <div class="col-md-4">
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </form>
        </div>
        <script src="../js/jquery-1.11.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>     
        <script src="../js/main.js"></script>
        <script>$('#user').addClass('active');</script>
        <?php
        if (isset($_GET['ok'])) {
            ?>
            <script>
                $('.panel-title').html('Projeto atualizado com sucesso!');
                $('.panel')
                        .removeClass('panel-default')
                        .addClass('panel-success');
                setTimeout(function () {
                    $('.panel')
                            .removeClass('panel-success')
                            .addClass('panel-default');
                    $('.panel-title').html('Editar Projeto');
                }, 2000)
            </script>            
            <?php
        }

        if (isset($_GET['erro'])) {
            ?>
            <script>
                $('.panel-title').html('Erro ao atualizar: Upload');
                $('.panel')
                        .removeClass('panel-default')
                        .addClass('panel-danger');
                setTimeout(function () {
                    $('.panel')
                            .removeClass('panel-danger')
                            .addClass('panel-default');
                    $('.panel-title').html('Editar Projeto');
                }, 100000)
            </script>            
            <?php
        }
        ?>
    </body>
</html>
