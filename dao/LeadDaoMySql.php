<?php
require 'models/Lead.php';

class LeadDaoMySql implements leadDao
{
    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    private function generateLead ($array)
    {

        $lead = new Lead();

        $lead->setDate($array['date']) ?? '';
        $lead->setStatus($array['status']) ?? 0;
        $lead->setEmail($array['email']) ?? '';
        $lead->setName($array['name']) ?? '';
        $lead->setCourse($array['course']) ?? '';
        $lead->setIdUser($array['iduser']) ?? '';
        $lead->setCanal($array['canal']) ?? '';
        $lead->setPhone($array['phone']) ?? '';
        $lead->setComment($array['comments']) ?? '';
        $lead->setId($array['id']) ?? 0;

        return $lead;
    }

    public function findAll()
    {
        $array = [];

        $sql = $this->pdo->query('SELECT * FROM leads');

        if ($sql->rowCount() > 0)
        {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $item)
            {
                $leads = $this->generateLead($item);
                $array[] = $leads;
            }

        }
        return $array;
    }

    public function insert(Lead $lead)
    {
        $sql = $this->pdo->prepare("INSERT INTO leads (
        name, course, iduser, email, canal, comments, date,phone, status       
) VALUES (
        :name, :course, :iduser, :email, :canal, :comments, :date, :phone, :status
)");
        $sql->bindValue(':name', $lead->getName());
        $sql->bindValue(':course', $lead->getCourse());
        $sql->bindValue(':iduser', $lead->getIdUser());
        $sql->bindValue(':email', $lead->getEmail());
        $sql->bindValue(':canal', $lead->getCanal());
        $sql->bindValue(':comments', $lead->getComment());
        $sql->bindValue(':date', $lead->getDate());
        $sql->bindValue(':phone', $lead->getPhone());
        $sql->bindValue(':status', $lead->getStatus());

        $sql->execute();

        $lead->setId($this->pdo->lastInsertId());

        return true;
    }

    public function estadoVenta($idEstado){
        $estadoVenta = '';
        if ($idEstado === 1)
        {
            $estadoVenta = '<span>Sin Estado</span>';
        }
        if ($idEstado === 2)
        {
            $estadoVenta = '<span>Pendiente</span>';
        }
        if ($idEstado === 3)
        {
            $estadoVenta = '<span>No Contesta</span>';
        }
        if ($idEstado === 4)
        {
            $estadoVenta = '<span>Confirmara</span>';
        }
        if ($idEstado === 5)
        {
            $estadoVenta = '<span>No Interesado/a</span>';

        }
        if ($idEstado === 6)
        {
            $estadoVenta = '<span>Pagará</span>';
        }
        if ($idEstado === 7)
        {
            $estadoVenta = '<span>Competencia</span>';
        }
        if ($idEstado === 8)
        {
            $estadoVenta = '<span>Pagado</span>';
        }
        if ($idEstado === 9)
        {
            $estadoVenta = '<span>Volver á Llamar</span>';
        }
        if ($idEstado === 10)
        {
            $estadoVenta = '<span>Más Adelante / Economia</span>';
        }
        if ($idEstado === 11)
        {
            $estadoVenta = '<span>Otra Institucion</span>';
        }
        if ($idEstado === 12)
        {
            $estadoVenta = '<span>Apagado/Ocupado</span>';
        }
        if ($idEstado === 13)
        {
            $estadoVenta = '<span>Suspendida</span>';
        }
        if ($idEstado === 14)
        {
            $estadoVenta = '<span>Contacto con Tercero</span>';
        }
        if ($idEstado === 15)
        {
            $estadoVenta = '<span>Sin Contacto</span>';
        }
        if ($idEstado === 16)
        {
            $estadoVenta = '<span>Numero equivocado/ No aplica</span>';
        }
        if ($idEstado === 17)
        {
            $estadoVenta = '<span>WhatsApp / Correo</span>';
        }
        if ($idEstado === 18)
        {
            $estadoVenta = '<span>Desiste</span>';
        }

        return $estadoVenta;

    }

    public function delete($id)
    {
        $sql = $this->pdo->prepare('DELETE FROM leads WHERE id = :id');
        $sql->bindValue(':id', $id);
        $sql->execute();

        return true;
    }

    public function update(Lead $lead)
    {
        $sql = $this->pdo->prepare('UPDATE leads SET
        name = :name,
        email = :email,
        course = :course,
        canal = :canal,
        phone = :phone,
        comments = :comments WHERE id = :id
                 ');
        $sql->bindValue(':name', $lead->getName());
        $sql->bindValue(':email', $lead->getEmail());
        $sql->bindValue(':course', $lead->getCourse());
        $sql->bindValue(':canal', $lead->getCanal());
        $sql->bindValue(':phone', $lead->getPhone());
        $sql->bindValue(':comments', $lead->getComment());
        $sql->bindValue(':id', $lead->getId());

        $sql->execute();

        return true;

    }

    public function editAsesor(Lead $lead)
    {
        $sql = $this->pdo->prepare('UPDATE leads SET iduser = :iduser WHERE id = :id');
        $sql->bindValue(':iduser', $lead->getIdUser());
        $sql->bindValue(':id', $lead->getId());

        $sql->execute();

        return true;
    }

    public function findByDates($startDate, $endDate)
    {
        $array = [];

        $sql = $this->pdo->prepare('SELECT * FROM leads WHERE date BETWEEN :startdate AND :enddate');
        $sql->bindValue(':startdate', $startDate);
        $sql->bindValue(':enddate', $endDate);
        $sql->execute();

        if ($sql->rowCount() > 0)
        {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $item)
            {
                $leads = $this->generateLead($item);
                $array[] = $leads;
            }

        }
        return $array;
    }

    public function findByDatesAsesor($startDate, $endDate, $asesor)
    {
        $array = [];

        $sql = $this->pdo->prepare('SELECT * FROM leads WHERE iduser = :iduser AND date BETWEEN :startdate AND :enddate');
        $sql->bindValue(':startdate', $startDate);
        $sql->bindValue(':enddate', $endDate);
        $sql->bindValue(':iduser', $asesor);
        $sql->execute();

        if ($sql->rowCount() > 0)
        {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $item)
            {
                $leads = $this->generateLead($item);
                $array[] = $leads;
            }

        }
        return $array;
    }

    public function findByAsesor($asesor)
    {
        $array = [];

        $sql = $this->pdo->prepare('SELECT * FROM leads WHERE iduser = :iduser');
        $sql->bindValue(':iduser', $asesor);
        $sql->execute();

        if ($sql->rowCount() > 0)
        {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $item)
            {
                $leads = $this->generateLead($item);
                $array[] = $leads;
            }

        }
        return $array;
    }


}
