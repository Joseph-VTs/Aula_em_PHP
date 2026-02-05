<?php
$link = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4FjIt36dtAb6NUmr4aCZmWGhkkcOmRxa2Zw&s";

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
            list($nome, $preco_UN) = explode("=", $p);
            // Separa preço e tipo
            list($preco, $tipo) = explode("/", $preco_UN);

            // 5.Montagem do array final
            # $dados[trim($categoria)] = $produtos;
            # Cria um array associativo onde a chave é a categoria e o valor é a lista de produtos.
            $dados[trim($categoria)][] = [
                "Nome" => trim($nome),
                "Preço" => (float) trim($preco),
                "Tipo" => trim($tipo)
            ];
        }
    }

    return $dados;
}

function ler_UN_KG(string $arquivo): array {
    if(!file_exists($arquivo) || !is_readable($arquivo)){
        throw new Exception("Arquivo não <b>Encontrado</b> ou não <b>Legível</b>: $arquivo");
    }

    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $dados = [];

    foreach($linhas as $linha){
        // Ignora Comentários (#)
        if(strpos(trim($linha), "#") == 0) continue;

        list($produto, $tipo) = explode("=", $linha);
        $dados[trim($produto)] = trim($tipo);
    }

    return $dados;
}

try{
    $categorias = lerCategorias(__DIR__ . "/UN_KG.txt");
} catch(Exception $e){
    echo "<p style='color:red'>Erro: " . $e->getMessage() . "</p>";
    exit;
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
    <?php foreach($categorias as $categoria => $produtos): ?>
        <h2><?= $categoria ?></h2>
        <div id="<?= strtolower($categoria) ?>" style="padding: 12px; display: grid; grid-template-columns: repeat(auto-fill, minmax(10rem, 1fr)); gap: 8px;">
            
            <?php foreach($produtos as $item): ?>
                <div class="Card">
                    <div class="Desc_Prod">

                        <div class="img_Prod">
                            <img src="<?= $link ?>" alt="img do Produto">
                        </div>

                        <p>Estoque: <?= mt_rand(0, 501) . " " . $item["Tipo"] ?> </p>
                        <span> <?= $item["Nome"] ?> </span>
                        <span>
                            R$ <?= number_format($item["Preço"] - (0.01), 2, ',', '.') ?> 
                            / <?= $item["Tipo"] ?> 
                        </span>
                        <button>Comprar</button>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    <?php endforeach; ?>
</body>
</html>