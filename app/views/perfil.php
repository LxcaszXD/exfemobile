<!DOCTYPE html>
<html lang="pt-br">

<?php
require_once('template/head.php');

?>

<body>
    <section id="perfil">

        <section class="perfilTop">
            <button class="back">
                <a href="<?php echo BASE_URL; ?>index.php?url=menu">
                    <img src="<?php echo BASE_URL; ?>assets/img/left-arrow.png" alt="">
                </a>
            </button>
            <h5 class="mb-0 fw-semibold text-brown">Perfil</h5>
        </section>

        <!-- Foto de Perfil -->
        <section class="perfilFoto">
            <?php
            // Define caminho padrão e imagem personalizada (se houver)
            $imagemPadrao = BASE_URL_FOTO . 'sem-foto-cliente.png';
            $fotoCliente = !empty($cliente['foto_cliente']) ? BASE_URL_FOTO . $cliente['foto_cliente'] : $imagemPadrao;
            ?>
            <img src="<?php echo $fotoCliente; ?>" alt="Foto de Perfil" class="rounded-4 perfil-img" style="width: 120px; height: 120px; object-fit: cover;">
        </section>


        <!-- Formulário -->
        <section class="perfilInput">
            <div class="perfilLabel">

                <form class="mx-auto">

                    <div class="mb-3">
                        <label class="form-label label-custom">Nome Completo:</label>
                        <input type="text" class="form-control input-custom" id="nome_cliente" name="nome_cliente" value="<?= !empty($cliente['nome_cliente']) ? $cliente['nome_cliente'] : 'Vazio' ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Data de Nascimento:</label>
                        <input type="date" class="form-control input-custom" id="nasc_cliente" name="nasc_cliente" value="<?= !empty($cliente['nasc_cliente']) ? $cliente['nasc_cliente'] : 'Vazio' ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Email:</label>
                        <input type="email" class="form-control input-custom" id="email_cliente" name="email_cliente" value="<?= !empty($cliente['email_cliente']) ? $cliente['email_cliente'] : 'Vazio' ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Tipo de Café:</label>
                        <input type="text" class="form-control input-custom" id="id_produto" name="id_produto" value="<?= !empty($cliente['nome_produto']) ? $cliente['nome_produto'] : 'Vazio' ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Intensidade:</label>
                        <input type="text" class="form-control input-custom" id="id_intensidade" name="id_intensidade" value="<?= !empty($cliente['nome_intensidade']) ? $cliente['nome_intensidade'] : 'Vazio' ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Acompanhamento:</label>
                        <input type="text" class="form-control input-custom" id="id_acompanhamento" name="id_acompanhamento" value="<?= !empty($cliente['nome_acompanhamento']) ? $cliente['nome_acompanhamento'] : 'Vazio' ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Prefere Leite Vegetal?</label>
                        <input type="text" class="form-control input-custom" id="prefere_leite_vegetal" name="prefere_leite_vegetal" value="<?= !empty($cliente['prefere_leite_vegetal']) ? $cliente['prefere_leite_vegetal'] : 'Vazio' ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Tipo de Leite:</label>
                        <input type="text" class="form-control input-custom" id="id_tipo_leite" name="id_tipo_leite" value="<?= !empty($cliente['nome_tipo_leite']) ? $cliente['nome_tipo_leite'] : 'Vazio' ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Observações:</label>
                        <input type="text" class="form-control input-custom" id="observacoes_cliente" name="observacoes_cliente" value="<?= !empty($cliente['observacoes_cliente']) ? $cliente['observacoes_cliente'] : 'Vazio' ?>" readonly>
                    </div>

                </form>

            </div>
        </section>

        <nav class="footerSection">
            <div class="footer">
                <div class="price">
                    <p>Deseja Editar?</p>
                </div>
                <a href="<?php echo BASE_URL; ?>index.php?url=perfil/formEditarPerfil">
                    <button class="reserve">Editar</button>
                </a>

            </div>
        </nav>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>