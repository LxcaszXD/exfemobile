<?php

class PerfilController extends Controller
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

        $url = BASE_API . "listarClientesPerfil?id=" . $id;
        $cliente = $this->apiGet($url);

        if ($cliente['status'] !== 'sucesso') {
            echo "Erro na resposta da API: " . ($cliente['mensagem'] ?? 'Resposta inválida');
            exit;
        }

        $dados = [
            'titulo' => 'Exfe - Menu',
            'cliente' => $cliente['cliente'] ?? [],
            'nome_cliente' => $cliente['cliente']['nome_cliente'] ?? 'Cliente'
        ];

        $this->carregarViews('perfil', $dados);
    }

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

        $cliente = $this->apiGet(BASE_API . "listarClientesPerfil?id=" . $id);
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

        // Coleta e sanitiza os dados
        $nome = filter_input(INPUT_POST, 'nome_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email_cliente', FILTER_VALIDATE_EMAIL);
        $nasc = $_POST['nasc_cliente'] ?? '';
        $produto = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_NUMBER_INT);
        $intensidade = filter_input(INPUT_POST, 'id_intensidade', FILTER_SANITIZE_NUMBER_INT);
        $acompanhamento = filter_input(INPUT_POST, 'id_acompanhamento', FILTER_SANITIZE_NUMBER_INT);
        $prefLeiteVeg = filter_input(INPUT_POST, 'prefere_leite_vegetal', FILTER_SANITIZE_STRING);
        $tipoLeite = filter_input(INPUT_POST, 'id_tipo_leite', FILTER_SANITIZE_NUMBER_INT);
        $observacoes = filter_input(INPUT_POST, 'observacoes_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
        $senha = $_POST['senha_cliente'] ?? '';

        if (!$nome || !$email || !$nasc || !$produto || !$intensidade || !$acompanhamento || !$tipoLeite || !$prefLeiteVeg) {
            $_SESSION['mensagem'] = 'Preencha todos os campos obrigatórios corretamente.';
            $_SESSION['tipo-msg'] = 'erro';
            header("Location: " . BASE_URL . "index.php?url=perfil/formEditarPerfil");
            exit;
        }

        $dados = [
            'nome_cliente' => $nome,
            'email_cliente' => $email,
            'nasc_cliente' => $nasc,
            'id_produto' => $produto,
            'id_intensidade' => $intensidade,
            'id_acompanhamento' => $acompanhamento,
            'prefere_leite_vegetal' => $prefLeiteVeg,
            'id_tipo_leite' => $tipoLeite,
            'observacoes_cliente' => $observacoes
        ];

        if (!empty($senha)) {
            $dados['senha_cliente'] = $senha;
        }

        // Upload da foto
        if (isset($_FILES['foto_cliente']) && $_FILES['foto_cliente']['error'] === UPLOAD_ERR_OK) {
            $dados['foto_cliente'] = new CURLFile(
                $_FILES['foto_cliente']['tmp_name'],
                $_FILES['foto_cliente']['type'],
                $_FILES['foto_cliente']['name']
            );
        }

        $ch = curl_init(BASE_API . "atualizarCliente/$id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        $resposta = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $resposta = json_decode($resposta, true);

        if ($status === 200 && $resposta['status'] === 'sucesso') {
            $_SESSION['mensagem'] = 'Dados atualizados com sucesso!';
            $_SESSION['tipo-msg'] = 'sucesso';
        } else {
            $_SESSION['mensagem'] = $resposta['mensagem'] ?? 'Erro ao atualizar os dados.';
            $_SESSION['tipo-msg'] = 'erro';
        }

        header("Location: " . BASE_URL . "index.php?url=perfil/formEditarPerfil");
        exit;
    }


        public function editarFotoCliente()
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

        if (!isset($_FILES['foto_cliente']) || $_FILES['foto_cliente']['error'] !== 0) {
            $_SESSION['mensagem'] = 'Erro ao enviar a imagem.';
            $_SESSION['tipo-msg'] = 'erro';
            header("Location: " . BASE_URL . "index.php?url=perfil");
            exit;
        }

        $arquivo = new CURLFile(
            $_FILES['foto_cliente']['tmp_name'],
            $_FILES['foto_cliente']['type'],
            $_FILES['foto_cliente']['name']
        );

        $dados = [
            'id_cliente'    => $id,
            'foto_cliente'  => $arquivo
        ];

        $ch = curl_init(BASE_API . "atualizarCliente/$id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        $resposta = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $resposta = json_decode($resposta, true);

        if ($status === 200 && isset($resposta['status']) && $resposta['status'] === 'sucesso') {
            $_SESSION['mensagem'] = 'Foto atualizada com sucesso!';
            $_SESSION['tipo-msg'] = 'sucesso';
        } else {
            $_SESSION['mensagem'] = $resposta['mensagem'] ?? 'Erro ao atualizar a foto.';
            $_SESSION['tipo-msg'] = 'erro';
        }

        header("Location: " . BASE_URL . "index.php?url=perfil");
        exit;
    }
}
