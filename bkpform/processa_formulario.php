<?php
session_start();

// Ativa a exibição de erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Função para registrar erros em um arquivo de log (opcional)
function logError($message) {
    error_log($message, 3, '/path/to/your/error_log.log'); // Ajuste o caminho do arquivo de log
}

// Conectar ao banco de dados
$servidor1 = "localhost"; // Altere para o IP correto se necessário
$usuario1 = "empre028_felipe";   // Usuário do banco de dados
$senha1 = "Iuh86gwt--@Z123";     // Senha do banco de dados
$banco1 = "empre028_orcamentos"; // Nome do banco de dados

// Criar a conexão
$conexao1 = new mysqli($servidor1, $usuario1, $senha1, $banco1);

// Verifica se há erro na conexão com o BD1
if ($conexao1->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conexao1->connect_error);
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

    // Se houver erros, exibe as mensagens de erro
    if (!empty($erros)) {
        echo "Ocorreram os seguintes erros: <br>";
        foreach ($erros as $erro) {
            echo $erro . "<br>";
        }
        exit();
    }

    // Insere no banco de dados
    $sql = "INSERT INTO orcamentos (nome, email, ddd, telefone, cidade, estado, descricao, data_envio)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

    if ($stmt1 = $conexao1->prepare($sql)) {
        $stmt1->bind_param("sssssss", $nome, $email, $ddd, $telefone, $cidade, $estado, $descricao);
        if ($stmt1->execute()) {
            echo "Dados inseridos com sucesso!";
        } else {
            logError("Erro ao inserir dados no banco de dados: " . $stmt1->error);
            echo "Erro ao inserir dados no banco de dados.";
        }
        $stmt1->close();
    } else {
        logError("Erro ao preparar a consulta no banco de dados: " . $conexao1->error);
        echo "Erro ao preparar a consulta no banco de dados.";
    }

    // Fecha a conexão com o banco
    $conexao1->close();

    // Envia o e-mail utilizando o PHPMailer
    require_once("novo/class.phpmailer.php");
    require_once("novo/class.smtp.php");

    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTPGo
        $mail->isSMTP();
        $mail->Host       = 'smtp.smtpgo.com';    // Endereço do servidor SMTPGo
        $mail->SMTPAuth   = true;                 // Habilitar autenticação SMTP
        $mail->Username   = 'felipe@empresarialweb.com.br';    // Seu nome de usuário no SMTPGo
        $mail->Password   = 'Iuh86gwt--@';        // Sua senha ou chave de API no SMTPGo
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Criptografia TLS
        $mail->Port       = 587;                  // Porta SMTP

        // Remetente e destinatário
        $mail->setFrom('felipe@empresarialweb.com.br', 'Site Empresarial');
        $mail->addAddress('seu_email@gmail.com', 'Destinatário'); // E-mail de destino

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';                 // Definindo o charset para UTF-8
        $mail->Subject = 'Novo Contato - Site Empresarial';

        // Montagem do corpo do e-mail
        $mail->Body = "
            <html>
            <body>
                <h3>Contato recebido pelo site</h3>
                <p><strong>Nome:</strong> $nome</p>
                <p><strong>E-mail:</strong> $email</p>
                <p><strong>Telefone:</strong> ($ddd) $telefone</p>
                <p><strong>Cidade:</strong> $cidade</p>
                <p><strong>Estado:</strong> $estado</p>
                <p><strong>Descrição:</strong> $descricao</p>
                <p><strong>Data:</strong> " . date('d/m/Y H:i:s') . "</p>
            </body>
            </html>
        ";

        // Envia o e-mail
        $mail->send();

        // Redireciona para a página de sucesso
        header('Location: sucesso.html');
        exit();
    } catch (Exception $e) {
        logError("Erro ao enviar e-mail: " . $mail->ErrorInfo);
        echo "Erro ao enviar e-mail.";
    }

} else {
    echo "Nenhum dado enviado.";
}
