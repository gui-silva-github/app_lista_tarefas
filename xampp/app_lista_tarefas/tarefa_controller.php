<?php

    require("../../app_lista_tarefas/tarefa.model.php");
    require("../../app_lista_tarefas/tarefa.service.php");
    require("../../app_lista_tarefas/conexao.php");

    $acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

    $descricao = filter_input(INPUT_POST, 'tarefa', FILTER_SANITIZE_SPECIAL_CHARS);

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $idGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    if($acao == 'inserir'){

        $tarefa = new Tarefa();
        $tarefa->__set('tarefa', $descricao);

        $conexao = new Conexao();

        $tarefaService = new TarefaService($conexao, $tarefa);
        $tarefaService->inserir();

        header('Location: nova_tarefa.php?inclusao=1');
    
    } else if($acao == 'recuperar'){

        $tarefa = new Tarefa();
        $conexao = new Conexao();

        $tarefaService = new TarefaService($conexao, $tarefa);
        $tarefas = $tarefaService->recuperar();

    } else if($acao == 'atualizar'){

        $tarefa = new Tarefa();
        $tarefa->__set('id', $id)
                ->__set('tarefa', $descricao);

        $conexao = new Conexao();

        $tarefaService = new TarefaService($conexao, $tarefa);

        if($tarefaService->atualizar()){

            if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
                header('Location: index.php');
            } else {
                header('Location: todas_tarefas.php');
            }
            
        }

    } else if($acao == 'remover'){

        $tarefa = new Tarefa();
        $tarefa->__set('id', $idGet);

        $conexao = new Conexao();

        $tarefaService = new TarefaService($conexao, $tarefa);
        $tarefaService->remover();

        if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
            header('Location: index.php');
        } else {
            header('Location: todas_tarefas.php');
        }

    } else if($acao == 'marcarRealizada'){

        $tarefa = new Tarefa();
        $tarefa->__set('id', $idGet)->__set('id_status', 2);

        $conexao = new Conexao();

        $tarefaService = new TarefaService($conexao, $tarefa);
        $tarefaService->marcarRealizada();

        if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
            header('Location: index.php');
        } else {
            header('Location: todas_tarefas.php');
        }

    } else if($acao == 'recuperarTarefasPendentes'){

        $tarefa = new Tarefa();
        $tarefa->__set('id_status', 1);

        $conexao = new Conexao();

        $tarefaService = new TarefaService($conexao, $tarefa);
        $tarefas = $tarefaService->recuperarTarefasPendentes();

    }

?>