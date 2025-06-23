<?php

class PerfilController extends Controller
{
    // Método para exibir o perfil do cliente
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

        $url = BASE_API . "listarClientesPerfil?id=" . $id;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($statusCode != 200) {
            echo "Erro ao buscar o cliente na API. Código HTTP: $statusCode";
            exit;
        }

        $resposta = json_decode($response, true);

        if ($resposta['status'] !== 'sucesso') {
            echo "Erro na resposta da API: " . ($resposta['mensagem'] ?? 'Resposta inválida');
            exit;
        }

        $cliente = $resposta['cliente'] ?? [];

        $dados = [
            'titulo' => 'Exfe - Menu',
            'cliente' => $cliente,
            'nome_cliente' => $cliente['nome_cliente'] ?? 'Cliente'
        ];

        $this->carregarViews('perfil', $dados);
    }

    // Exibe o formulário para editar perfil
    public function formEditarPerfil()
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

        // Busca os dados do cliente
        $urlCliente = BASE_API . "listarClientesPerfil?id=" . $id;
        $cliente = $this->apiGet($urlCliente);

        // Busca dados auxiliares para selects
        $produtos = $this->apiGet(BASE_API . "listarProdutos");
        $intensidades = $this->apiGet(BASE_API . "listarIntensidades");
        $acompanhamentos = $this->apiGet(BASE_API . "listarAcompanhamentos");
        $leites = $this->apiGet(BASE_API . "listarLeites");

        $dados = [
            'titulo' => 'Editar Perfil',
            'cliente' => $cliente['cliente'] ?? [],
            'produtos' => $produtos['produtos'] ?? [],
            'intensidades' => $intensidades['intensidades'] ?? [],
            'acompanhamentos' => $acompanhamentos['acompanhamentos'] ?? [],
            'leites' => $leites['leites'] ?? []
        ];

        $this->carregarViews('editarPerfil', $dados);
    }

    // Função auxiliar para requisição GET na API com token
    private function apiGet($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    // Atualiza os dados do cliente via API
    public function editarPerfil()
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
            $_SESSION['mensagem'] = 'ID do cliente não encontrado.';
            $_SESSION['tipo-msg'] = 'erro';
            header("Location: " . BASE_URL . "index.php?url=perfil");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['mensagem'] = 'Método inválido.';
            $_SESSION['tipo-msg'] = 'erro';
            header("Location: " . BASE_URL . "index.php?url=perfil");
            exit;
        }

        // Filtra e valida dados do POST
        $nome = filter_input(INPUT_POST, 'nome_cliente', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email_cliente', FILTER_VALIDATE_EMAIL);
        $nasc = filter_input(INPUT_POST, 'nasc_cliente', FILTER_SANITIZE_STRING);
        $produto = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_NUMBER_INT);
        $intensidade = filter_input(INPUT_POST, 'id_intensidade', FILTER_SANITIZE_NUMBER_INT);
        $acompanhamento = filter_input(INPUT_POST, 'id_acompanhamento', FILTER_SANITIZE_NUMBER_INT);
        $prefLeiteVeg = filter_input(INPUT_POST, 'prefere_leite_vegetal', FILTER_SANITIZE_STRING);
        $tipoLeite = filter_input(INPUT_POST, 'id_tipo_leite', FILTER_SANITIZE_NUMBER_INT);
        $observacoes = filter_input(INPUT_POST, 'observacoes_cliente', FILTER_SANITIZE_STRING);
        $senha = $_POST['senha_cliente'] ?? '';

        if (!$nome || !$email || !$nasc || !$produto || !$intensidade || !$acompanhamento || !$tipoLeite || !$prefLeiteVeg) {
            $_SESSION['mensagem'] = 'Preencha todos os campos obrigatórios corretamente.';
            $_SESSION['tipo-msg'] = 'erro';
            header("Location: " . BASE_URL . "index.php?url=perfil/formEditarPerfil");
            exit;
        }

        $dados = [
            'nome_cliente'          => $nome,
            'email_cliente'         => $email,
            'nasc_cliente'          => $nasc,
            'id_produto'            => $produto,
            'id_intensidade'        => $intensidade,
            'id_acompanhamento'     => $acompanhamento,
            'prefere_leite_vegetal' => $prefLeiteVeg,
            'id_tipo_leite'         => $tipoLeite,
            'observacoes_cliente'   => $observacoes,
        ];

        // Envia a senha apenas se foi preenchida
        if (!empty($senha)) {
            $dados['senha_cliente'] = $senha;
        }

        $ch = curl_init(BASE_API . "atualizarCliente/$id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dados));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        $resposta = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $resposta = json_decode($resposta, true);

        if ($status === 200 && isset($resposta['status']) && $resposta['status'] === 'sucesso') {
            $_SESSION['mensagem'] = 'Dados atualizados com sucesso!';
            $_SESSION['tipo-msg'] = 'sucesso';
        } else {
            $_SESSION['mensagem'] = $resposta['mensagem'] ?? 'Erro ao atualizar os dados.';
            $_SESSION['tipo-msg'] = 'erro';
        }

        header("Location: " . BASE_URL . "index.php?url=perfil");
        exit;
    }
}
