<nav class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed"
                data-toggle="collapse" data-target="#nav-col-1">
            <span class="sr-only">Menu</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand visible-xs" href="#"> &nbsp; MENU</a>
    </div>
    <div class="collapse navbar-collapse" id="nav-col-1">
        <div class="container">
            <ul class="nav navbar-nav">
	        <a class="navbar-brand hidden-xs" href="index.php"> &nbsp; DREAM GALLERY 2.0</a>
                <li><a href="index.php"><i class="fa fa-home"></i> HOME</a></li>
                <li><a href="demo.php"><i class="fa fa-bolt"></i> DEMO</a></li>
                <li class="dropdown" id="album">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-folder"></i>  
                        CATEGORIAS
                    </a>
                    <ul class="dropdown-menu" role="menu">
			
			<?php 
			require_once 'class/Albumcat.php';
			$cat = new Albumcat();
			$cat->getAlbumcats();
			?>
                        <?php if (isset($cat->bd->data[0])): ?>
                            <?php foreach ($cat->bd->data as $c): ?>
                                <li>
                                    <a href="index.php?categoria=<?= $c->albumcat_id ?>">
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
