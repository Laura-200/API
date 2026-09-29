<?php

header("Content-Type: application/json");
require "conexao.php";

$metodo = $_SERVER["REQUEST_METHOD"];

//POST
if ($metodo == "POST") {
    $json = file_get_contents("php://input");
    $dados = json_decode($json, true);

    if (empty($dados["equipamento"]) || empty($dados["setor"]) || empty($dados["descricao"]) || empty($dados["prioridade"]) || empty($dados["status"])) {
        echo json_encode(["Mensagem" => "Erro: Todos os dados sao obrigatorios!"]);
        exit;
    }

    if ($dados["prioridade"] != "baixa" && $dados["prioridade"] != "media" && $dados["prioridade"] != "alta") {
        echo json_encode(["Mensagem" => "Erro: A prioridade deve ser baixa, media ou alta."]);
        exit;
    }
    if ($dados["status"] != "aberto" && $dados["status"] != "em andamento" && $dados["status"] != "concluido") {
        echo json_encode(["Mensagem" => "Erro: O status deve ser aberto, em andamento ou concluido."]);
        exit;
    }

    $sql = "INSERT INTO chamados(equipamento, setor, descricao, prioridade, status) VALUES (?,?,?,?,?)";
    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["equipamento"],
        $dados["setor"],
        $dados["descricao"],
        $dados["prioridade"],
        $dados["status"]
    ]);

    echo json_encode(["Mensagem" => "Chamado cadastrado com sucesso!"]);
}

//GET
if ($metodo == "GET") {
    $sql = "SELECT * FROM chamados";
    $comando = $pdo->query($sql);
    $resposta = $comando->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($resposta);
}

// 3. MÉTODO PUT - ATUALIZAR CHAMADO
if ($metodo == "PUT") {
    $json = file_get_contents("php://input");
    $dados = json_decode($json, true);

    if (empty($dados["id"]) || empty($dados["equipamento"]) || empty($dados["setor"]) || empty($dados["descricao"]) || empty($dados["prioridade"]) || empty($dados["status"])) {
        echo json_encode(["Mensagem" => "Erro: O id e todos os campos sao obrigatorios para atualizar!"]);
        exit;
    }

    if ($dados["prioridade"] != "baixa" && $dados["prioridade"] != "media" && $dados["prioridade"] != "alta") {
        echo json_encode(["Mensagem" => "Erro: A prioridade deve ser baixa, media ou alta."]);
        exit;
    }
    if ($dados["status"] != "aberto" && $dados["status"] != "em andamento" && $dados["status"] != "concluido") {
        echo json_encode(["Mensagem" => "Erro: O status deve ser aberto, em andamento ou concluido."]);
        exit;
    }

    $sql = "UPDATE chamados SET equipamento = ?, setor = ?, descricao = ?, prioridade = ?, status = ? WHERE id = ?";
    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["equipamento"],
        $dados["setor"],
        $dados["descricao"],
        $dados["prioridade"],
        $dados["status"],
        $dados["id"]
    ]);

    echo json_encode(["Mensagem" => "Chamado atualizado com sucesso!"]);
}

//DELETE
if ($metodo == "DELETE") {
    $json = file_get_contents("php://input");
    $dados = json_decode($json, true);

    if (empty($dados["id"])) {
        echo json_encode(["Mensagem" => "Erro: O id e obrigatorio para excluir!"]);
        exit;
    }

    $sql = "DELETE FROM chamados WHERE id = ?";
    $comando = $pdo->prepare($sql);
    $comando->execute([
        $dados["id"]
    ]);

    echo json_encode(["Mensagem" => "Chamado excluido com sucesso!"]);
}
