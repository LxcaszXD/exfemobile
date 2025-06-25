<!DOCTYPE html>
<html lang="pt-br">
<?php require_once('template/head.php'); ?>

<body>
    <section id="perfil">

        <section class="perfilTop">
            <button class="back">
                <a href="<?php echo BASE_URL; ?>index.php?url=perfil">
                    <img src="<?php echo BASE_URL; ?>assets/img/left-arrow.png" alt="Voltar">
                </a>
            </button>
            <h5 class="mb-0 fw-semibold text-brown">Editar Perfil</h5>
        </section>

        <!-- Foto de Perfil -->
        <section class="perfilFoto">
            <?php
            // Define caminho padrão e imagem personalizada (se houver)
            $imagemPadrao = BASE_URL_FOTO . 'sem-foto-cliente.png';
            $fotoCliente = !empty($cliente['foto_cliente']) ? BASE_URL_FOTO . $cliente['foto_cliente'] : $imagemPadrao;
            ?>
            <img src="<?php echo $fotoCliente; ?>" alt="Foto de Perfil" class="rounded-4 perfil-img" style="width: 120px; height: 120px; object-fit: cover;">

            <!-- Formulário para upload de nova imagem -->
            <form action="<?php echo BASE_URL; ?>perfil/atualizarFoto" method="POST" enctype="multipart/form-data" style="margin-top: 10px;">
                <input type="file" name="foto" accept="image/*" required>
               
            </form>
        </section>


        <!-- Formulário -->
        <section class="perfilInput">
            <div class="perfilLabel">
                <form class="mx-auto" method="POST" action="<?= BASE_URL ?>index.php?url=editarPerfil">

                    <div class="mb-3">
                        <label class="form-label label-custom">Nome Completo:</label>
                        <input type="text" class="form-control input-custom" name="nome_cliente"
                            value="<?= isset($cliente['nome_cliente']) ? htmlspecialchars($cliente['nome_cliente']) : '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Data de Nascimento:</label>
                        <input type="date" class="form-control input-custom" name="nasc_cliente"
                            value="<?= isset($cliente['nasc_cliente']) ? htmlspecialchars($cliente['nasc_cliente']) : '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Email:</label>
                        <input type="email" class="form-control input-custom" name="email_cliente"
                            value="<?= isset($cliente['email_cliente']) ? htmlspecialchars($cliente['email_cliente']) : '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Senha: <small>(Deixe em branco para manter a atual)</small></label>
                        <input type="password" class="form-control input-custom" name="senha_cliente" placeholder="Nova senha">
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Tipo de Café:</label>
                        <select name="id_produto" class="form-control input-custom" required>
                            <?php if (!empty($produtos) && is_array($produtos)): ?>
                                <?php foreach ($produtos as $produto): ?>
                                    <option value="<?= htmlspecialchars($produto['id_produto']) ?>"
                                        <?= (isset($cliente['id_produto']) && $cliente['id_produto'] == $produto['id_produto']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($produto['nome_produto']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option disabled>Sem produtos disponíveis</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Intensidade:</label>
                        <select name="id_intensidade" class="form-control input-custom" required>
                            <?php if (!empty($intensidades) && is_array($intensidades)): ?>
                                <?php foreach ($intensidades as $intensidade): ?>
                                    <option value="<?= htmlspecialchars($intensidade['id_intensidade']) ?>"
                                        <?= (isset($cliente['id_intensidade']) && $cliente['id_intensidade'] == $intensidade['id_intensidade']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($intensidade['nivel_intensidade']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option disabled>Sem intensidades disponíveis</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Acompanhamento:</label>
                        <select name="id_acompanhamento" class="form-control input-custom" required>
                            <?php if (!empty($acompanhamentos) && is_array($acompanhamentos)): ?>
                                <?php foreach ($acompanhamentos as $acomp): ?>
                                    <option value="<?= htmlspecialchars($acomp['id_acompanhamento']) ?>"
                                        <?= (isset($cliente['id_acompanhamento']) && $cliente['id_acompanhamento'] == $acomp['id_acompanhamento']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($acomp['nome_acompanhamento']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option disabled>Sem acompanhamentos disponíveis</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Prefere Leite Vegetal?</label>
                        <select name="prefere_leite_vegetal" class="form-control input-custom" required>
                            <option value="Sim" <?= (isset($cliente['prefere_leite_vegetal']) && $cliente['prefere_leite_vegetal'] === 'Sim') ? 'selected' : '' ?>>Sim</option>
                            <option value="Não" <?= (isset($cliente['prefere_leite_vegetal']) && $cliente['prefere_leite_vegetal'] === 'Não') ? 'selected' : '' ?>>Não</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Tipo de Leite:</label>
                        <select name="id_tipo_leite" class="form-control input-custom" required>
                            <?php if (!empty($leites) && is_array($leites)): ?>
                                <?php foreach ($leites as $leite): ?>
                                    <option value="<?= htmlspecialchars($leite['id_tipo_leite']) ?>"
                                        <?= (isset($cliente['id_tipo_leite']) && $cliente['id_tipo_leite'] == $leite['id_tipo_leite']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($leite['nome_tipo_leite']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option disabled>Sem tipos de leite disponíveis</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label label-custom">Observações:</label>
                        <input type="text" class="form-control input-custom" name="observacoes_cliente"
                            value="<?= isset($cliente['observacoes_cliente']) ? htmlspecialchars($cliente['observacoes_cliente']) : '' ?>">
                    </div>

                    <button class="btn btn-primary w-100" type="submit">Salvar</button>
                </form>
            </div>
        </section>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>