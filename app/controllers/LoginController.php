<?php

class LoginController extends Controller
{
    public function index()
    {
        $dados = array();
        $dados['titulo'] = 'Exfe - Login';

        $this->carregarViews('login', $dados);
    }

    //Método de autenticação
    public function autenticar()
    {
        $email = $_POST['email'] ?? null;
        $senha = $_POST['senha'] ?? null;

        //Fazer a requisição da API de login
        $url = BASE_API . "login?email_cliente=$email&senha_cliente=$senha";

        //Reconhecimento da chave (Inicializa uma sessão cURL)
        $ch = curl_init($url);
        //Definir que o conteudo venha com string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Recebe os dados dessa solicitação
        $response = curl_exec($ch);
        //Obtém o código HTTP da resposta (200, 400, 401)
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //Encerra a sessão cURL
        curl_close($ch);

        if ($statusCode == 200) {

            $data = json_decode($response, true);

            if (!empty($data['token'])) {
                $_SESSION['token'] = $data['token'];

                header("Location: " . BASE_URL . "index.php?url=menu");
                exit;
            } else {
                header("Location: " . BASE_URL . "index.php?url=login");
                exit;
            }
        } else {
            echo "Login Inválido";
        }
    }

    public function esqueciSenha()
    {
        $dados = array();
        $dados['titulo'] = 'Recuperar Senha - Exfé';

        $this->carregarViews('recuperar_senha', $dados);
    }

    // Enviar e-mail de recuperação de senha
    public function enviarRecuperacao()
    {
        $email = $_POST['email'] ?? null;

        if (!$email) {
            $_SESSION['flash'] = "Informe um e-mail válido.";
            header("Location: " . BASE_URL . "index.php?url=login/esqueciSenha");
            exit;
        }

        $url = BASE_API . "recuperarSenha";

        $postFields = http_build_query([
            'email_cliente' => $email
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $data = json_decode($response, true);

        if ($statusCode === 200) {
            $_SESSION['flash'] = $data['mensagem'] ?? 'Verifique seu e-mail para continuar.';
        } else {
            $_SESSION['flash'] = $data['erro'] ?? 'Erro ao solicitar redefinição.';
        }

        header("Location: " . BASE_URL . "index.php?url=login/esqueciSenha");
        exit;
    }
}
