<!DOCTYPE html>
<html lang="pt-br">

<?php
require_once('template/head.php');

?>

<body>
    <div id="detalhes">
        <div class="header">
            <button class="back">
                <a href="<?php echo BASE_URL; ?>index.php?url=menu">
                    <img src="<?php echo BASE_URL; ?>assets/img/left-arrow.png" alt="">
                </a>
            </button>
            <h2>Detalhes</h2>
            <button class="favorite">
                <img src="<?php echo BASE_URL; ?>assets/img/heart.png" alt="">
            </button>
        </div>

        <div class="image-container">
            <img src="<?php echo BASE_URL; ?>assets/img/Image.png" alt="Caffe Mocha">
        </div>

        <div class="content">
            <div class="title-row">
                <h3>Caffe Mocha</h3>
                <div class="icons">
                    <div class="icon">&#9749;</div>
                    <div class="icon">&#128230;</div>
                </div>
            </div>

            <div class="rating">

                <span class="rating-number">4.8</span>
                <span class="reviews">(230)</span>
            </div>

            <h4>Description</h4>
            <p class="description">
                A cappuccino is an approximately 150 ml (5 oz) beverage,
                with 25 ml of espresso coffee and 85ml of fresh milk the fo...
                <span class="read-more">Read More</span>
            </p>

            <h4>Size</h4>
            <div class="sizes">
                <button class="size">S</button>
                <button class="size active">M</button>
                <button class="size">L</button>
            </div>
        </div>

        <nav class="footerSection">
            <div class="footer">
                <div class="price">
                    <span class="label">Price</span>
                    <span class="amount">$ 4.53</span>
                </div>
                <a href="<?php echo BASE_URL; ?>index.php?url=pedidos">
                    <button class="reserve">Reservar</button>
                </a>
            </div>
        </nav>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Tabela de preços por tamanho
            const precos = {
                S: 3.50,
                M: 4.53,
                L: 5.75
            };

            // Evento de clique nos botões de tamanho
            $('.size').click(function() {
                // Remove a classe ativa dos outros botões
                $('.size').removeClass('active');
                // Adiciona classe ativa no botão clicado
                $(this).addClass('active');
                // Pega o texto do botão (S, M ou L)
                const tamanho = $(this).text();
                // Atualiza o preço
                $('.amount').text(`$ ${precos[tamanho].toFixed(2)}`);
            });
        });
    </script>


</body>

</html>