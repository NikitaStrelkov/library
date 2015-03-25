<?php

class Owner {
    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $lastName;
    /**
     * @var
     */
    private $job;

    /**
     * @param array $options
     * @param bool $fromDB
     */
    public function __construct (array $options = array(), $fromDB = false) {
        if (!empty($options['id'])) {
            $this->id = (int) $options['id'];
            if ($fromDB) {
                $sql = "SELECT * FROM owners WHERE id = ?";
                $conn = DBconn::connect();
                $owner = $conn->fetchAll($sql, array((int) $options['id']));
                $this->name = $owner['name'];
                $this->lastName = $owner['lastName'];
                $this->job = $owner['job'];
            }
        }
        if (!$fromDB) {
            if (!empty($options['name'])) {
                $this->name = (string) $options['name'];
            }
            if (!empty($options['lastName'])) {
                $this->lastName = (string) $options['lastName'];
            }
            if (!empty($options['job'])) {
                $this->job = (string) $options['job'];
            }
        }
    }

    /**
     * @param bool $withBooks
     * @return array
     * @internal param array $options
     */
    public static function getList ($withBooks = false) {
        $conn = DBconn::connect();
        if($withBooks === true) {
            $sql = "SELECT o.id, o.name, o.lastName, o.job, b.title, b.author, b.numberOfPages FROM owners o JOIN books b ON b.owner=o.id";
            $dbResult = $conn->query($sql);
            $owners = array();
            foreach($dbResult as $oneResult) {
                $owners[$oneResult['id']]['id'] = $oneResult['id'];
                $owners[$oneResult['id']]['name'] = $oneResult['name'];
                $owners[$oneResult['id']]['lastName'] = $oneResult['lastName'];
                $owners[$oneResult['id']]['job'] = $oneResult['job'];
                if (!isset($owners[$oneResult['id']]['books'])) {
                    $owners[$oneResult['id']]['books'] = array();
                }
                $owners[$oneResult['id']]['books'][] = array(
                    "title" => $oneResult['title'],
                    "author" => $oneResult['author'],
                    "numberOfPages" => $oneResult['numberOfPages'],
                );
            }
        } else {
            $sql = "SELECT o.id, o.name, o.lastName, o.job FROM owners o ORDER BY id DESC";
            $owners = $conn->query($sql);
        }
        return $owners;
    }

    /**
     *
     */
    public function saveToDB () {
        $conn = DBconn::connect();
        if($this->id) {
            $conn->update(
                'owners',
                array(
                    'name' => $this->name,
                    'lastName' => $this->lastName,
                    'job' => $this->job
                ),
                array(
                    'id' => $this->id
                )
            );
        } else {
            $conn->insert(
                'owners',
                array(
                    'name' => $this->name,
                    'lastName' => $this->lastName,
                    'job' => $this->job
                )
            );
        }
    }

    /**
     * @param $id
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public static function delete ($id) {
        $id = intval($id);
        $conn = DBconn::connect();
        $conn->update(
            'books',
            array(
                'owner' => null,
            ),
            array(
                'owner' => $id
            )
        );
        $conn->delete('owners', array('id' => $id));
    }
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param mixed $job
     */
    public function setJob($job)
    {
        $this->job = $job;
    }
}