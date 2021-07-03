<?php 
// Inicia a sessão
session_start();

// Inclui o arquivo class.phpmailer.php localizado na mesma pasta do arquivo php 
include "../assets/PHPMailer-master/PHPMailerAutoload.php"; 

// Função para formatar o código
function form_cod($mascara, $value){
    return vsprintf($mascara, str_split($value));  
}
// Mascara do Cógigo
function cod($value){
    $cod = "%s%s%s-%s%s%s";
    $cod_form = form_cod($cod, $value);
    return $cod_form;
}
function to_numero($value){
    $num = "%/%d%d%/%d%d%d%d%d%/%d%d%d%d";
    $num_form = form_cod($num, $value);
    return $num_form;
}
function telefone($value){
    $tel = "(%d%d)%d%d%d%d%d-%d%d%d%d" ;
    $tel_form = form_cod($tel, $value);
    return $tel_form;
}


// Dados do usuário
$emailenviar  = $_POST['email'];
$nome         = $_POST['nome'];
$telefone     = $_POST['telefone'];
$mensagem     = $_POST['mensagem'];


// Váriáveis para enviar mensagem no WhatsApp
$tel_destino   = '19987208587'; // Digite o número de destino
$num_whats     = telefone($telefone);
$num_whats     = to_numero($num_whats);
$mensagem      = preg_replace('/[ -]+/' , '%20' , $mensagem);

// Link para conversar por Whats App

$link = "https://api.whatsapp.com/send?phone=55".$tel_destino."&text=".$mensagem;


// Inicia a classe PHPMailer 
$mail = new PHPMailer(); 

// Método de envio 
$mail->IsSMTP(); 

// Enviar por SMTP 
$mail->Host = "mail.dueeme.com.br"; 

// Você pode alterar este parametro para o endereço de SMTP do seu provedor 
$mail->Port = 587; 


// Usar autenticação SMTP (obrigatório) 
$mail->SMTPAuth = true; 

// Usuário do servidor SMTP (endereço de email) 
// obs: Use a mesma senha da sua conta de email 
$mail->Username = 'estetica@dueeme.com.br'; 
$mail->Password = 'Olecran1.'; 

// Configurações de compatibilidade para autenticação em TLS 
$mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) ); 

// Você pode habilitar esta opção caso tenha problemas. Assim pode identificar mensagens de erro. 
// $mail->SMTPDebug = 2; 

// Define o remetente 
// Seu e-mail 
$mail->From = "estetica@dueeme.com.br"; 

// Seu nome 
$mail->FromName = "[NOME DA EMPRESA]"; 

// Define o(s) destinatário(s) 
$mail->AddAddress($emailenviar, $nome); 

// Opcional: mais de um destinatário
// $mail->AddAddress('fernando@email.com'); 

// Opcionais: CC e BCC
// $mail->AddCC('joana@provedor.com', 'Joana'); 
// $mail->AddBCC('roberto@gmail.com', 'Roberto'); 

// Definir se o e-mail é em formato HTML ou texto plano 
// Formato HTML . Use "false" para enviar em formato texto simples ou "true" para HTML.
$mail->IsHTML(true); 

// Charset (opcional) 
$mail->CharSet = 'UTF-8'; 

// Assunto da mensagem 
$mail->Subject = "SOLICITAÇÃO DE ORÇAMENTO"; 

// Corpo do email 
$mail->Body = 'Olá '.$nome.', Tudo bem ? <br><br>

Obrigado(a) por se interessar em nossos serviços!
<br><br>
Segue ao lado o link de nosso catálogo no WhatsApp, caso você não tenha sido redirecionado automaticamente: https://wa.me/c/5519987814182 .


'; 

// Opcional: Anexos 
// $mail->AddAttachment("/home/usuario/public_html/documento.pdf", "documento.pdf"); 

// Envia o e-mail 
$enviado = $mail->Send(); 

// Exibe uma mensagem de resultado 
if ($enviado) 
{ 
    
    header('location:'.$link.'');
} else { 

    ?>
    <script type="text/javascript">
        alert('Ops, solicitação não enviada, tente novamente mais tarde !');
    </script>
    <?php


    // Erro:
    // echo "Houve um erro enviando o email: ".$mail->ErrorInfo; 
} 


?>