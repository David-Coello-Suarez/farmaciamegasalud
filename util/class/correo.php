<?
    ini_set('display_errors', 1);
    ini_set('error_reporting', E_ALL);
    ini_set('display_startup_errors', 1);
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    require '../correo/PHPMailer/src/Exception.php';
    require '../correo/PHPMailer/src/PHPMailer.php';
    require '../correo/PHPMailer/src/SMTP.php';
    
    class Correo{
        
        public $mail;
        
        public function __construct(){
            $this->mail = new PHPMailer();
            $this->mail->Host       = 'farmaciasmegasalud.com';
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = 'mail.farmaciasmegasalud.com';
            $this->mail->Password   = 'o~qUQj69=^LR';
            $this->mail->SMTPSecure = 'ssl';
            $this->mail->Port       = 465;
            $this->mail->CharSet = 'UTF-8';
            $this->mail->AddEmbeddedImage('../../img/icons-v2.png', 'logo_2u');
        }
        
        public function EnviarCorreo($copia, $para, $cuerpo, $subjet = "Detalle de compra"){
            $this->mail->addCC($copia);
            $this->mail->setFrom('ventas@farmaciasmegasalud.com');
            $this->mail->addAddress($para);
            
            $this->mail->IsHTML(true);
            $this->mail->Body = $cuerpo;
            $this->mail->MsgHTML($cuerpo);
            $this->mail->Subject = $subjet;
            
            if( $this->mail->send() ){
                return true;
            }else{
                return false;
            }
        }
    }