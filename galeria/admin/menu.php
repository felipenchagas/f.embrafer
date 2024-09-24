  
<div class="container">
    <div class="row">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Menu</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand visible-xs" href="#">Menu</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li id="home">
                    <a href="index.php">
                        <i class="fa fa-home"></i> 
                        HOME
                    </a>
                </li>
	        <li id="categoria"><a href="albumcat.php"><i class="fa fa-folder"></i>  CATEGORIAS</a></li>
                <li id="album"><a href="album.php"><i class="fa fa-camera"></i> ÁLBUNS</a></li>
                <li id="slide"><a href="slide.php"><i class="fa fa-exchange"></i> SLIDESHOW</a></li>
                <li id="user"><a href="usuario.php"> <i class="fa fa-group"></i> USUÁRIOS </a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i> 
                        <?=$_SESSION['USER']['NOME']?> 
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="usuario_editar.php?id=<?=$_SESSION['USER']['ID']?>"><i class="fa fa-refresh"></i> Mudar Senha</a></li>
                        <li><a href="login.php?sair=ok"><i class="fa fa-circle-o-notch"></i>  Sair</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
