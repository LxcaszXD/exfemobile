<!DOCTYPE html>
<html lang="pt-br">
<?php require_once('template/head.php'); ?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<body>

    <div id="detalhes">
        <!-- Cabeçalho -->
        <div class="header">
            <button class="back">
                <a href="<?php echo BASE_URL; ?>index.php?url=menu">
                    <img src="<?php echo BASE_URL; ?>assets/img/left-arrow.png" alt="Voltar">
                </a>
            </button>
            <h2>Avaliações</h2>
            <button class="favorite">
                <img src="<?php echo BASE_URL; ?>assets/img/heart.png" alt="Favoritar">
            </button>
        </div>

        <!-- Conteúdo -->
        <div class="content">
            <div class="title-row">
                <div class="icons">
                    <div class="icon">&#9749;</div>
                    <div class="icon">&#128230;</div>
                </div>
            </div>

            <h4>Avaliações</h4>

            <?php if (!empty($avaliacoes)): ?>
                <?php foreach ($avaliacoes as $avaliacao): ?>
                    <div class="avaliacao mb-4 border p-3 rounded">
                        <h4><?= htmlspecialchars($avaliacao['nome_produto']) ?></h4>
                        <img src="<?= BASE_URL_FOTO . 'img/' . htmlspecialchars($avaliacao['foto_produto']) ?>" alt="<?= htmlspecialchars($avaliacao['nome_produto']) ?>" class="img-fluid mb-2" style="max-width: 150px;">
                        <p><strong><?= htmlspecialchars($avaliacao['nome_cliente']) ?></strong> - <?= date('d/m/Y', strtotime($avaliacao['data_avaliacao'])) ?></p>
                        <p>Nota: <?= (int)$avaliacao['nota'] ?> ★</p>
                        <p><?= nl2br(htmlspecialchars($avaliacao['comentario'])) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: #888;">Nenhuma avaliação encontrada.</p>
            <?php endif; ?>
        </div>

        <!-- Rodapé com botão de avaliação -->
        <nav class="footerSection">
            <div class="footer">
                <div class="price">
                    <span class="amount">Deixe uma Avaliação</span>
                </div>
                <button type="button" class="reserve" data-bs-toggle="modal" data-bs-target="#modalAvaliacao">
                    Avaliar
                </button>
            </div>
        </nav>
    </div>

    <!-- Modal de Avaliação -->
    <div class="modal fade" id="modalAvaliacao" tabindex="-1" aria-labelledby="modalAvaliacaoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="<?= BASE_URL ?>index.php?url=avaliacao/salvar" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAvaliacaoLabel">Nova Avaliação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <!-- Selecionar Produto/Acompanhamento -->
                    <div class="mb-3">
                        <label for="id_produto" class="form-label">Produto ou Acompanhamento</label>
                        <select name="id_produto" id="id_produto" class="form-select" required>
                            <option value="">Selecione um item</option>
                            <?php foreach ($produtos as $produto): ?>
                                <option value="<?= htmlspecialchars($produto['id_produto']) ?>">
                                    <?= htmlspecialchars($produto['nome_produto']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <!-- Estrelas -->
                    <label for="nota_avaliacao">Nota</label>
                    <div class="rating mb-3" id="ratingStars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="star" data-value="<?= $i ?>" style="cursor:pointer;font-size:24px;">&#9734;</span>
                        <?php endfor; ?>
                        <input type="hidden" name="nota_avaliacao" id="notaAvaliacao" value="0">
                    </div>

                    <!-- Comentário -->
                    <div class="mb-3">
                        <label for="comentario_avaliacao" class="form-label">Comentário</label>
                        <textarea class="form-control" name="comentario_avaliacao" id="comentario_avaliacao" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar Avaliação</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS + jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Script de Estrelas -->
    <script>
        $(document).ready(function() {
            $('.star').click(function() {
                let value = $(this).data('value');
                $('#notaAvaliacao').val(value);
                $('.star').each(function(index) {
                    $(this).html(index < value ? '&#9733;' : '&#9734;');
                });
            });
        });
    </script>

</body>

</html>