<?php

class Lead
{

    private string $name;
    private int $id;
    private string $course;
    private int $idUser;
    private string $phone;
    private string $email;
    private string $canal;
    private string $comment;
    private  $status;
    private string $date;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCourse(): string
    {
        return $this->course;
    }

    public function setCourse(string $course): void
    {
        $this->course = $course;
    }

    public function getIdUser(): int
    {
        return $this->idUser;
    }

    public function setIdUser($idUser): void
    {
        $this->idUser = $idUser;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getCanal(): string
    {
        return $this->canal;
    }

    public function setCanal(string $canal): void
    {
        $this->canal = $canal;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }




}

interface leadDao{
    public function findAll();
    public function insert(Lead $lead);
}