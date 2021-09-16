<?
class Session
{
    public function __construct()
    {
        session_name("farmaciamega_salud");
        session_start();
    }

    public function checkSession()
    {
        $check = false;
        if (
            isset($_SESSION['usuario']) &&
            !empty($_SESSION['usuario'])
        ) {
            $check = true;
        }
        return $check;
    }

    public function createSession(array $data)
    {
        $_SESSION = array();
        $_SESSION['usuario'] = $data;
    }

    public function endSession()
    {
        $_SESSION = array();
        if (ini_get('session.use_cookies')) {
            $parmas = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $parmas['path'], $parmas['domain'], $parmas['secure'], $parmas['httponly']);
        }
        session_destroy();
    }
}
