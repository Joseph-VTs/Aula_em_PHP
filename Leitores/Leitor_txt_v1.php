<?php
# 1.Verificar Existência e Permissão
$path = __DIR__ . '/produtos.txt';
if(!file_exists($path) || !is_readable($path)){
    die("Arquivo não <b>Encontrado</b> ou não <b>Legível</b>");
}

# 2.Ler tudo de uma vez(arquivos pequenos)
$conteudo = file_get_contents($path);
$linhas = explode(PHP_EOL, $conteudo);

# 3.Ler linha a linha(simples)
$linhas = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
?>