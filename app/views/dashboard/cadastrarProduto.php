<?php
var_dump($data);
// Se a Controller passou informações do produto, ou seja, estamos editando um produto existente,
// Define o valor da variável $produto com as informações do produto retornadas pela Controller,
// Caso contrário (??), define o valor de $produto como nulo (vazio).
$produto = $data['produto'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        if (isset($produto)) {
            // Se estamos editando um $produto existente
            echo 'Editar Produto - #' . $produto->id;
        } else {
            // $produto não existe ao cadastrar um produto 
            // (afinal, ele não foi cadastrado ainda)
            echo 'Cadastro de Produtos';
        }
        ?>
    </title>
    <script type="text/javascript" src="/js/cadastrarProduto.js" defer="defer"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            font-weight: bold;
        }

        input,
        select,
        textarea,
        button {
            margin-top: 5px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="file"] {
            padding: 0;
        }

        button {
            margin-top: 20px;
            /* background-color: #28a745; */
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        /* button:hover {
    background-color: #218838;
} */

        /* Placeholders */
        ::placeholder,
        .dropdown-btn {
            color: gray;
            opacity: 1;
            /* Firefox */
        }

        ::-ms-input-placeholder {
            /* Edge 12 -18 */
            color: gray;
        }

        /* Dropdown de categoria */
        .dropdown {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .dropdown-btn {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            cursor: pointer;
            text-align: left;
            font-weight: normal;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            width: 100%;
        }

        .dropdown-content label {
            display: flex;
            /* justify-content: space-between; */
            align-items: center;
            padding: 8px;
            cursor: pointer;
            font-weight: normal;
        }

        .dropdown-content label:hover {
            background-color: #f0f0f0;
        }

        .dropdown-content input[type="checkbox"] {
            margin-right: 10px;
        }

        .dropdown.open .dropdown-content {
            display: block;
        }

        .edit-btn, #add-btn {
            background: none;
            border: none;
            color: #007BFF;
            cursor: pointer;
            font-size: 14px;
            margin-top: 0;
            /* Posiciona o link à esquerda */
            margin: 0 auto;
            margin-right: 0;
            font-weight: bold;
        }

        .edit-btn:hover, #add-btn:hover {
            text-decoration: underline;
        }

        #add-btn {
            position: absolute;
            right: 15px;
        }

        /* Modal de edição de categoria */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2000;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .modal-header {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .modal-footer {
            text-align: right;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007BFF;
            color: #fff;
        }

        .btn-secondary {
            background-color: #ccc;
            color: #000;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>
            <?php
            if (isset($produto)) {
                // Se estamos editando um $produto existente
                echo 'Editar Produto - #' . $produto->id;
            } else {
                // $produto não existe ao cadastrar um produto 
                // (afinal, ele não foi cadastrado ainda)
                echo 'Cadastro de Produtos';
            }
            ?>
        </h1>
        <form action="/Produto/addProduto" method="POST" enctype="multipart/form-data">
            <!-- Nome do Produto -->
            <label for="nome">Nome do Produto:</label>
            <input type="text" id="nome" name="nome" placeholder="Ex: Violão Acústico"
                value="<?php echo (isset($produto->nome) ? $produto->nome : '') ?>" required>

            <!-- Categoria do Produto -->
            <label for="categoria">Categoria:</label>
            <div class="dropdown">
                <button type="button" class="dropdown-btn">Selecione a(s) categoria(s) <span id="add-btn">Adicionar</span></button>
                <div class="dropdown-content" id="categoryDropdown">
                    <?php
                    $categorias = $data['categorias'];
                    foreach ($categorias as $categoria) {
                        echo '<label>
                                <input type="checkbox" value="' . $categoria->id . '" name="categorias[]">'
                                . $categoria->nome .
                                '<button type="button" class="edit-btn">Editar</button>
                            </label>';
                    }
                    ?>
                </div>
            </div>

            <!-- Cor do Produto -->
            <label for="cor">Cor:</label>
            <input type="text" id="cor" name="cor" placeholder="Ex: Preto, Natural, Vermelho" required>

            <!-- Preço -->
            <label for="preco">Preço (R$):</label>
            <input type="number" id="preco" name="preco" step="0.01" placeholder="Ex: 599.99" required>

            <!-- Descrição -->
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="4" placeholder="Descreva o produto..." required></textarea>

            <!-- Fotos -->
            <label for="fotos">Fotos do Produto:</label>
            <input type="file" id="fotos" name="fotos" accept="image/*" multiple required>

            <!-- Botão de envio -->
            <button type="submit">Cadastrar Produto</button>
        </form>
    </div>

    <!-- Modal de edição de categorias -->
    <div class="modal-overlay"></div>
    <div class="modal" id="editModal">
        <div class="modal-header" id="modal-header">Editar Categoria</div>
        <div class="modal-body">
            <label for="editCategoryName">Nome:</label>
            <input type="text" id="editCategoryName" class="form-control" placeholder="Digite o nome">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="saveCategory">Salvar</button>
        </div>
    </div>
</body>

</html>