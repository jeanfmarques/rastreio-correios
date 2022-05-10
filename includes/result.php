<?php

//DEPENDENCIAS DO ARQUIVO
use \App\WebService\Correios\Rastreio;

//ITERA OS OBJETOS RETORNADOS
foreach($response['objetos'] as $objeto) {
    //CÓDIGO DOS OBJETOS

    echo '<h2 class="mt-3">'.$objeto['codObjeto'].'</h2>';

    //VERIFICA OS EVENTOS DO OBJETO

    if(!isset($objeto['eventos'])){
        //MENSAGEM DE ERRO
        $mensagem = $objeto['mensagem'] ?? 'Problemas ao buscar dados da API dos Correios';


        //ALERTA NO HTML
        echo '<div class="alert alert-warning">'.$mensagem.'</div>';
        
        //PULA PARA O PROXIMO INDICE
        continue;
    }

    //ITERA OS EVENTOS DO OBJETO
    foreach($objeto['eventos'] as $evento){

        //IMAGEM
        $imagem = isset($evento['urlIcone']) ? '<div style="width:150px;"> <img src="'.Rastreio::URL_BASE.$evento['urlIcone'].'"> </div>' : '';

        //CIDADE
        $cidade = isset($evento['unidade']['endereco']['cidade']) ? $evento['unidade']['endereco']['cidade'].'/ '.$evento['unidade']['endereco']['uf'] : null;

        //DADOS DESCRITIVOS DO EVENTO
        $dados = [$evento['descricao'],$cidade,$evento['unidade']['nome'] ?? null];
        //HTML COMPLETO

        echo '<div class="alert alert-light d-flex align-items-center">
        '.$imagem.'
        <div style="flex:1;">
        '.implode(' - ',array_filter($dados)).'
        </div>

        <div style="width:200px;">
        <span class="badge bg-dark">
        '.date('d/m/Y à\s H:i:s',strtotime($evento['dtHrCriado'])).'
        </span>
        </div>
        </div>';
    }
}
