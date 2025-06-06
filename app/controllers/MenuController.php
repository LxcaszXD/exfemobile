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

    // Pega o id do cliente do token, ou por parâmetro GET, ou define algum valor
    $id = $dadosToken['id'] ?? null;

    if (!$id) {
        echo "ID do cliente não disponível.";
        exit;
    }

    // Monta a URL correta, enviando o parâmetro via GET
    $url = BASE_API . "listarClientes?id=" . $id;

    // Inicializa a sessão cURL para chamar a API
    $ch = curl_init($url);

    // Retorna a resposta como string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Define o cabeçalho Authorization para passar o token
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $_SESSION['token']
    ]);

    // Executa a requisição
    $response = curl_exec($ch);

    // Código HTTP da resposta
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Fecha a sessão cURL
    curl_close($ch);

    if ($statusCode != 200) {
        echo "Erro ao buscar o cliente na API. Código HTTP: $statusCode";
        exit;
    }

    $resposta = json_decode($response, true);

    // Verifica se retornou sucesso
    if ($resposta['status'] !== 'sucesso') {
        echo "Erro na resposta da API: " . ($resposta['mensagem'] ?? 'Resposta inválida');
        exit;
    }

    $dados = array();
    $dados['titulo'] = 'Exfe - Menu';

    // Pega o nome do cliente retornado
    $dados['nome_cliente'] = $resposta['cliente']['nome_cliente'] ?? 'Cliente';

    $this->carregarViews('menu', $dados);
}

}
