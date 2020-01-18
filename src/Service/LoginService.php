<?php

namespace Service;

use Repository\SecurityRepository;

class LoginService {

  protected $securityRepository;
  private $username;
  private $password;

  public function __construct() {
    $this->msg = new \Plasticbrain\FlashMessages\FlashMessages();
    $this->username = strip_tags(htmlspecialchars($_POST['username']));
    $this->password = strip_tags(htmlspecialchars($_POST['password']));
    $this->securityRepository = new SecurityRepository;
  }


  private function getUrl(bool $referer = false) {
        if ($referer == true) {
            return $_SERVER['HTTP_REFERER'];
        } else {
            return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }
    }

  public function checkAttempts($array, $ip, $username) {
      $count = $this->securityRepository->checkBruteForce($ip, $username);
      if ($count < 3) {
          $this->securityRepository->registerAttempt($ip, $username);
          $count += 1;
          if ($count < 2) {
              $array["error"] = 'identifiant ou mot de passe incorrect !Il vous reste '.(3 - $count).' tentatives';
              $array["isSuccess"] = false;
              return $array;
          } elseif ($count == 2) {
              $array["error"] = 'identifiant ou mot de passe incorrect !Il vous reste une tentative';
              $array["isSuccess"] = false;
          } else {
              $array["error"] = 'Nombre de tentatives atteintes! Vous pourrez essayer de vous reconnecter dans 24h.';
              $array["isSuccess"] = false;
          }
      } elseif ($count == 3) {
          $attempts = $this->securityRepository->getAttempts($ip);
          date_default_timezone_set('Europe/Paris');
          $now = strtotime(date("Y-m-d H:i:s"));
          $limitAttemptsDate = strtotime($attempts[2]['tried_at_plus_one_day']);
          if (isset($limitAttemptsDate)) {
              $diff = round(($limitAttemptsDate - $now)/3600);
              if ($diff > 0) {
                  $array["error"] = 'Nombre de tentatives atteintes! Vous pourrez essayer de vous reconnecter dans '.$diff.'h.';
                  $array["isSuccess"] = false;
              } else {
                  $this->securityRepository->deleteAttempts($ip);
                  $this->securityRepository->registerAttempt($ip, $username);
                  $count = 1;
                  $array["error"] = 'identifiant ou mot de passe incorrect !Il vous reste 2 tentatives';
              }
          }
      }
      return $array;
  }
}
