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
        $urlCliente = BASE_API . "cliente/" . $dadosToken['id'];
        $chCliente = curl_init($urlCliente);
        curl_setopt($chCliente, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chCliente, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
        $response = curl_exec($chCliente);
        $statusCode = curl_getinfo($chCliente, CURLINFO_HTTP_CODE);
        curl_close($chCliente);

        if ($statusCode != 200) {
            echo "Erro ao buscar o cliente na API.\n";
            echo "Código HTTP: $statusCode";
            exit;
        }

        $cliente = json_decode($response, true);

        // Buscar produto por ID
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $produto = null;

        if ($id) {
            $url = BASE_API . "detalhes/$id";
            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resposta = curl_exec($ch);
            curl_close($ch);

            $resposta = json_decode($resposta, true);

            if ($resposta && $resposta['status'] === 'sucesso') {
                $produto = $resposta['produto'];
            }
        }

        // Montar os dados para a view
        $dados = array();
        $dados['titulo'] = 'Exfe - Detalhes';
        $dados['nome_cliente'] = $cliente['nome_cliente'] ?? 'Cliente';
        $dados['cliente'] = $cliente;
        $dados['produto'] = $produto; // <- Adicionado aqui

        // Carregar a view com os dados do produto
        $this->carregarViews('detalhes', $dados);
    }
}
