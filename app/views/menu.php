<!DOCTYPE html>
<html lang="pt-br">

<?php
require_once('template/head.php');

?>

<body>
    <section id="menu">

        <div class="banner-container">
            <div class="banner-perfil">
                <div class="txt">
                    <?php
                    $primeiroNome = explode(" ", $nome_cliente)[0];
                    ?>
                    <h3>Bem vindo, <?php echo $primeiroNome; ?>!</h3>
                    <h3>Seu café te espera!</h3>
                </div>

                <div class="foto-perfil">
                    <a href="<?php echo BASE_URL; ?>index.php?url=perfil">
                        <?php
                        $imagemPadrao = BASE_URL_FOTO . 'sem-foto-cliente.png';
                        $fotoCliente = !empty($cliente['foto_cliente']) ? BASE_URL_FOTO . $cliente['foto_cliente'] : $imagemPadrao;
                        ?>
                        <img src="<?php echo $fotoCliente; ?>" alt="Foto do cliente" style="width: 50px; height: 50px; border-radius: 50%;">
                    </a>
                </div>


            </div>

            <div class="pesquisa">
                <div class="pesquisar">
                    <div class="pes">
                        <img src="<?php echo BASE_URL; ?>assets/img/lupa (2).png" alt="">
                        <h5>Pesquisar Café</h5>
                    </div>
                </div>

                <div class="config">
                    <img src="<?php echo BASE_URL; ?>assets/img/setting-lines (3).png" alt="">
                </div>
            </div>
        </div>

        <div class="promo">
            <div class="promocao">
                <img src="<?php echo BASE_URL; ?>assets/img/Banner 1.png" alt="">
            </div>
            <div class="escritasPromo">
                <h5>Promo</h5>
            </div>
            <div class="escritasFree">
                <h6>Buy one get</h6>
                <h6><span>one FREE</span></h6>
            </div>
        </div>

        <div class="filtro">
            <div class="filtros">
                <button data-filtro="Todos" class="ativo">Todos</button>
                <button data-filtro="Cafés Tradicionais">Cafés</button>
                <button data-filtro="Chás">Chás</button>
                <button data-filtro="Sobremesas">Sobremesas</button>
                <button data-filtro="Pães">Pães</button>
            </div>
        </div>

        <div class="lista">
            <?php if (!empty($produtos)):
                foreach ($produtos as $produto): ?>
                    <div class="card" data-tipo="<?php echo htmlspecialchars($produto['nome_categoria']); ?>">
                        
                        <?php
                        $imagemPadraoProduto = BASE_URL_FOTO . 'sem-foto-produto.png'; // Ex: imagem padrão no servidor
                        $fotoProduto = !empty($produto['foto_produto']) ? BASE_URL_FOTO . $produto['foto_produto'] : $imagemPadraoProduto;
                        ?>

                        <img src="<?php echo $fotoProduto; ?>" alt="<?php echo htmlspecialchars($produto['nome_produto']); ?>" style="width: 100px; height: auto; object-fit: cover;">
                        
                        <h3><?php echo htmlspecialchars($produto['nome_produto']); ?></h3>
                        <p><?php echo htmlspecialchars($produto['nome_categoria']); ?></p>
                        <div class="card-footer">
                            <strong>R$ <?php echo number_format($produto['preco_produto'], 2, ',', '.'); ?></strong>
                            <button class="btn-info">
                                <a href="<?php echo BASE_URL . 'index.php?url=detalhe&id=' . $produto['id_produto']; ?>">+</a>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhum produto encontrado para esta categoria.</p>
            <?php endif; ?>
        </div>


        <nav class="footer-section">
            <a href="" class="active"><i class='bx bxs-home-alt-2 '></i></a>
            <a href="<?php echo BASE_URL; ?>index.php?url=avaliacao"><i class='bx bx-heart'></i></a>
            <a href="<?php echo BASE_URL; ?>index.php?url=pedidos"><i class='bx bx-shopping-bag'></i></a>
            <a href=""><i class='bx bx-bell'></i></a>
        </nav>

    </section>

    <script src="script/script.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script>
        $(document).ready(function() {
            $('.filtros button').click(function() {
                const filtro = $(this).attr('data-filtro');

                $('.filtros button').removeClass('ativo');
                $(this).addClass('ativo');

                if (filtro === 'All') {
                    $('.card').show();
                } else {
                    $('.card').hide();
                    $('.card').filter(`[data-tipo="${filtro}"]`).show();
                }
            });
        });
    </script> -->

    <script>
        // Aguarda o carregamento completo do DOM
        document.addEventListener('DOMContentLoaded', function() {
            const botoesFiltro = document.querySelectorAll('.filtros button');
            const cards = document.querySelectorAll('.lista .card');

            botoesFiltro.forEach(botao => {
                botao.addEventListener('click', function() {
                    const categoriaSelecionada = this.getAttribute('data-filtro');

                    // Remove classe "ativo" de todos os botões
                    botoesFiltro.forEach(b => b.classList.remove('ativo'));
                    // Adiciona classe "ativo" no botão clicado
                    this.classList.add('ativo');

                    cards.forEach(card => {
                        const tipoCard = card.getAttribute('data-tipo');

                        if (categoriaSelecionada === 'Todos' || tipoCard === categoriaSelecionada) {
                            card.style.display = 'flex'; // ou 'block' conforme seu layout
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>


</body>

</html>