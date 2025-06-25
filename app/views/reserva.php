<!DOCTYPE html>
<html lang="pt-br">

<?php require_once('template/head.php'); ?>

<body>
    <div class="container py-4" id="reserva">

        <div class="header">
            <button class="back">
                <a href="<?php echo BASE_URL; ?>index.php?url=menu">
                    <img src="<?php echo BASE_URL; ?>assets/img/left-arrow.png" alt="">
                </a>
            </button>
            <h2>Reservas</h2>
            <button class="favorite">
                <img src="<?php echo BASE_URL; ?>assets/img/heart.png" alt="">
            </button>
        </div>

        <section class="mb-5">
            <h4 class="mb-3">Suas Reservas</h4>
            <div class="list-group">
                <?php if (!empty($reservas)): ?>
                    <?php foreach ($reservas as $reserva): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-start">
                            <div>
                                <p class="mb-1"><strong>Data:</strong> <?= date('d/m/Y', strtotime($reserva['data_reserva'])) ?></p>
                                <p class="mb-1"><strong>Horário:</strong> <?= substr($reserva['hora_inicio'], 0, 5) ?> às <?= substr($reserva['hora_fim'], 0, 5) ?></p>
                                <p class="mb-1"><strong>Status:</strong> <?= $reserva['status_reserva'] ?></p>
                                <p class="mb-1"><strong>Mesa:</strong> <?= $reserva['numero_mesa'] ?></p>
                                <p class="mb-1"><strong>Capacidade:</strong> <?= $reserva['capacidade'] ?></p>
                                <p class="mb-0"><strong>Observações:</strong> <?= $reserva['observacoes'] ?></p>
                            </div>
                            <?php if ($reserva['status_reserva'] !== 'Cancelada'): ?>
                                <form method="GET" action="<?= BASE_URL ?>index.php?url=reserva/cancelar" onsubmit="return confirm('Deseja cancelar esta reserva?')">
                                    <input type="hidden" name="id" value="<?= $reserva['id_reserva'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm ms-3" style="background-color: #371406;">X</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>

                <?php else: ?>
                    <div class="alert alert-info">Nenhuma reserva encontrada.</div>
                <?php endif; ?>
            </div>
        </section>

        <section>
            <h4 class="mb-3">Nova Reserva</h4>
            <form method="POST" action="<?php echo BASE_URL; ?>index.php?url=reserva/salvar" class="row g-3" onsubmit="return confirmarPagamento()">
                <div class="col-md-6">
                    <label for="data_reserva" class="form-label">Data</label>
                    <input type="date" name="data_reserva" id="data_reserva" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label for="hora_inicio" class="form-label">Hora Início</label>
                    <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label for="hora_fim" class="form-label">Hora Fim</label>
                    <input type="time" name="hora_fim" id="hora_fim" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="id_mesa" class="form-label">Escolha a Mesa</label>
                    <select name="id_mesa" id="id_mesa" class="form-select" required>
                        <option value="">Selecione</option>
                        <?php foreach ($mesas as $mesa): ?>
                            <option value="<?= $mesa['id_mesa'] ?>">Mesa <?= $mesa['numero_mesa'] ?> - Capacidade <?= $mesa['capacidade'] ?? '' ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-12">
                    <label for="observacoes" class="form-label">Observações</label>
                    <textarea name="observacoes" id="observacoes" rows="3" class="form-control"></textarea>
                </div>

                <div class="col-md-12 d-grid">
                    <button type="submit" class="btn btn-success" style="background-color: #371406;">Reservar</button>
                </div>
            </form>
        </section>
    </div>

    <script>
        function confirmarPagamento() {
            return confirm("Para confirmar a reserva é necessário realizar o pagamento da taxa de R$25,00.\nDeseja continuar?\n\nObservações: Em caso de cancelamento, a taxa não será reembolsada.\nO tempo máximo de tolerância é de 15 minutos após o horário da reserva.\nPara a reserva de horários diretens de: segunda a sábado, das 8h às 20h e domingos das 9h às 14h, é necessário entrar em contato com para a confirmação.\n\nAgradecemos a compreensão!");
        }
    </script>
    <!-- Bootstrap JS (caso ainda não esteja incluído) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>