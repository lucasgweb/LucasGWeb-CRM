<?php
require_once 'models/User.php';

class UserDaoMySql implements UserDao
{
    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    private function generateUser($array)
    {
        $user = new User();
        $user->setId($array['id']) ?? 0;
        $user->setName($array['name']) ?? '';
        $user->setEmail($array['email']) ?? '';
        $user->setPassword($array['password']) ?? '';
        $user->setLevel($array['level']) ?? 0;
        $user->setAvatar($array['avatar']) ?? '';
        $user->setToken($array['token']) ?? '';
        $user->setEstado($array['estado']) ?? 0;

        return $user;
    }

    public function findByToken($token)
    {
        $sql = $this->pdo->prepare('SELECT * FROM users WHERE token = :token');
        $sql->bindValue(':token', $token);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            $user = $this->generateUser($data);

            if ($user) {
                return $user;
            }
        }
        return false;
    }

    public function findByEmail($email)
    {
        if (!empty($email)) {
            $sql = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
            $sql->bindValue(':email', $email);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user = $this->generateUser($data);

                if ($user) {
                    return $user;
                }
            }
        }
        return false;
    }

    public function update(User $user)
    {
        $sql = $this->pdo->prepare('UPDATE users SET 
                 name = :name,
                 email = :email,
                 password = :password,
                 level = :level,
                 token = :token,
                 avatar = :avatar,
                 estado = :estado
WHERE id = :id');

        $sql->bindValue(':name', $user->getName());
        $sql->bindValue(':email', $user->getEmail());
        $sql->bindValue(':password', $user->getPassword());
        $sql->bindValue(':level', $user->getLevel());
        $sql->bindValue(':token', $user->getToken());
        $sql->bindValue(':avatar', $user->getAvatar());
        $sql->bindValue(':estado', $user->getEstado());
        $sql->bindValue(':id', $user->getId());

        $sql->execute();


        return $user ;

    }

    public function findAll()
    {
        $array = [];

        $sql = $this->pdo->query('SELECT * FROM users');

        if ($sql->rowCount() > 0)
        {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $item)
            {
                $users = $this->generateUser($item);
                $array[] = $users;
            }

            return $array;

        }

        return false;
    }

    public function insert(User $user)
    {
        $sql = $this->pdo->prepare('INSERT INTO users (
                   name, email, password, level
) VALUES (
          :name, :email, :password, :level
)');

        $sql->bindValue(':name', $user->getName());
        $sql->bindValue(':email', $user->getEmail());
        $sql->bindValue(':password', $user->getPassword());
        $sql->bindValue(':level', $user->getLevel());

        $sql->execute();

        $user->setId($this->pdo->lastInsertId());

        return $user;
    }

    public function findById($id)
    {
            $sql = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
            $sql->bindValue(':id', $id);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user = $this->generateUser($data);

                if ($user) {
                    return $user;
                }
            }

        return false;
    }

    public function delete($id)
    {
        $sql = $this->pdo->prepare('DELETE FROM users WHERE id = :id');
        $sql->bindValue(':id', $id);
        $sql->execute();

        return true;
    }


}