<?php
$link = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4FjIt36dtAb6NUmr4aCZmWGhkkcOmRxa2Zw&s";

function lerCategorias(string $arquivo): array {
    if(!file_exists($arquivo) || !is_readable($arquivo)) {
        throw new Exception("Arquivo não <b>Encontrado</b> ou não <b>Legível</b>: $arquivo");
    }

    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $dados = [];

    foreach($linhas as $linha){

        list($categoria, $produtosStr) = explode(":", $linha);
        $produtos = array_map("trim", explode(",", $produtosStr));

        foreach($produtos as $p){ // Nome=Preço/Unidade|Imagem

            list($nome, $resto) = explode("=", $p);
            list($preco_UN, $img) = explode("|", $resto);
            list($preco, $tipo) = explode("/", $preco_UN);

            $dados[trim($categoria)][] = [
                "Nome"      => trim($nome),
                "Preço"     => (float) trim($preco),
                "Tipo"      => trim($tipo),
                "IMG"       => trim($img)
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
    $categorias = lerCategorias(__DIR__ . "/Documentos txt/Com_imgs.txt");
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
                            <img src="imagens/<?= $item["IMG"] ?>" alt="img do Produto">
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