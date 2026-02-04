<?php
$link = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4FjIt36dtAb6NUmr4aCZmWGhkkcOmRxa2Zw&s";
$estoque = "394.795";

function lerCategorias(string $arquivo): array {

    // 1.Verificação do arquivo
    # file_exists() → checa se o arquivo existe.
    # is_readable() → checa se pode ser lido.
    if(!file_exists($arquivo) || !is_readable($arquivo)) {
        throw new Exception("Arquivo não <b>Encontrado</b> ou não <b>Legível</b>: $arquivo");
    }

    // 2.Leitura das linhas
    # file() → lê todas as linhas do arquivo em um array.
    # FILE_IGNORE_NEW_LINES → remove quebras de linha.
    # FILE_SKIP_EMPTY_LINES → ignora linhas vazias.
    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $dados = [];

    // 3.Separação da categoria e produtos
    # explode(":", $linha) → divide a linha em duas partes:
    # Antes dos : → categoria (ex.: "Frutas").
    # Depois dos : → lista de produtos.
    foreach($linhas as $linha){ // Divide categoria e lista de produtos

        // 4.Separação dos produtos
        # explode(",", $produtosStr) → divide os produtos pela vírgula.
        list($categoria, $produtosStr) = explode(":", $linha);

        # array_map("trim", ...) → remove espaços extras de cada produto.
        $produtos = array_map("trim", explode(",", $produtosStr));

        foreach($produtos as $p){ // Divide Produtos e Preços
            list($nome, $preco) = explode("=", $p);

            // 5.Montagem do array final
            # $dados[trim($categoria)] = $produtos;
            # Cria um array associativo onde a chave é a categoria e o valor é a lista de produtos.
            $dados[trim($categoria)][] = [
                "Nome" => trim($nome),
                "Preço" => (float) trim($preco)
            ];
        }
    }

    return $dados;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_default.css">
    <title>Teste de Leitor Horti.txt</title>
</head>
<body>
    <?php
        try{
            $categoria = lerCategorias(__DIR__ . "/produtos.txt");

            foreach($categoria as $categoria => $produtos){
                echo '<h2>' . $categoria . '</h2>';
                echo '<div class="' . strtolower($categoria) . '" style="padding: 12px; display: grid; grid-template-columns: repeat(auto-fill, minmax(10rem, 1fr)); gap: 8px;">';
                foreach($produtos as $item){
                    echo '<div class="Card">';
                        echo '<div class="Desc_Prod">';
                            echo '<div class="img_Prod"> <img src ="' . $link . '" alt="img_Produto"> </div>'; // img Produto
                            echo '<p>Estoque: ' . $estoque . '</p>';
                            echo '<span>' . $item["Nome"] . '</span>';
                            echo '<span> R$ ' . number_format($item["Preço"], 2, ',', '.') . ' / kg</span>';
                            echo '<button>Comprar</button>';
                        echo '</div>';
                    echo '</div>';
                }

                echo '</div>';
            }
        } catch(Exception $e){
            echo "<p style='color:red'>Erro: " . $e->getMessage() . "</p>";
        }
    ?>
</body>
</html>