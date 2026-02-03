<?php
function lerTxt(string $arquivo): array {
    // 1. Verificação de existência e leitura
    if (!file_exists($arquivo)) {
        throw new Exception("Arquivo não encontrado: $arquivo");
    }
    if (!is_readable($arquivo)) {
        throw new Exception("Arquivo não pode ser lido: $arquivo");
    }

    // 2. Leitura segura linha por linha
    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // 3. Tratamento: remove espaços extras
    $linhas = array_map('trim', $linhas);

    // 4. Retorna array pronto para uso
    return $linhas;
}

$link = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4FjIt36dtAb6NUmr4aCZmWGhkkcOmRxa2Zw&s";
$estoque = "345.870";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_default.css">
    <title>Leitor de txt</title>
</head>
<body>


    <div class="Prods">
        <?php
            try{
            $dados = lerTxt(__DIR__ . "/produtos.txt");
            
            foreach ($dados as $i => $linha) {
                echo '<div class="Card">';
                echo '<div class="img_Prod"> <img src ="' . $link . '" alt="img_Produto"> </div>'; // img Produto
                    echo '<div class="Desc_Prod">';
                        echo '<p>Estoque: ' . $estoque . '</p>';
                        echo '<span>' . $linha .  '</span>'; // Nome Produto
                        echo '<span>' . $i . '</span>'; // Preço Produto
                    echo '</div>';
                    echo '<button>Comprar</button>';
                echo '</div>';
                    }
            } catch (Exception $e) {
                echo "<p style='color:red'>Erro: " . $e->getMessage() . "</p>";
            }
        ?>
    </div>
</body>
</html>