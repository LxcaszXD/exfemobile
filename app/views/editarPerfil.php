<!DOCTYPE html>
<html lang="pt-br">

<?php
require_once('template/head.php');

?>

<body>
    <section id="editarPerfil">

        <section class="perfilTop">
            <button class="back">
                <a href="<?php echo BASE_URL; ?>index.php?url=menu">
                    <img src="<?php echo BASE_URL; ?>assets/img/left-arrow.png" alt="">
                </a>
            </button>
            <h5 class="mb-0 fw-semibold text-brown">Editar Perfil</h5>
        </section>

        <!-- Foto de Perfil -->
        <section class="perfilFoto">
            <img src="<?php echo BASE_URL; ?>assets/img/imagePerfil.png" alt="Foto de Perfil" class="rounded-4 perfil-img">
        </section>

        <!-- Formulário -->
        <section class="perfilInput">
            <div class="perfilLabel">

                <form class="mx-auto">

                    <div class="mb-3">
                        <label class="form-label label-custom">Nome:</label>
                        <input type="text" class="form-control input-custom" value="Ana Paula">
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Data de Nascimento:</label>
                        <input type="text" class="form-control input-custom" value="09/05/1990">
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Telefone:</label>
                        <input type="text" class="form-control input-custom" value="119563358">
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Endereço:</label>
                        <input type="text" class="form-control input-custom" value="Rua A, 393">
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Bairro:</label>
                        <input type="text" class="form-control input-custom" value="Centro">
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Cidade:</label>
                        <input type="text" class="form-control input-custom" value="São Paulo">
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Estado:</label>
                        <input type="text" class="form-control input-custom" value="SP">
                    </div>

                </form>
            </div>
        </section>

        <nav class="footerSection">
            <div class="footer">
                <div class="price">
                    <p>Deseja Editar?</p>
                </div>
                <a href="<?php echo BASE_URL; ?>index.php?url=editarPerfil">
                    <button class="reserve">Editar</button>
                </a>
            </div>
        </nav>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>