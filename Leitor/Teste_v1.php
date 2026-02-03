<?php

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leitor de txt</title>
</head>
<body>
    <style>
        *{ margin: 0; padding: 0; box-sizing: border-box; border: none; }
        .Card{
            width: 10rem;
            border: 1px solid red;
            padding: 6px;

            display: flex;
            flex-direction: column;
            align-items: start;
            justify-content: center;
            transition: scale 0.3s ease;
        }

        .img_Prod, img{
            max-width: 100%;
            height: auto;
        }

        .Desc_Prod{
            display: flex;
            flex-direction: column;
            align-items: start;
            justify-content: center;
            padding: 6px;
        }

        button{
            width: 100%;
            padding: 8px;
            background-color: green;
            border-radius: 8px;
            font-size: 0.8rem;
            color: black;
            font-weight: 700;
            transition: scale 0.5s ease;
        }

        button:hover, .Card:hover{
            scale: 0.95;
            cursor: pointer;
        }
    </style>

    <div class="Card">
        <div class="img_Prod"> <img src="https://www.hortifrutiorganico.com.br/120-large_default/banana-organica-prata-500g.jpg" alt="img_Produto"> </div>
        <div class="Desc_Prod">
            <p>Estoque: <span class="Tem_Prod">145.880kg</span></p>
            <span class="Nome_Prod">Banana Caturra</span>
            <span class="Preco_Prod">R$ 3.99</span>
        </div>
        <button>Comprar</button>
    </div>
</body>
</html>