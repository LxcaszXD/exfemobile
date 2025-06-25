<?php
class InstalacaoController extends Controller
{
    public function index()
    {
        $dados = [
            'titulo' => 'Instale o App - Exfé'
        ];

        $this->carregarViews('instalacao', $dados);
    }
}
