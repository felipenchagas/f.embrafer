<?php
/*
 * @App     Dream Gallery 2.0
 * @Author  Rafael Clares <falecom@phpstaff.com.br> 
 * @Web     www.phpstaff.com.br
 */
require_once './class/Foto.php';
require_once 'class/Album.php';
require_once 'class/Albumcat.php';
$cat = new Albumcat();
$cat->getAlbumcats();
$album = new Album ();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.0/paper/bootstrap.min.css" rel="stylesheet">
        <link href='//fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="plugins/stack/css/component.css" rel="stylesheet" type="text/css">
        <link href="css/main.css" rel="stylesheet" type="text/css">	
        <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <title>EMBRAFER</title>
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
<nav class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed"
                data-toggle="collapse" data-target="#nav-col-1">
            <span class="sr-only">Menu</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand visible-xs" href="#"> &nbsp; Categorias</a>
    </div>
    <div class="collapse navbar-collapse" id="nav-col-1">
        <div class="container">
            <ul class="nav navbar-nav">
	        <a class="navbar-brand hidden-xs" href="demo.php"> &nbsp; DREAM GALLERY 2.0</a>
                <li><a href="demo.php"><i class="fa fa-home"></i> HOME</a></li>
                <li class="dropdown" id="album">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bolt"></i>  
                        EFEITOS
                    </a>
                    <ul class="dropdown-menu" role="menu">
			<?php 
			$fx_list = array(
			    'randomrot',
			    'fan',
			    'coverflow',
			    'queue',
			    'spread',
			    'fanout',
			    'sideslide',
			    'sidegrid',
			    'bouncygrid',
			    'previewgrid',
			    'cornergrid',
			    'leaflet',
			    'vertspread',
			    'vertelastic'
			);
			?>
		        <?php foreach ($fx_list as $ff): ?>
		                        <li>
		                            <a href="demo.php?fx=<?= $ff ?>">
		                                <?= $ff ?>
		                            </a> 
		                        </li>
		        <?php endforeach; ?>
                    </ul>
                </li>
                <li><a href="demo.php?slide"><i class="fa fa-exchange"></i> SLIDESHOW</a></li>

                <li class="dropdown" id="album">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-folder"></i>  
                        CATEGORIAS
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <?php if (isset($cat->bd->data[0])): ?>
                            <?php foreach ($cat->bd->data as $c): ?>
                                <li>
                                    <a href="demo.php?categoria=<?= $c->albumcat_id ?>">
                                        <?= $c->albumcat_nome ?>
                                    </a> 
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </li>


            </ul>
        </div>
    </div>
</nav>

	<!-- PARA INCLUIR O SLIDESHOW - REMOVA O COMENTARIO (#)  DA LINHA ABAIXO -->
        <?php if (isset($_GET['slide'])) { require_once 'slide.inc.php';} ?>

        <div class="container">
            <?php
            if (isset($_GET['categoria'])) :
                $cat_id = intval($_GET['categoria']);
                $album->bd->url = "demo.php?categoria=$cat_id";
                $album->bd->paginate(12);     //12 é o numero de itens por página              
                $album->getAlbumByCat($cat_id);
            else:
                $album->bd->url = "demo.php";
                $album->bd->paginate(12);  //12 é o numero de itens por página                              
                $album->getAlbuns();
            endif;
            if ($album->bd->data >= 1):
                foreach ($album->bd->data as $a):
			if (isset($_GET['fx'])) {
			    if (isset($fx_list[intval($_GET['fx'])])) {
				$a->album_fx = $fx_list[intval($_GET['fx'])];
			    }
			    $a->album_fx = $_GET['fx'];
			}


                    $foto = new Foto();
                    $pg = 4;
                    if ($a->album_fx == 'coverflow' || $a->album_fx == 'sideslide' || $a->album_fx == 'peekaboo') {
                        $pg = 3;
                    }
                    $foto->getFotosHome($a->album_id,$pg);
                    if (isset($foto->bd->data[0])) :
                        $tfoto = count($foto->bd->data);
                        ?>
                        <div class="col-md-3 col-xs-12 col-sm-12 album-d">
                            <section>
                                <figure class="stack stack-<?= $a->album_fx ?> <?= ($tfoto >= 2) ? 'for-active' : ''; ?>" id="<?= $a->album_id ?>">
                                    <?php
                                    foreach ($foto->bd->data as $f):
                                        if (isset($f->foto_url)):
                                            if (!file_exists("fotos/$f->foto_url")):
                                                $f->foto_url = "nopic.jpg";
                                            endif;
                                        else:
                                            $f->foto_url = "nopic.jpg";
                                        endif;
                                        ?>

                                        <img src="thumb.php?w=600&h=500&zc=1&src=fotos/<?= $f->foto_url ?>" 
                                             class=" img-responsive" style="max-height:500px;" />

                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </figure>
                            <h1> <?= $a->album_nome ?></h1>
                        </section>
                    </div>

                    <?php
                endforeach;
            endif;
            ?>
        </div>
        <div class="container"><?= $album->bd->link ?></div>
        <script src="js/jquery-1.11.1.min.js"></script>
        <script src="plugins/stack/js/classie.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
        <script>
            window.onload = function () {
                setTimeout(function () {
                    $('.for-active').addClass('active');
                }, 900);
                setTimeout(function () {
                    $('.for-active').removeClass('active');
	    	    // comente a linha acima de desejar que o efeito fique fixo ao 
		    // invés de aparece apenas quando passa o mouse
                }, 2000);
            }
            $('.for-active').hover(
                    function () {
                        $(this).addClass('active')
                    },
                    function () {
                        $(this).removeClass('active')
                    }
            );
            $('figure').on('click', function () {
                window.location = 'album.php?id=' + $(this).attr('id');
            });
            $('.efx').on('click', function () {
                window.location = 'demo.php?fx=' + $(this).attr('id') + '#album-set';
            });
        </script>
    </body>
</html>
