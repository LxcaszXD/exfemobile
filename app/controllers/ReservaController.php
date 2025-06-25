<?php

class ReservaController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['token'])) {
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }

        $dadosToken = TokenHelper::validar($_SESSION['token']);
        if (!$dadosToken) {
            session_destroy();
            unset($_SESSION['token']);
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }

        $id = $dadosToken['id'] ?? null;
        if (!$id) {
            echo "ID do cliente não disponível.";
            exit;
        }

        // Buscar reservas
        $urlReservas = BASE_API . "listarReservas?id=" . $id;
        $ch = curl_init($urlReservas);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $resposta = json_decode($response, true);

        // Buscar mesas disponíveis
        $urlMesas = BASE_API . "listarMesasDisponiveis";
        $ch = curl_init($urlMesas);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
        $responseMesas = curl_exec($ch);
        curl_close($ch);
        $respostaMesas = json_decode($responseMesas, true);

        $dados = [
            'titulo' => 'Exfe - Reservas',
            'reservas' => $resposta['reservas'] ?? [],
            'mesas' => $respostaMesas['mesas'] ?? []
        ];

        $this->carregarViews('reserva', $dados);
    }


    public function salvar()
    {
        if (!isset($_SESSION['token'])) {
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }

        $dadosToken = TokenHelper::validar($_SESSION['token']);
        if (!$dadosToken) {
            session_destroy();
            unset($_SESSION['token']);
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }

        $id_cliente = $dadosToken['id'] ?? null;

        if (!$id_cliente || !isset($_POST['data_reserva'], $_POST['hora_inicio'], $_POST['hora_fim'], $_POST['id_mesa'])) {
            $_SESSION['mensagem'] = 'Dados incompletos.';
            $_SESSION['tipo-msg'] = 'erro';
            header("Location: " . BASE_URL . "index.php?url=reserva");
            exit;
        }

        $dados = [
            'id_cliente'   => $id_cliente,
            'data_reserva' => $_POST['data_reserva'],
            'hora_inicio'  => $_POST['hora_inicio'],
            'hora_fim'     => $_POST['hora_fim'],
            'id_mesa'      => $_POST['id_mesa'],
            'observacoes'  => $_POST['observacoes'] ?? ''
        ];

        $ch = curl_init(BASE_API . 'adicionarReserva');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dados));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
        $resposta = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $resposta = json_decode($resposta, true);

        if ($status === 200 && $resposta['status'] === 'sucesso') {
            $_SESSION['mensagem'] = $resposta['mensagem'];
            $_SESSION['tipo-msg'] = 'sucesso';
        } else {
            $_SESSION['mensagem'] = $resposta['mensagem'] ?? 'Erro ao salvar reserva.';
            $_SESSION['tipo-msg'] = 'erro';
        }

        header("Location: " . BASE_URL . "index.php?url=reserva");
        exit;
    }

    public function cancelar()
    {
        if (!isset($_SESSION['token'])) {
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }

        if (!isset($_GET['id'])) {
            $_SESSION['mensagem'] = 'ID da reserva não informado.';
            $_SESSION['tipo-msg'] = 'erro';
            header("Location: " . BASE_URL . "index.php?url=reserva");
            exit;
        }

        $id_reserva = intval($_GET['id']);

        $ch = curl_init(BASE_API . 'cancelarReserva');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['id_reserva' => $id_reserva]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
        $resposta = curl_exec($ch);
        curl_close($ch);

        $resposta = json_decode($resposta, true);

        if ($resposta && $resposta['status'] === 'sucesso') {
            $_SESSION['mensagem'] = $resposta['mensagem'];
            $_SESSION['tipo-msg'] = 'sucesso';
        } else {
            $_SESSION['mensagem'] = $resposta['mensagem'] ?? 'Erro ao cancelar reserva.';
            $_SESSION['tipo-msg'] = 'erro';
        }

        header("Location: " . BASE_URL . "index.php?url=reserva");
        exit;
    }
}
