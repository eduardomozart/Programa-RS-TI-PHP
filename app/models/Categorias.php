<?php
class Categorias {
    public function getCategorias() {
        $sqlQuery = "SELECT * FROM categorias ORDER BY nome ASC";

        try {
            return Database::query($sqlQuery);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function addCategory($nomeCategoria) {
        $sqlQuery = "SELECT * FROM categorias WHERE nome = ?";
        try {
            $nomeCategoria = Database::query($sqlQuery, [$nomeCategoria]);

            if ($nomeCategoria == 0) {
                // Se a categoria não existe no banco de dados (SELECT retornou '0'),
                // Inserir nova categoria no banco de dados.
                $sqlQuery = "INSERT INTO categorias(nome) VALUES (?)";

                try {
                    // Retorna o ID da nova categoria inserida no banco de dados.
                    return Database::query($sqlQuery, [$nomeCategoria]);
                } catch (\PDOException $e) {
                    exit($e->getMessage());
                }
            } else {
                // Se a categoria já existe no banco de dados (SELECT retornou > 0),
                // Retorna o valor "-1" caso a categoria já exista no banco de dados.
                return -1;
            }
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }   
    }

    public function editCategory($idCategoria, $nomeCategoria) {
        $sqlQuery = "UPDATE categorias SET nome = ? WHERE id = ?";

        try {
            return Database::query($sqlQuery, [$nomeCategoria, $idCategoria]);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}