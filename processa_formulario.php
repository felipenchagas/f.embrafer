<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Função para sanitizar os dados de entrada
    function sanitizar($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    // Captura e sanitiza os dados do formulário
    $nome = sanitizar($_POST['nome']);
    $email = sanitizar($_POST['email']);
    $ddd = sanitizar($_POST['ddd']);
    $telefone = sanitizar($_POST['telefone']);
    $cidade = sanitizar($_POST['cidade']);
    $estado = sanitizar($_POST['estado']);
    $descricao = sanitizar($_POST['descricao']);

    // Validação básica dos campos obrigatórios
    $erros = array();

    if (empty($nome)) {
        $erros[] = 'O campo Nome é obrigatório.';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = 'E-mail inválido.';
    }

    if (empty($ddd) || !ctype_digit($ddd) || strlen($ddd) != 2) {
        $erros[] = 'DDD inválido.';
    }

    if (empty($telefone) || !ctype_digit($telefone)) {
        $erros[] = 'Telefone inválido.';
    }

    if (empty($cidade)) {
        $erros[] = 'O campo Cidade é obrigatório.';
    }

    if (empty($estado)) {
        $erros[] = 'O campo Estado é obrigatório.';
    }

    if (empty($descricao)) {
        $erros[] = 'O campo Descrição do Orçamento é obrigatório.';
    }

    // Se houver erros, redireciona de volta para o formulário com mensagens de erro
    if (!empty($erros)) {
        // Armazena os erros na sessão para exibição
        session_start();
        $_SESSION['erros'] = $erros;
        header('Location: index.php?erro=true');
        exit();
    }

    // Prepara os dados para salvar
    $dados = array(
        'nome' => $nome,
        'email' => $email,
        'telefone' => "($ddd) $telefone",
        'cidade' => $cidade,
        'estado' => $estado,
        'descricao' => $descricao,
        'data_envio' => date('Y-m-d H:i:s')
    );

    // Converte os dados para JSON
    $dados_json = json_encode($dados) . PHP_EOL;

    // Salva os dados no arquivo
    file_put_contents('contatos.txt', $dados_json, FILE_APPEND | LOCK_EX);

    // Redireciona para a página de sucesso
    header('Location: index.php?success=true');
    exit();
} else {
    header('Location: index.php');
    exit();
}
?>
