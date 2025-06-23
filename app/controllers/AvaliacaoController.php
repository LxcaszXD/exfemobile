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

        $id = $dadosToken['id'] ?? null;
        if (!$id) {
            echo "ID do cliente não disponível.";
            exit;
        }

        // Requisição de avaliações
        $urlAvaliacoes = BASE_API . "listarAvaliacoes?id=" . $id;
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

        // Requisição unificada de produtos + acompanhamentos
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
            'produtos' => $respostaItens['itens'] ?? []
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
            'id_cliente'     => $id_cliente,
            'id_produto'     => $_POST['id_produto'],
            'nota'           => $_POST['nota_avaliacao'],
            'comentario'     => $_POST['comentario_avaliacao'],
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
}
