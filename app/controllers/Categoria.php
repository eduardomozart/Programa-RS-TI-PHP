<?php

require_once 'Login.php';

class Categoria extends Controller {

    private $login;

    public function __construct() {
        $this->login = new Login();
    }

    public function addCategory($nomeCategoria) {
        if($this->login->estaLogado()) {
            $categorias = $this->model('Categorias');
            return $categorias->addCategory($nomeCategoria);
        }
    }

    public function editCategory($idCategoria, $nomeCategoria) {
        if($this->login->estaLogado()) {
            $categorias = $this->model('Categorias');
            return $categorias->editCategory($idCategoria, $nomeCategoria);
        }
    }
}