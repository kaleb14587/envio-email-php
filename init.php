<?php
/**
 * Created by PhpStorm.
 * User: nitro
 * Date: 27/08/18
 * Time: 10:26
 */
//load da biblioteca phpmailler
require_once __DIR__.DIRECTORY_SEPARATOR."phpmailler/class.phpmailer.php";

//configurações
define('SMTP_HOST','smtp.mailtrap.io');//smtp.gmail.com
define('SMTP_AUTH',true);
define('SMTP_SECURE',false);//ssl
define('SMTP_PORT',2525);//587
define('SMTP_USER_NAME',"user_mail_trap");//
define('SMTP_USER_PASSWORD','pwd_mailtrap');//

//erros
define("EMAIL_NAO_ENVIADO_CODE",514);


//HELPERS FUNCTIONS

/**
 * funcao de debugg
 * @param $item
 */
function dd($item){
    echo "<pre>";
    var_dump($item);
    exit();
}

/**
 * - retorna um objeto do formulario já validado
 * - dispara exceção para o que nao estiver de acordo
 *
 * @return stdClass
 * @throws Exception
 */
function trataFormulario(){
    if(empty($_POST)) throw new Exception("formulario incompleto",210);
    $email    = post('email') ? post('email')  :exception("email nao preenchido",211);
    $nome     = post('nome')? post('nome') : exception("nome nao preenchido",212);
    $mensagem = post('mensagem')? post('mensagem') : exception("mensagem nao preenchido",213);
    $telefone = post('telefone')? post('telefone') : exception("telefone nao preenchido",214);

    $formulario = new stdClass();

    $formulario ->email = $email;
    $formulario ->nome = $nome;
    $formulario ->mensagem = $mensagem;
    $formulario ->telefone = $telefone;

    return $formulario;
}
function post($index){
    if(isset($_POST[$index])){
        return htmlentities($_POST[$index]);
    }else return "";
}
/**
 * - gera excessoes de erro
 * - e faz a validação de erro obrigatorio ou não
 *
 * @param $message
 * @param $code
 * @throws Exception
 */
function exception($message, $code){
    // se estiver entre 210 e 2014
    // é validação de formulario se campo
    // nao obrigatorio retorna branco
    if($code >209 and $code <215 ){
        if($code== 214)return "";
    }
    //gera a excessao
    throw new Exception($message,$code);
}

/**
 * - email que sera enviado para o email do site
 * @param $mensagem
 * @param null $nome
 * @param null $email
 * @param null $telefone
 * @return string
 */
function bodyEmailContato($mensagem, $nome=null, $email=null, $telefone= null){
    $mensagem = htmlentities($mensagem);
    $nome = htmlentities($nome);
    $telefone = htmlentities($telefone);
   $body =  "Assunto: ".date('[d/m/Y|H:i:s]')." Contato no site renatoklixadvogados.com.br\n
    \n\nNome: $nome\nEmail: $email\nTelefone: $telefone\n
Mensagem:\n\n$mensagem";

   return $body;
}

/**
 * - cria o header de resposta REST
 * - e finaliza qualquer execução
 * @param array $msg
 * @param int $code
 */
function responseJson($msg = [], $code =200){
    $data = $msg;
    header('Content-Type: application/json');
    header("HTTP/1.1 ".$code." OK");
//    http_response_code($code);
    echo json_encode($data);
    exit();
}
