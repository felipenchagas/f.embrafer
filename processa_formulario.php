<?php
// Ativa a exibição de erros para depuração (remova ou comente essas linhas em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclui os arquivos do PHPMailer (ajuste o caminho conforme necessário)
require_once("novo/class.phpmailer.php");
require_once("novo/class.smtp.php");

// Conectar ao primeiro banco de dados (informações fornecidas)
$servidor1 = "162.214.145.189"; // IP do banco de dados
$usuario1 = "empre028_felipe";   // Usuário do banco de dados
$senha1 = "Iuh86gwt--@Z123";     // Senha do banco de dados
$banco1 = "empre028_orcamentos"; // Nome do banco de dados

// Conectar ao segundo banco de dados (Locaweb)
$servidor2 = "localhost"; // Banco de dados local (Locaweb)
$usuario2 = "embra_usuario";
$senha2 = "uRXA1r9Z7pv~Cw";
$banco2 = "embra_orcamentos";

// Criar as conexões
$conexao1 = new mysqli($servidor1, $usuario1, $senha1, $banco1);
$conexao2 = new mysqli($servidor2, $usuario2, $senha2, $banco2);

// Verifica se há erro nas conexões e exibe os erros
if ($conexao1->connect_error) {
    // Exibe erros de conexão
    exit("Erro ao conectar ao primeiro banco de dados (BD1): " . $conexao1->connect_error . "<br>");
}

if ($conexao2->connect_error) {
    // Exibe erros de conexão
    exit("Erro ao conectar ao segundo banco de dados (BD2): " . $conexao2->connect_error . "<br>");
}

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
        session_start();
        $_SESSION['erros'] = $erros;
        header('Location: index.php?erro=true');
        exit();
    }

    $db1_sucesso = false;
    $db2_sucesso = false;

    // Insere no primeiro banco de dados (se a conexão for bem-sucedida)
    if (!$conexao1->connect_error) {
        $sql = "INSERT INTO orcamentos (nome, email, ddd, telefone, cidade, estado, descricao, data_envio)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

        if ($stmt1 = $conexao1->prepare($sql)) {
            $stmt1->bind_param("sssssss", $nome, $email, $ddd, $telefone, $cidade, $estado, $descricao);
            if ($stmt1->execute()) {
                $db1_sucesso = true; // Marca como bem-sucedido no DB1
            }
            $stmt1->close();
        }
    }

    // Insere no segundo banco de dados (se a conexão for bem-sucedida)
    if (!$conexao2->connect_error) {
        $sql = "INSERT INTO orcamentos (nome, email, ddd, telefone, cidade, estado, descricao, data_envio)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

        if ($stmt2 = $conexao2->prepare($sql)) {
            $stmt2->bind_param("sssssss", $nome, $email, $ddd, $telefone, $cidade, $estado, $descricao);
            if ($stmt2->execute()) {
                $db2_sucesso = true; // Marca como bem-sucedido no DB2
            }
            $stmt2->close();
        }
    }

    // Verifica se pelo menos uma inserção foi bem-sucedida
    if (!$db1_sucesso && !$db2_sucesso) {
        exit("Erro: Não foi possível salvar os dados em nenhum dos bancos de dados.");
    }

    // Fecha as conexões
    if (!$conexao1->connect_error) {
        $conexao1->close();
    }
    if (!$conexao2->connect_error) {
        $conexao2->close();
    }

    // Envia o e-mail utilizando o PHPMailer
    $mail = new PHPMailer();

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'mail.embrafer.com'; // Endereço do servidor SMTP
        $mail->SMTPAuth   = true;                // Habilitar autenticação SMTP
        $mail->Username   = 'contato@embrafer.com'; // Usuário SMTP
        $mail->Password   = 'eneastroca8081!';       // Senha SMTP
        $mail->SMTPSecure = 'tls';               // Criptografia TLS
        $mail->Port       = 587;                  // Porta SMTP

        // Remetente e destinatário
        $mail->setFrom('contato@embrafer.com', 'Site');
        $mail->addAddress('contato@embrafer.com', 'Embrafer'); // Destinatário

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8'; // Definindo o charset para UTF-8
        $mail->Subject = 'CONTATO - SITE - EMBRAFER';

        // Montagem do corpo do e-mail com meta charset
        $mensagemHTML = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
            <title>Contato do Site</title>
        </head>
        <body>
            <p style='text-align: center;'><strong><span style='font-size: 20pt; font-family: Arial;'>Contato do Site</span></strong></p>
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
        </body>
        </html>
        ";

        $mail->Body = $mensagemHTML;

        // Envia o e-mail
        $mail->send();

        // Redireciona para a página de sucesso
        header('Location: sucesso.html');
        exit();
    } catch (phpmailerException $e) {
        // Em caso de erro no envio do e-mail, redireciona para uma página de erro
        header('Location: erro.html');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>
