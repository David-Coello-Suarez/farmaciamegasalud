<?

ini_set('display_errors', 1);

try {

    $to = "coellosuarezd@gmail.com";
    $subject = "Esto es  un  prueba de local";

    $message = "
<html>
<head>
<title>This is a test HTML email</title>
</head>
<body>
<p>Test email. Please ignore.</p>
</body>
</html>
";

    // It is mandatory to set the content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers. From is required, rest other headers are optional
    $headers .= "To: coellosuarezd@gmail.com";
    $headers .= 'From: dfcoello@est.itsgg.edu.ec' . "\r\n";
    $headers .= 'Cc: dcoello@macrogramec.com' . "\r\n";

    if ( mail( $to,$subject, $message, $headers) ) {
        echo "True";
    } else {
        echo "false";
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$e->ErrorInfo}";
}
