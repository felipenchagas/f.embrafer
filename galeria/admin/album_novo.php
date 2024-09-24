<?php

@session_start();

if ($_SESSION['LOGADO'] == FALSE) {

    @header('location:login.php');

    exit;

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

        <div class="nav navbar-inverse">

            <?php require_once 'menu.php'; ?>       

        </div>

        <br />

        <div class="container">

            <div class="rows">

                <form name="demoFiler" id="demoFiler" enctype="multipart/form-data" method="post"

                      action="album_fn.php?acao=incluir">

                    <div class="panel panel-primary">

                        <div class="panel-heading">

                            <h2 class="panel-title">Cadastrar Álbum </h2>

                        </div>

                        <div class="panel-body text-muted">

                            <?php

                            require_once '../class/Albumcat.php';

                            $msg = ('Precisa ter uma categoria cadastrada');

                            $cat = new Albumcat();

                            $cat->getAlbumcats();

                            ?>

                            <div class="form-group well well-sm">

                                <label>Categoria do Álbum</label>

                                <select required class="form-control" id="album_albumcat" name="album_albumcat">

                                    <option value="">Selecione a categoria...</option>

                                    <?php

                                    if ($cat->bd->data >= 1) {

                                        foreach ($cat->bd->data as $c) {

                                            ?> 

                                            <option value="<?= $c->albumcat_id ?>"><?= $c->albumcat_nome ?></option>

                                            <?php

                                        }

                                    } else {

                                        ?>

                                        <option value="x">Cadastrar nova categoria...</option> 

                                        <?php

                                    }

                                    ?>

                                </select>

                            </div> 

                            <div class="form-group well well-sm">

                                <label for="album_nome">Nome do Álbum</label>

                                <input type="text" class="form-control" id="album_nome"  name="album_nome" required="" placeholder="">

                            </div>

                            <div class="form-group well well-sm">

                                <label for="album_nome">Efeito do Álbum</label>

				<select name="album_fx" id="album_fx">

					<option value="">Nenhum</option>

					<option value="randomrot">Random Rot</option>

					<option value="fan">Fan</option>

					<option value="coverflow">Cover Flow</option>

					<option value="queue">Queue</option>

					<option value="spread">Spread</option>

					<option value="fanout">Fan Out</option>

					<option value="sideslide">Slides Slide</option>

					<option value="sidegrid">Side Grid</option>

					<option value="bouncygrid">Bouncy Grid</option>

					<option value="previewgrid">Preview GRid</option>

					<option value="cornergrid">Corner Grid</option>

					<option value="leaflet">Leaf Let</option>

					<option value="vertspread">Vert Spread</option>

					<option value="vertelastic">Vert Elastic</option>

				</select>

                            </div>

                            <button type="submit"  value="Confirmar" onclick="confirmar()" class="btn btn-primary">Cadastrar e Enviar Fotos >>></button>

                        </div>

                    </div>

                </form>

                <div class="progressBar">

                    <div class="status"></div>

                </div>

            </div>

        </div>

    </div>

</div>  

<script src="../js/jquery-1.11.1.min.js"></script>

<script src="../js/bootstrap.min.js"></script>   

<script type="text/javascript" src="../js/main.js"></script>

<script type="text/javascript">

    $('#album').addClass('active');

    $('#album_albumcat').on('change', function () {

        if ($('#album_albumcat option:selected').val() === 'x') {

            window.location = 'albumcat.php';

            return false;

        }

    });

</script>

</body>

</html>



