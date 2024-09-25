$mail->isHTML(true);
$mail->CharSet = 'UTF-8'; // Definindo o charset para UTF-8
$mail->Subject = 'CONTATO - SITE - EMBRAFER';
        

// Montagem do corpo do e-mail com meta charset
$mensagemHTML = "
       <!DOCTYPE html>
@@ -138,4 +138,37 @@ function sanitizar($data) {
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