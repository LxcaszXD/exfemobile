<?php

class AvaliacaoController extends Controller
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

        $id_cliente = $dadosToken['id'] ?? null;

        if (!$id_cliente) {
            echo "ID do cliente não disponível.";
            exit;
        }

        // Requisição de avaliações do cliente logado
        $urlAvaliacoes = BASE_API . "listarAvaliacoes?id=" . $id_cliente;
        $ch = curl_init($urlAvaliacoes);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
        $responseAvaliacoes = curl_exec($ch);
        curl_close($ch);
        $respostaAvaliacoes = json_decode($responseAvaliacoes, true);

        if (!isset($respostaAvaliacoes['avaliacoes'])) {
            $respostaAvaliacoes['avaliacoes'] = [];
        }

        // Requisição de itens do menu (produtos + acompanhamentos)
        $urlItens = BASE_API . "listarItensMenu";
        $ch = curl_init($urlItens);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
        $responseItens = curl_exec($ch);
        curl_close($ch);
        $respostaItens = json_decode($responseItens, true);

        $dados = [
            'titulo' => 'Exfe - Avaliações',
            'avaliacoes' => $respostaAvaliacoes['avaliacoes'],
            'produtos' => $respostaItens['itens'] ?? [],
            'id_cliente_logado' => $id_cliente // 👈 usado na view para checar dono da avaliação
        ];

        $this->carregarViews('avaliacao', $dados);
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

        if (!$id_cliente || !isset($_POST['id_produto'], $_POST['nota_avaliacao'], $_POST['comentario_avaliacao'])) {
            $_SESSION['mensagem'] = 'Dados incompletos.';
            $_SESSION['tipo-msg'] = 'erro';
            header("Location: " . BASE_URL . "index.php?url=avaliacao");
            exit;
        }

        $dados = [
            'id_cliente' => $id_cliente,
            'id_produto' => $_POST['id_produto'],
            'nota' => $_POST['nota_avaliacao'],
            'comentario' => $_POST['comentario_avaliacao']
        ];

        $ch = curl_init(BASE_API . 'adicionarAvaliacao');
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
            $_SESSION['mensagem'] = $resposta['mensagem'] ?? 'Erro ao enviar avaliação.';
            $_SESSION['tipo-msg'] = 'erro';
        }

        header("Location: " . BASE_URL . "index.php?url=avaliacao");
        exit;
    }

    public function cancelar()
    {
        if (!isset($_SESSION['token'])) {
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }

        if (!isset($_GET['id'])) {
            $_SESSION['mensagem'] = 'ID da avaliação não informado.';
            $_SESSION['tipo-msg'] = 'erro';
            header("Location: " . BASE_URL . "index.php?url=avaliacao");
            exit;
        }

        $id_avaliacao = intval($_GET['id']);

        $ch = curl_init(BASE_API . 'cancelarAvaliacao');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['id_avaliacao' => $id_avaliacao]));
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
            $_SESSION['mensagem'] = $resposta['mensagem'] ?? 'Erro ao remover avaliação.';
            $_SESSION['tipo-msg'] = 'erro';
        }

        header("Location: " . BASE_URL . "index.php?url=avaliacao");
        exit;
    }
}
