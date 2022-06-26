<?php
require_once 'dao/UserDaoMySql.php';
require_once 'config.php';

class Auth
{
    private $pdo;
    private $base;


    public function __construct($pdo, $base)
    {
        $this->pdo = $pdo;
        $this->base = $base;
    }


    public function checkToken()
    {
        if (!empty($_SESSION['token'])) {
            $token = $_SESSION['token'];
            $userDao = new UserDaoMySql($this->pdo);
            $user = $userDao->findByToken($token);
            if ($user) {
                return $user;

            }

            header('Location: ' . $this->base . '/login.php');
            exit();

        }

        header('Location: ' . $this->base . '/login.php');
        exit();
    }

    public function emailExists($email)
    {
        $userDao = new UserDaoMySql($this->pdo);

    }

    public function validateLogin($email, $password): bool
    {
        $userDao = new UserDaoMySql($this->pdo);
        $user = $userDao->findByEmail($email);
        if ($user) {
            if ($user->getEstado() === 1) {
                if (password_verify($password, $user->getPassword())) {
                    $token = md5(time() . rand(0, 9999));

                    $_SESSION['token'] = $token;
                    $user->setToken($token);

                    $userDao->update($user);

                    header('Location: ' . $this->base);
                    exit();
                }


            }


        }

        return false;
    }
}