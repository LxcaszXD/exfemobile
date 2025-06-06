<?php

class ReservaController extends Controller
{
    public function index()
    {
        // Verifica se o usuário está logado (tem token)
        if (!isset($_SESSION['token'])) {
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }

        // Valida o token
        $dadosToken = TokenHelper::validar($_SESSION['token']);

        if (!$dadosToken) {
            session_destroy();
            unset($_SESSION['token']);
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }

        // Buscar o cliente na API
        $url = BASE_API . "cliente/" . $dadosToken['id'];

        // Inicializa uma sessão cURL para buscar dados do cliente
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        // Executa a requisição e obtém resposta
        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Se a resposta não for 200, exibe erro e sai
        if ($statusCode != 200) {
            echo "Erro ao buscar o cliente na API.\n";
            echo "Código HTTP: $statusCode";
            exit;
        }

        // Decodifica os dados do cliente
        $cliente = json_decode($response, true);

        // Monta dados para a view
        $dados = array();
        $dados['titulo'] = 'Exfe - Reserva';
        $dados['nome_cliente'] = $cliente['nome_cliente'] ?? 'Cliente';
        $dados['cliente'] = $cliente; // se precisar passar mais dados para a view

        // Carrega a view reserva.php com os dados
        $this->carregarViews('reserva', $dados);
    }
}
