<?php

class DetalheController extends Controller
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

        // Buscar o cliente na API
        $url = BASE_API . "cliente/" . $dadosToken['id'];

        // Inicializa uma sessão cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        // Recebe os dados dessa solicitação
        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($statusCode != 200) {
            echo "Erro ao buscar o cliente na API.\n";
            echo "Código HTTP: $statusCode";
            exit;
        }

        // Decodifica os dados
        $cliente = json_decode($response, true);

        $dados = array();
        $dados['titulo'] = 'Exfe - Detalhes';
        $dados['nome_cliente'] = $cliente['nome_cliente'] ?? 'Cliente';
        $dados['cliente'] = $cliente;  // Passa todos os dados do cliente

        $this->carregarViews('detalhes', $dados);
    }
}
