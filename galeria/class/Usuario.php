<?php
/*
* @App     Dream Gallery 2.0
* @Author  Rafael Clares <falecom@phpstaff.com.br> 
* @Web     www.phpstaff.com.br
*/
class Usuario {

    public $bd;
    public $usuario_id; //public - protected - private
    public $usuario_nome;
    public $usuario_email;
    public $usuario_senha;
    public $usuario_login;
    public $result;
    public $usuario_todos = array();

    public function __construct() {
        if (file_exists('../database/Connect.php')) {
            require_once '../database/Connect.php';
        } elseif (file_exists('database/Connect.php')) {
            require_once 'database/Connect.php';
        }
        $this->bd = new Conexao();
        $this->bd->conecta();
    }

    public function setId($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    public function getId() {
        return $this->usuario_id;
    }

    public function setNome($usuario_nome) {
        $this->usuario_nome = addslashes($usuario_nome);
    }

    public function getNome() {
        return stripslashes($this->usuario_nome);
    }

    /**
     * atribui email ao usuario
     */
    public function setEmail($usuario_email) {
        $this->usuario_email = $usuario_email;
    }

    public function getEmail() {
        return $this->usuario_email;
    }

    public function setSenha($usuario_senha) {
        $this->usuario_senha = $usuario_senha;
    }

    public function setLogin($usuario_login) {
        $this->usuario_login = $usuario_login;
    }

    public function getLogin() {
        $this->usuario_login;
    }

    public function incluir() {
        $sql = "INSERT INTO usuario (usuario_nome, usuario_email, usuario_senha, usuario_login) VALUES ";
        $sql .= "('$this->usuario_nome','$this->usuario_email','$this->usuario_senha' ,'$this->usuario_login')";
        $this->result = mysql_query($sql) or die(mysql_error());
    }

    public function getUsuario() {
        $sql = "SELECT * FROM usuario WHERE usuario_id = $this->usuario_id";
        $this->result = mysql_query($sql);
        if ($this->result) {
            while ($retorna = mysql_fetch_object($this->result)) {
                $this->setId($retorna->usuario_id);
                $this->setNome($retorna->usuario_nome);
                $this->setEmail($retorna->usuario_email);
                $this->setLogin($retorna->usuario_login);
            }
        }
    }

    public function getUsuarios() {
        $sql = "SELECT * FROM usuario";
        $this->bd->query("$sql")->fetchAll();
        $this->usuario_todos = $this->bd->data;
    }

    public function remover() {
        $sql = "DELETE FROM usuario WHERE usuario_id = $this->usuario_id";
        $this->result = mysql_query($sql);
    }

    public function atualizar() {
        $sql = "UPDATE usuario SET ";
        $sql .= "usuario_nome  = '$this->usuario_nome',  ";
        $sql .= "usuario_email = '$this->usuario_email', ";
        $sql .= "usuario_login = '$this->usuario_login'  ";
        if ($this->usuario_senha != "") {
            $sql .= ", usuario_senha = '$this->usuario_senha'";
        }
        $sql .= "WHERE usuario_id = $this->usuario_id";
        $this->result = mysql_query($sql);
    }

    public function emailExiste() {
        $sql = "SELECT * FROM usuario WHERE usuario_email = '$this->usuario_email'";
        $this->result = mysql_query($sql);
        if ($this->result) {
            if (mysql_num_rows($this->result) >= 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function loginExiste() {
        $sql = "SELECT * FROM usuario WHERE usuario_login = '$this->usuario_login'";
        $this->result = mysql_query($sql);
        if ($this->result) {
            if (mysql_num_rows($this->result) >= 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    //verifica se o login e senha são validos
    public function loginValido() {
        $sql = "SELECT * FROM usuario WHERE usuario_login = '$this->usuario_login' AND usuario_senha = '$this->usuario_senha' ";
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
