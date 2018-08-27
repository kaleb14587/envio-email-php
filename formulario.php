<?php
/**
 * Created by PhpStorm.
 * User: nitro
 * Date: 27/08/18
 * Time: 10:08
 */
//phpinfo();
include "init.php";
$phpMailler  = new PHPMailer();
if($_POST){

    /**
     * seta o servico smtp que sera usado
     * @var PHPMailer $phpMailler */
    $phpMailler->isSMTP();
    //variaveis em init.php
    $phpMailler->SMTPDebug = 0;		        // Debugar: 1 = erros e mensagens, 2 = mensagens apenas
    $phpMailler->SMTPAuth = SMTP_AUTH;		// Autenticação ativada
    $phpMailler->SMTPSecure = SMTP_SECURE;	// SSL REQUERIDO pelo GMail
    $phpMailler->Host = SMTP_HOST;	        // SMTP utilizado
    $phpMailler->Port = SMTP_PORT;  		// A porta 587 deverá estar aberta em seu servidor
    $phpMailler->Username = SMTP_USER_NAME;
    $phpMailler->Password = SMTP_USER_PASSWORD;
    try{
        // inicia a preparação do email
        $form  = trataFormulario();
        //seta quem esta fazendo o envio
        $phpMailler->SetFrom($form->email, $form->nome);
        //assunto do email
        $phpMailler->Subject = date('d/m/Y')."Contato no site ";
        //cria o email em si
        $phpMailler->Body = (bodyEmailContato(
            $form->mensagem,
            $form->nome,
            $form->email,
            $form->telefone));
        //adiciona o endereço de destino
        $phpMailler->AddAddress('kaleb.borda@nitrodev.com');
        //realiza o envio
        if(!$phpMailler->Send()) {
            //ocorreu algum erro
            responseJson([
                'ok'=>true,
                'codigoErro'=>EMAIL_NAO_ENVIADO_CODE,
                'mensagem'=>"ocorreu algum erro ao enviar, tente novamente mais tarde!"
            ],$e->getCode());
        } else {
            //sem erros envia mensagem somente de sucesso
            responseJson([
                'ok'=>false,
                'mensagem'=>"email enviado com sucesso!"
            ]);
        }
    }catch (\Exception $e){
        //ocorreu algum erro
        responseJson([
            'ok'=>false,
            'codigoErro'=>$e->getCode(),
            'mensagem'=>$e->getMessage()
        ],$e->getCode());
    }
}

