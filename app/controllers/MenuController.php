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

        // Pega ID do cliente
        $id = $dadosToken['id'] ?? null;

        if (!$id) {
            echo "ID do cliente não disponível.";
            exit;
        }

        // Busca dados do cliente
        $urlCliente = BASE_API . "listarClientesPerfil?id=" . $id;

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

        // Busca todos os produtos por categoria (agrupados)
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

        // Busca categorias
        $urlCategorias = BASE_API . "listarCategorias/";

        $chCategorias = curl_init($urlCategorias);
        curl_setopt($chCategorias, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chCategorias, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
        $responseCategorias = curl_exec($chCategorias);
        $statusCodeCategorias = curl_getinfo($chCategorias, CURLINFO_HTTP_CODE);
        curl_close($chCategorias);

        if ($statusCodeCategorias != 200) {
            echo "Erro ao buscar as categorias na API.\n";
            echo "Código HTTP: $statusCodeCategorias";
            exit;
        }

        $categoria = json_decode($responseCategorias, true);

        if (!isset($categoria['categoria']) || empty($categoria['categoria'])) {
            echo "Categoria não especificada ou nenhuma categoria disponível.";
            exit;
        }

        $categoriaSelecionada = $categoria['categoria'][0]['id_categoria'] ?? null;

        if (!$categoriaSelecionada) {
            echo "Nenhuma categoria foi selecionada.";
            exit;
        }

        // Busca produtos selecionados
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

        // Prepara os dados para a view
        $dados = array();
        $dados['titulo'] = 'Exfe - Menu';
        $dados['nome_cliente'] = $respostaCliente['cliente']['nome_cliente'] ?? 'Cliente';
        $dados['categoria'] = $categoriaSelecionada;
        $dados['produtos'] = $respostaProdutos['produtos'] ?? [];
        $dados['cliente'] = $respostaCliente['cliente']; // ✅ Essencial para carregar a foto na view

        $this->carregarViews('menu', $dados);
    }
}
