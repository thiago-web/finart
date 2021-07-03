<?php
session_start();

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

// Dados da empresa
$nome_empresa  = '[nome]'; // Difite o nome da empresa
$tel_empresa   = '[telefone]'; // Número telefone da empresa
$email_empresa = '[email]'; // Email da empreaa

// Váriáveis para enviar mensagem no WhatsApp
$tel_destino   = '19987208587'; // Digite o número de destino
$num_whats     = telefone($telefone);
$num_whats     = to_numero($num_whats);
$mensagem      = preg_replace('/[ -]+/' , '%20' , $mensagem);

// Link para conversar por Whats App

$link = "https://api.whatsapp.com/send?phone=55".$tel_destino."&text=".$mensagem;


// Email para quem será enviado o formulário
$destino       = $emailenviar;
$assunto       = " Você possui uma nova mensagem de $nome";
$data_envio    = date('d/m/Y');
$hora_envio    = date('H:i');



// É necessário indicar que o formato do e-mail é html
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "From:  ".$nome." <".$emailenviar.">";
//$headers .= "Bcc: $EmailPadrao\r\n";

// Estilização do Campo do Email
// Compo E-mail
$arquivo = "
<style type='text/css'>
body {

}
</style>
<html>

Oi, $nome .<br><br>

Obrigado(a) por se interessar em nossos serviços!<br><br>

Nós não fazemos spam e respeitamos o direito de todo mundo à privacidade online. 
<br>Por isso, você precisa confirmar a sua inscrição antes que nós possamos te enviar outros emails.

Basta clicar no link abaixo.

Confirmar sua inscrição

Se você não se cadastrou no(a) {nome da recompensa} recentemente, por favor ignore este email e nós não entraremos em contato novamente.

{Despedida de sua preferência},

{Nome do seu negócio}

</html>";

// $enviaremail = mail($destino, $assunto, $arquivo, $headers);
if($enviaremail)
{
    $mgm = "E-MAIL ENVIADO COM SUCESSO! <br> O link será enviado para o e-mail fornecido no formulário";
    header('location:'.$link.'');
} 
else {
    header('location:'.$link.'');
}
?>