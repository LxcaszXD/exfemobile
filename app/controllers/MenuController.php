<?php

class MenuController extends Controller
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

        // 1. Pega ID do cliente
        $id = $dadosToken['id'] ?? null;

        if (!$id) {
            echo "ID do cliente não disponível.";
            exit;
        }

        // 2. Busca dados do cliente
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




        $url = BASE_API . "listarProdutosPorCategoria";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($status != 200) {
            echo "Erro na requisição: Código $status";
            exit;
        }

        $dados = json_decode($response, true);

        if ($dados['status'] != 'sucesso') {
            echo "Erro: " . ($dados['mensagem'] ?? 'Falha ao carregar produtos.');
            exit;
        }






        // Monta a URL da API de categorias
        $urlCategorias = BASE_API . "listarCategorias/";

        // Inicializa a sessão cURL
        $chCategorias = curl_init($urlCategorias);

        // Define que a resposta será retornada como string
        curl_setopt($chCategorias, CURLOPT_RETURNTRANSFER, true);

        // Define os headers, incluindo o token de autenticação
        curl_setopt($chCategorias, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        // Executa a requisição
        $responseCategorias = curl_exec($chCategorias);

        // Obtém o código HTTP da resposta
        $statusCodeCategorias = curl_getinfo($chCategorias, CURLINFO_HTTP_CODE);

        // Encerra a sessão cURL
        curl_close($chCategorias);

        // Verifica se a requisição foi bem-sucedida
        if ($statusCodeCategorias != 200) {
            echo "Erro ao buscar as categorias na API.\n";
            echo "Código HTTP: $statusCodeCategorias";
            exit;
        }

        // Decodifica o JSON da resposta em array associativo
        $categoria = json_decode($responseCategorias, true);

        if (!isset($categoria['categoria']) || empty($categoria['categoria'])) {
            echo "Categoria não especificada ou nenhuma categoria disponível.";
            exit;
        }

        // Seleciona a primeira categoria (ou outra lógica, como GET['categoria'])
        $categoriaSelecionada = $categoria['categoria'][0]['id_categoria'] ?? null;


        if (!$categoriaSelecionada) {
            echo "Nenhuma categoria foi selecionada.";
            exit;
        }

        $urlProdutos = BASE_API . "listarProdutosSelecionados/";

        $chProdutos = curl_init($urlProdutos);
        curl_setopt($chProdutos, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chProdutos, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
        $responseProdutos = curl_exec($chProdutos);
        $statusCodeProdutos = curl_getinfo($chProdutos, CURLINFO_HTTP_CODE);
        curl_close($chProdutos);

        if ($statusCodeProdutos != 200) {
            echo "Erro ao buscar produtos na API. Código HTTP: $statusCodeProdutos";
            exit;
        }

        $respostaProdutos = json_decode($responseProdutos, true);

        if ($respostaProdutos['status'] !== 'sucesso') {
            echo "Erro na resposta da API: " . ($respostaProdutos['mensagem'] ?? 'Nenhum produto encontrado.');
            exit;
        }

        // 5. Prepara os dados para a view
        $dados = array();
        $dados['titulo'] = 'Exfe - Menu';
        $dados['nome_cliente'] = $respostaCliente['cliente']['nome_cliente'] ?? 'Cliente';
        $dados['categoria'] = $categoriaSelecionada;
        $dados['produtos'] = $respostaProdutos['produtos'] ?? [];

        $this->carregarViews('menu', $dados);
    }
}
