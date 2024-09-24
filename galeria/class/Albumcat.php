<?php
/*
* @App     Dream Gallery 2.0
* @Author  Rafael Clares <falecom@phpstaff.com.br> 
* @Web     www.phpstaff.com.br
*/
class Albumcat {

    public $bd;
    public $albumcat_id;
    public $albumcat_nome;
    public $result;
    public $albumcat_todos = array();
    public $numRows = 0;

    public function __construct() {
        if (file_exists('../database/Connect.php')) {
            require_once '../database/Connect.php';
        } elseif (file_exists('database/Connect.php')) {
            require_once 'database/Connect.php';
        }
        $this->bd = new Conexao();
        $this->bd->conecta();
    }

    public function setId($albumcat_id) {
        $this->albumcat_id = $albumcat_id;
    }

    public function getId() {
        return $this->albumcat_id;
    }

    public function setNome($albumcat_nome) {
        $this->albumcat_nome = addslashes($albumcat_nome);
    }

    public function getNome() {
        return stripslashes($this->albumcat_nome);
    }

    public function incluir() {
        $sql = "INSERT INTO albumcat (albumcat_nome) VALUES";
        $sql .= "('$this->albumcat_nome')";
        $this->result = mysql_query($sql) or die(mysql_error());
    }

    public function atualizar() {
        $sql = "UPDATE albumcat SET ";
        $sql .= "albumcat_nome = '$this->albumcat_nome'";
        $sql .= "WHERE albumcat_id = $this->albumcat_id";
        $this->result = mysql_query($sql);
    }

    public function remover() {
        require_once '../class/Album.php';
        require_once '../class/Foto.php';
        $p = new Album();
        $p->setId($this->albumcat_id);
        $p->getAlbumByAlbumcat();
        if (isset($p->album_todos[0])) {
            foreach ($p->album_todos as $rem) {
                $p->setId($rem->album_id);
                $p->remover();
            }
        }
        $sql = "DELETE FROM albumcat WHERE albumcat_id = $this->albumcat_id";
        $this->result = mysql_query($sql) or die(mysql_error());
    }

    public function getAlbumcat() {
        $sql = "SELECT * FROM albumcat WHERE albumcat_id = $this->albumcat_id";
        $this->result = mysql_query($sql);
        if ($this->result) {
            while ($retorna = mysql_fetch_object($this->result)) {
                $this->setId($retorna->albumcat_id);
                $this->setNome($retorna->albumcat_nome);
            }
        }
    }

    public function getAlbumcats() {
        $sql = "SELECT * FROM albumcat";
        $this->bd->query("$sql")->fetchAll();
        $this->albumcat_todos = $this->bd->data;
    }

    public function albumExiste() {
        $sql = "SELECT * FROM album WHERE album_nome = '$this->album_nome'";
        $this->result = mysql_query($sql);
        if ($this->result) {
            if (mysql_num_rows($this->result) >= 1) {
                return true;
            } else {
                return false;
            }
        }
    }

}
