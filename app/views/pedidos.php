<!DOCTYPE html>
<html lang="pt-br">

<?php
require_once('template/head.php');

?>

<body>
    <section id="pedidos">

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
                        <img src="<?php echo BASE_URL; ?>assets/img/imagePerfil.png" alt="">
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



        <div class="filtro">
            <div class="filtros">
                <button data-filtro="All" class="ativo">Pedidos</button>
            </div>
        </div>

        <div class="lista">
            <?php if (!empty($pedidos)) : ?>
                <?php foreach ($pedidos as $pedido) : ?>
                    <?php foreach ($pedido['itens'] as $item) : ?>
                        <div class="card">
                            <!-- Exibe um ícone ou imagem padrão -->
                            <img src="<?= BASE_URL ?>assets/img/cafe-default.png" alt="<?= htmlspecialchars($item['nome_produto']) ?>">
                            <h3><?= htmlspecialchars($item['nome_produto']) ?></h3>
                            <div class="card-footer">
                                <strong>Produto incluído</strong>
                                <button class="btn-info">
                                    <a href="<?= BASE_URL; ?>index.php?url=reserva">+</a>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Nenhum pedido encontrado.</p>
            <?php endif; ?>
        </div>

        <nav class="footer-section">
            <a href="" class="active"><i class='bx bxs-home-alt-2'></i></a>
            <a href=""><i class='bx bx-heart'></i></a>
            <a href="<?= BASE_URL; ?>index.php?url=pedidos"><i class='bx bx-shopping-bag'></i></a>
            <a href=""><i class='bx bx-bell'></i></a>
        </nav>


    </section>







    <script src="script/script.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>