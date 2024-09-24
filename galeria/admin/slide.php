<?php
/*
 * @App     Dream Gallery 2.0
 * @Author  Rafael Clares <falecom@phpstaff.com.br> 
 * @Web     www.phpstaff.com.br
 */
@session_start();
if ($_SESSION['LOGADO'] == FALSE) {
    //redirect para o login
    header('Location: login.php');
    exit;
}
require_once '../class/Slide.php';
$slide = new Slide();
$slide->getImagens();
$slide->bd->url = "slide.php";
$slide->bd->paginate(8);
$slide->getImagens();
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
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="panel-title">
                        <span class="col-md-5">
                            <i class="fa fa-gears"></i> 
                            Gerenciar Slideshow
                        </span>
                        <span class="text-right">
                            <i class="glyphicon glyphicon-info-sign"></i> 
                            Dimensões ideais 1140 x 400
                        </span>
                    </h2>
                </div>
                <div class="panel-body text-muted">
                    <form  method="post" enctype="multipart/form-data" action="slide_fn.php?acao=incluir">
                        <div class="form-group well well-sm">				
			   <label>Selecione uma imagem</label>
                            <input type="file" class="form-control" id="slide_foto"  required name="slide_foto" placeholder="">
                        </div>

                        <div class="form-group well well-sm">		
			     <label>Link do Slide (opcional)</label>		
                            <input type="text" class="form-control" id="slide_link"  
				   name="slide_link" placeholder="ex: http://flickr.com/eu/">
                        </div>


                        <div class="form-group form-inline well well-sm">	
                            <button type="submit" class="btn btn-primary">
<i class="fa fa-plus-circle"></i> Cadastrar</button>
                        </div>



                        <br />
                    </form>

 <br /> <br />
                    <div >
                        <?php
                        if ($slide->bd->data >= 1) {
                            ?>
                            <table class="table table-striped">
                                <tr>
                                    <th>Slide</th> 
                                    <th>Link</th> 
                                    <th width="80">&nbsp;</th>
                                </tr>
                                <?php
                                foreach ($slide->bd->data as $s) {
                                    echo "<tr style=\"vertical-align: middle\">";
                                    echo "<td style=\"vertical-align: middle\"><img src=\"../fotos/slide/$s->slide_foto\" style=\"width:500px; height: 140px;\" /></td>";
                                    echo "<td style=\"vertical-align: middle\"><input type=\"text\" name=\"slide_link\" value=\"$s->slide_link\" placeholder=\"Link do slide\" style=\"width:400px\" id=\"$s->slide_id\" class=\"link\" /></td>";
                                    echo "<td style=\"vertical-align: middle\"><a class=\"btn btn-danger btn-remove\" data-url=\"slide_fn.php?acao=remover&id=$s->slide_id\"><i class=\"fa fa-trash-o\"></i></a>";
                                    echo "</tr style=\"vertical-align: middle\">";
                                }
                                ?>
                            </table>
                        <?php } else { ?>
                            <p class="alert alert-danger">Nenhum registro cadastrado!</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!---=========BEGIN MODAL=========-->
        <div class="modal fade" id="ModalRemove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                        <h4 class="modal-title" id="myModalLabel">Remover Registro</h4>
                    </div>
                    <div class="modal-body">
                        <h4>Atenção!</h4>
                        <p>
                            Você está prestes à excluir um registro de forma permanente.<br />
                            Deseja realmente executar este procedimento?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                        <button type="button" class="btn btn-danger" id="btn-confirm-remove"><i class="fa fa-check"></i> Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
        <!---=========END MODAL=========-->
        <div class="container"><?= $slide->bd->link ?></div>   
        <script src="../js/jquery-1.11.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>     
        <script src="../js/main.js"></script>
        <script>
            $('#slide').addClass('active');
            $('.btn-remove').on('click', function () {
                var url = $(this).attr('data-url');
                $('#ModalRemove').modal('show');
                $('#btn-confirm-remove').on('click', function () {
                    window.location = url;
                });
            });
	   $('.link').on('change',function(){
		var slide_id = $(this).attr('id');
		var slide_link = $(this).val();
		var url = 'slide_fn.php?acao=uplink';
		$.post(url,{slide_id:slide_id,slide_link:slide_link},function(data){
		  //console.log(data)
		_alert('Link atualizado com sucesso!')
	   });
	})
        </script>
    </body>
</html>
