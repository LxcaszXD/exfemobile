<!DOCTYPE html>
<html lang="pt-br">

<?php
require_once('template/head.php');

?>

<body>
    <?php
    // Garante que $produto está definido para evitar warning
    $produto = isset($produto) ? $produto : null;
    ?>

    <?php if ($produto): ?>
        <div id="detalhes">
            <div class="header">
                <button class="back">
                    <a href="<?php echo BASE_URL; ?>index.php?url=menu">
                        <img src="<?php echo BASE_URL; ?>assets/img/left-arrow.png" alt="Voltar">
                    </a>
                </button>
                <h2>Detalhes</h2>
                <button class="favorite">
                    <img src="<?php echo BASE_URL; ?>assets/img/heart.png" alt="Favorito">
                </button>
            </div>

            <div class="image-container">
                <img src="<?php echo BASE_URL_FOTO . 'img/' . htmlspecialchars($produto['foto_produto']); ?>" alt="<?php echo htmlspecialchars($produto['nome_produto']); ?>">
            </div>

            <div class="content">
                <div class="title-row">
                    <h3><?php echo htmlspecialchars($produto['nome_produto']); ?></h3>
                    <div class="icons">
                        <div class="icon">&#9749;</div>
                        <div class="icon">&#128230;</div>
                    </div>
                </div>

                <div class="rating">
                    <span class="rating-number">4.8</span>
                    <span class="reviews">(230)</span>
                </div>

                <h4>Descrição</h4>
                <p class="description"><?php echo htmlspecialchars($produto['descricao_produto']); ?></p>

                <h4>Tamanhos</h4>
                <div class="sizes">
                    <?php
                    $tamanhos = explode(',', $produto['tamanho_produto']);
                    foreach ($tamanhos as $tamanho): ?>
                        <button class="size"><?php echo strtoupper(trim($tamanho)); ?></button>
                    <?php endforeach; ?>
                </div>
            </div>

            <nav class="footerSection">
                <div class="footer">
                    <div class="price">
                        <span class="label">Preço</span>
                        <span class="amount">R$ <?php echo number_format($produto['preco_produto'], 2, ',', '.'); ?></span>
                    </div>
                    <a href="<?php echo BASE_URL; ?>index.php?url=pedidos">
                        <button class="reserve">Reservar</button>
                    </a>
                </div>
            </nav>
        </div>
    <?php else: ?>
        <p style="text-align: center; color: red;">Produto não encontrado.</p>
    <?php endif; ?>





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