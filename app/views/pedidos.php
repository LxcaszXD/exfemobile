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
            <div class="card" data-tipo="Machiatto">
                <img src="<?php echo BASE_URL; ?>assets/img/mocha.png" alt="Caffe Mocha">
                <h3>Caffe Mocha</h3>
                <p>Machiatto</p>
                <div class="card-footer">
                    <strong>$4.53</strong>
                    <button class="btn-info">
                        <a href="<?php echo BASE_URL; ?>index.php?url=reserva">+</a>
                    </button>
                </div>
            </div>

            <div class="card" data-tipo="Latte">
                <img src="<?php echo BASE_URL; ?>assets/img/flat.png" alt="Flat White">
                <h3>Flat White</h3>
                <p>Latte</p>
                <div class="card-footer">
                    <strong>$3.53</strong>
                    <button class="btn-info">
                        <a href="<?php echo BASE_URL; ?>index.php?url=reserva">+</a>
                    </button>
                </div>
            </div>

            <div class="card" data-tipo="Americano">
                <img src="<?php echo BASE_URL; ?>assets/img/americano.png" alt="Americano">
                <h3>Americano</h3>
                <p>Americano</p>
                <div class="card-footer">
                    <strong>$2.50</strong>
                    <button class="btn-info">
                        <a href="<?php echo BASE_URL; ?>index.php?url=reserva">+</a>
                    </button>
                </div>
            </div>

            <div class="card" data-tipo="Latte">
                <img src="<?php echo BASE_URL; ?>assets/img/latte.png" alt="Latte">
                <h3>Latte</h3>
                <p>Latte</p>
                <div class="card-footer">
                    <strong>$3.00</strong>
                    <button class="btn-info">
                        <a href="<?php echo BASE_URL; ?>index.php?url=reserva">+</a>
                    </button>
                </div>
            </div>
        </div>

        <nav class="footer-section">
            <a href="" class="active"><i class='bx bxs-home-alt-2 '></i></a>
            <a href=""><i class='bx bx-heart'></i></a>
            <a href="<?php echo BASE_URL; ?>index.php?url=pedidos"><i class='bx bx-shopping-bag'></i></a>
            <a href=""><i class='bx bx-bell'></i></a>
        </nav>

    </section>







    <script src="script/script.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>