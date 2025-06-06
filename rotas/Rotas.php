<?php
 
class Rotas
{
    public function executar()
    {
        $url = '/';
 
        if (isset($_GET['url'])) {
            $url .= $_GET['url'];
        }
 
        $parametro = array();
 
        if (!empty($url) && $url != '/') {
 
            $url = explode('/', $url);
            array_shift($url);
 
            $controladorAtual = ucfirst($url[0]) . 'Controller';
            array_shift($url);
 
            if (isset($url[0]) && !empty($url[0])) {
                $acaoAtual = $url[0];
                array_shift($url);
            } else {
                $acaoAtual = 'index';
            }
 
            // Se ainda tiver algum elemento na URL será considerado parâmetro.
            if (count($url) > 0) {
                $parametro = $url;
            }
        } else {
            $controladorAtual = 'LoginController';
            $acaoAtual = 'index';
        }
 
        // Verificar se o arquivo do controlador existe e se o método existe
        if (!file_exists('../app/controllers/' . $controladorAtual . '.php') || !method_exists($controladorAtual, $acaoAtual)) {
            echo 'Estou aqui, Não existe o arquivo ' . $controladorAtual . ' e nem a ação atual ' . $acaoAtual;
 
            // Definir um controlador de erro
            $controladorAtual = 'ErroController';
            $acaoAtual = 'index';
        }
 
        // Criar uma instância para o controlador atual
        $controler = new $controladorAtual;
 
        // Chamar o método correspondente no controlador com os parâmetros
        call_user_func_array(array($controler, $acaoAtual), $parametro);
    }
}
?>
 