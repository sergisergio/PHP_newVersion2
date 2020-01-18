<?php

namespace App\Controller;

use Core\View;
use Core\Request;
use Core\Response;
use Repository\UserRepository;
use Repository\SecurityRepository;
use Service\SecurityService;
use Service\LoginService;
use Service\RegisterService;
use Service\MailService;


/**
 * CLASSE GERANT L'INSCRIPTION, LA CONNEXION ET LA DECONNEXION
 */
class LoginController extends Controller
{
    protected $userRepository;
    protected $securityRepository;
    protected $securityService;
    protected $loginService;
    protected $registerService;
    protected $mailService;

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository;
        $this->securityRepository = new SecurityRepository;
        $this->securityService = new SecurityService;
        $this->loginService = new LoginService;
        $this->registerService = new RegisterService;
        $this->mailService = new MailService;
    }

    /*
     * GERER LA CONNEXION
     */
    public function __invoke(Request $request) {
        if ($this->isLogged()) {
            header('Location: ?c=index');
            exit();
        }

        $array = [
            "username"  => "",
            "password"  => "",
            "error"     => "",
            "success"   => "",
            "isSuccess" => false,
            "role"      => ""
        ];

        if ((isset($_GET['g'])) && $_GET['g'] == 'confirm') {
            $this->msg->success("Votre compte est activé !", 'index.php?c=login');
        } elseif (((isset($_GET['g'])) && $_GET['g'] == 'notvalid') && (isset($_GET['user']))) {
            $username = $_GET['user'];
            $this->msg->success('Ce lien a expiré ! <a href="?c=login&t=resend&user='.$username.'">Renvoyer un lien</a>', 'index.php?c=login');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $username = strip_tags(htmlspecialchars($_POST['username']));
            $password = strip_tags(htmlspecialchars($_POST['password']));
            $checkUser = $this->userModel->getUserByUsernameOrEmail($username);
            $checkPassword = password_verify($password, $checkUser['password']);
            sleep(0.3);
            $ip = $_SERVER['REMOTE_ADDR'];

            if (empty($username) || empty($password)) {
                $array["error"] = "Veuillez remplir les champs !";
                $array["isSuccess"] = false;
            } elseif ($checkUser == false || !$checkPassword) {
                $array = $this->loginService->checkAttempts($array, $ip, $username);
            } else {
                $array["isSuccess"] = true;
                if ($checkUser['roles'] == 1) {
                    $_SESSION['admin'] = $checkUser;
                    $array["role"] = 'admin';
                } else {
                    $_SESSION['user'] = $checkUser;
                    $array["role"] = 'user';
                }
            }
            echo json_encode($array);
        }
    }
}
