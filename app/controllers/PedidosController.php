<?php

class PedidosController extends Controller
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

        // Pega o id do cliente do token, ou por parâmetro GET, ou define algum valor
        $id = $dadosToken['id'] ?? null;

        if (!$id) {
            echo "ID do cliente não disponível.";
            exit;
        }

        // ---------- REQUISIÇÃO PARA listarClientes ----------
        $urlCliente = BASE_API . "listarClientes?id=" . $id;

        $chCliente = curl_init($urlCliente);
        curl_setopt($chCliente, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chCliente, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
        $responseCliente = curl_exec($chCliente);
        $statusCodeCliente = curl_getinfo($chCliente, CURLINFO_HTTP_CODE);
        curl_close($chCliente);

        if ($statusCodeCliente != 200) {
            echo "Erro ao buscar o cliente na API. Código HTTP: $statusCodeCliente";
            exit;
        }

        $respostaCliente = json_decode($responseCliente, true);

        if ($respostaCliente['status'] !== 'sucesso') {
            echo "Erro na resposta da API: " . ($respostaCliente['mensagem'] ?? 'Resposta inválida');
            exit;
        }

        // ---------- REQUISIÇÃO PARA listarPedidos ----------
        // Monta a URL da API de pedidos
        $urlPedidos = BASE_API . "listarPedidos/?id=" . $id;

        // Inicializa a sessão cURL
        $chPedidos = curl_init($urlPedidos);

        // Define que a resposta será retornada como string
        curl_setopt($chPedidos, CURLOPT_RETURNTRANSFER, true);

        // Define os headers, incluindo o token de autenticação
        curl_setopt($chPedidos, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        // Executa a requisição
        $responsePedidos = curl_exec($chPedidos);

        // Obtém o código HTTP da resposta
        $statusCodePedidos = curl_getinfo($chPedidos, CURLINFO_HTTP_CODE);

        // Encerra a sessão cURL
        curl_close($chPedidos);

        // Verifica se a requisição foi bem-sucedida
        if ($statusCodePedidos != 200) {
            echo "Erro ao buscar os pedidos na API.\n";
            echo "Código HTTP: $statusCodePedidos";
            exit;
        }

        // Decodifica o JSON da resposta em array associativo
        $respostaPedidos = json_decode($responsePedidos, true);

        // Verifica se veio um array válido e com os dados esperados
        if (!isset($respostaPedidos['pedidos']) || empty($respostaPedidos['pedidos'])) {
            echo "Nenhum pedido encontrado para este cliente.";
            exit;
        }


        // ---------- CRIA A RESERVA A PARTIR DE $_POST OU $_GET ----------

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produto'])) {
            $urlCriarReserva = BASE_API . "criarReserva";

            $dadosReserva = [
                'id_produto'     => $_POST['id_produto'] ?? null,
                'quantidade'     => $_POST['quantidade'] ?? 1,
                'preco_unitario' => $_POST['preco_unitario'] ?? 0,
                'observacao'     => $_POST['observacao'] ?? null,
            ];

            $chReserva = curl_init($urlCriarReserva);
            curl_setopt($chReserva, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chReserva, CURLOPT_POST, true);
            curl_setopt($chReserva, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $_SESSION['token']
            ]);
            curl_setopt($chReserva, CURLOPT_POSTFIELDS, json_encode($dadosReserva));

            $responseReserva = curl_exec($chReserva);
            $statusCodeReserva = curl_getinfo($chReserva, CURLINFO_HTTP_CODE);
            curl_close($chReserva);

            $respostaReserva = json_decode($responseReserva, true);

            if ($statusCodeReserva != 200 || !isset($respostaReserva['status']) || $respostaReserva['status'] !== 'sucesso') {
                echo "Erro ao criar a reserva: " . ($respostaReserva['mensagem'] ?? 'Erro desconhecido');
                // exit;
            }
        }


        // Armazena os pedidos para a view
        $dados['pedidos'] = $respostaPedidos['pedidos'];



        // ---------- PREPARA OS DADOS PARA A VIEW ----------
        $dados = array();
        $dados['titulo'] = 'Exfe - Pedidos';
        $dados['nome_cliente'] = $respostaCliente['cliente']['nome_cliente'] ?? 'Cliente';
        $dados['pedidos'] = $respostaPedidos['pedidos'] ?? [];

        $this->carregarViews('pedidos', $dados);
    }
}
