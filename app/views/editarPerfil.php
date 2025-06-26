<!DOCTYPE html>
<html lang="pt-br">
<?php require_once('template/head.php'); ?>

<body>
<section id="perfil">



    <!-- Formulário -->
    <section class="perfilInput">
        <div class="perfilLabel">
            <form class="mx-auto" method="POST" enctype="multipart/form-data" action="<?= BASE_URL ?>index.php?url=perfil/editarPerfil">

             <div class="text-center mb-4">
                <?php
                $imagemPadrao = BASE_URL_FOTO . 'sem-foto-cliente.png';
                $fotoCliente = !empty($cliente['foto_cliente']) ? BASE_URL_FOTO . $cliente['foto_cliente'] : $imagemPadrao;
                ?>
                <label for="fotoInput">
                    <img src="<?php echo $fotoCliente; ?>" alt="Foto de Perfil" class="rounded-4 perfil-img"
                         style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;">
                </label>
                <!-- Input de imagem DENTRO do formulário -->
                <input type="file" name="foto_cliente" id="fotoInput" accept="image/*" style="display: none;">
            </div>

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
                    <label class="form-label label-custom">Senha:</label>
                    <input type="text" class="form-control input-custom" name="senha_cliente" value="<?= htmlspecialchars($cliente['senha_cliente'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label label-custom">Tipo de Café:</label>
                    <select name="id_produto" class="form-control input-custom" required>
                        <?php if (!empty($produtos)): ?>
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
                        <?php if (!empty($intensidades)): ?>
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
                        <?php if (!empty($acompanhamentos)): ?>
                            <?php foreach ($acompanhamentos as $acomp): ?>
                                <option value="<?= htmlspecialchars($acomp['id_produto']) ?>"
                                    <?= (isset($cliente['id_acompanhamento']) && $cliente['id_acompanhamento'] == $acomp['id_produto']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($acomp['nome_produto']) ?>
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
                        <?php if (!empty($leites)): ?>
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

                <button class="btn btn-primary w-100" type="submit" style="background-color: #5c4033;">Salvar</button>
            </form>
        </div>
    </section>
</section>

<!-- JS de Preview da Imagem -->
<script>
    document.getElementById('fotoInput').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                document.querySelector('.perfil-img').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
