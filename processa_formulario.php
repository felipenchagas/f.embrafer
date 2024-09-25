<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclui o autoload do Composer (ajuste o caminho conforme necessário)
require 'vendor/autoload.php';

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

    // Envia o e-mail utilizando o PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'mail.embrafer.com'; // Endereço do servidor SMTP
        $mail->SMTPAuth   = true;                // Habilitar autenticação SMTP
        $mail->Username   = 'contato@embrafer.com'; // Usuário SMTP
        $mail->Password   = 'eneastroca8081!';       // Senha SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Criptografia TLS
        $mail->Port       = 587;                         // Porta SMTP

        // Remetente e destinatário
        $mail->setFrom('contato@embrafer.com', 'Site');
        $mail->addAddress('contato@embrafer.com', 'Embrafer'); // Destinatário

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'CONTATO - SITE - EMBRAFER';
        
        // Template do e-mail
        $mensagemHTML = "
        <p style='text-align: center;'><strong><span style='font-size: 20pt; font-family: Arial;'>Contato do Site</span></strong></p>
        <img src='http://www.estruturametalicasc.com.br/img/logo.png' alt='Logo'> <br />
        <img style='float: left;' src='https://www.embrafer.com/images/estrutura-metalica-pre-fabricada.jpg' alt='Imagem'>
        <table style='width: 552px; border-collapse: collapse; font-family: Arial; font-size: 9pt;'>
            <tbody>
                <tr>
                    <td style='width: 270px; border: 1px solid #4472c4; background: #d9e2f3; padding: 5px;'><strong>Nome do cliente</strong></td>
                    <td style='width: 281px; border: 1px solid #4472c4; padding: 5px;'>$nome</td>
                </tr>
                <tr>
                    <td style='width: 270px; border: 1px solid #4472c4; background: #d9e2f3; padding: 5px;'><strong>Email</strong></td>
                    <td style='width: 281px; border: 1px solid #4472c4; padding: 5px;'>$email</td>
                </tr>
                <tr>
                    <td style='width: 270px; border: 1px solid #4472c4; background: #d9e2f3; padding: 5px;'><strong>Telefone</strong></td>
                    <td style='width: 281px; border: 1px solid #4472c4; padding: 5px;'>($ddd) $telefone</td>
                </tr>
                <tr>
                    <td style='width: 270px; border: 1px solid #4472c4; background: #d9e2f3; padding: 5px;'><strong>Cidade</strong></td>
                    <td style='width: 281px; border: 1px solid #4472c4; padding: 5px;'>$cidade</td>
                </tr>
                <tr>
                    <td style='width: 270px; border: 1px solid #4472c4; background: #d9e2f3; padding: 5px;'><strong>Estado</strong></td>
                    <td style='width: 281px; border: 1px solid #4472c4; padding: 5px;'>$estado</td>
                </tr>
                <tr>
                    <td style='width: 270px; border: 1px solid #4472c4; background: #d9e2f3; padding: 5px;'><strong>Descrição do Orçamento</strong></td>
                    <td style='width: 281px; border: 1px solid #4472c4; padding: 5px;'>$descricao</td>
                </tr>
                <tr>
                    <td colspan='2' style='padding: 10px 5px;'>
                        <strong>Data de Envio:</strong> " . date('d/m/Y H:i:s') . "
                    </td>
                </tr>
            </tbody>
        </table>
        ";

        $mail->Body = $mensagemHTML;

        // Envia o e-mail
        $mail->send();

        // Redireciona para a página de sucesso
        header('Location: sucesso.html');
        exit();
    } catch (Exception $e) {
        // Em caso de erro no envio do e-mail, você pode logar o erro ou exibir uma mensagem
        // Aqui, vamos redirecionar para uma página de erro
        header('Location: erro.html');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>
