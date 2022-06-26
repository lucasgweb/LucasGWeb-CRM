<?php

class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $avatar;
    private int $level;
    private string $token;
    private int $estado;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel ($level)
    {
        $this->level = $level;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getEstado(): int
    {
        return $this->estado;
    }

    public function setEstado(int $estado): void
    {
        $this->estado = $estado;
    }


}

interface UserDao
{
    public function findByToken($token);
    public function findByEmail($email);
    public function findAll();
    public function insert(User $user);
    public function findById($id);
    public function delete($id);
}