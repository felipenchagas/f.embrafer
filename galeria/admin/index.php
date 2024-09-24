<?php
/*
 * @App     Dream Gallery 2.0
 * @Author  Rafael Clares <falecom@phpstaff.com.br> 
 * @Web     www.phpstaff.com.br
 */
@session_start();
if ($_SESSION['LOGADO'] == FALSE) {
    @header('location:login.php');
    exit;
}
require_once '../class/Usuario.php';
$u = new Usuario();
$u->getUsuario();
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


        <h2 class="well well-sm  text-center"> <i class="fa fa-bolt"></i> ACESSO RÁPIDO</h2>
        <br/><br/><br/><br/>
        <div class="container">
            <div class="col-md-12">


                <div class="col-md-4">
                    <a href="album_novo.php" class="btn btn-lg btn-primary" 
                       data-toggle="tooltip" data-placement="top"
                       title="CRIAR NOVO ÁLBUM">
                        <i class="fa fa-camera"></i> NOVO ÁLBUM
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="albumcat.php" class="btn btn-lg btn-primary" 
                       data-toggle="tooltip" data-placement="top"
                       title="GERENCIAR CATEGORIAS">
                        <i class="fa fa-folder"></i> NOVA CATEGORIA
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="albumcat.php" class="btn btn-lg btn-primary" 
                       data-toggle="tooltip" data-placement="top"
                       title="GERENCIAR SLIDESHOW">
                        <i class="fa fa-exchange"></i> NOVO SLIDESHOW
                    </a>
                </div>
            </div>
            <script src="../js/jquery-1.11.1.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>       
            <script src="../js/main.js"></script>
            <script>
                $('#home').addClass('active');
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });
            </script>

    </body>
</html>
