<?php
    require_once "../config/database.php";
    require_once "../config/config.php";

    if($_SERVER['REQUEST_METHOD']==='POST'){
        if(isset($_POST['nome_recurso'], $_POST['tipo_recurso'])) {
            $nome_recurso = $_POST['nome_recurso'];
            $tipo_recurso = $_POST['tipo_recurso'];

            if($tipo_recurso === 'sala'){
                

            }else if($tipo_recurso === 'equipamento'){

            }else if($tipo_recurso === 'viatura'){

            }
        } else {
            header("Location: " . BASE_URL . "recursos/criar.php?erro_campos=" . urlencode("Por favor, preencha todos os campos obrigatórios."));
            exit();
        }
    } else {
        header("Location: " . BASE_URL . "recursos/criar.php");
        exit();
    }