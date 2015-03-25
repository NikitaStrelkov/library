<?php
class Book {
    private $id;
    /**
     * @var
     */
    private $title;
    /**
     * @var
     */
    private $author;
    /**
     * @var
     */
    private $numberOfPages;

    /**
     * @param array $options
     * @param bool $fromDB
     */
    public function __construct ( array $options = array(), $fromDB = false ) {
        if (!empty($options['id'])) {
            $this->id = (int) $options['id'];
            if ($fromDB) {
                $sql = "SELECT * FROM books WHERE id='$this->id'";
                $conn = DBconn::connect();
                $owner = $conn->query($sql);
                $this->title = $owner['title'];
                $this->author = $owner['author'];
                $this->numberOfPages = $owner['numberOfPages'];
            }
        }
        if (!$fromDB) {
            if (!empty($options['title'])) {
                $this->title = (string) $options['title'];
            }
            if (!empty($options['author'])) {
                $this->author = (string) $options['author'];
            }
            if (!empty($options['numberOfPages'])) {
                $this->numberOfPages = intval($options['numberOfPages']);
            }
        }
    }

    /**
     * @param bool $freeOnly
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function getList ($freeOnly = false) {
        $sql = "SELECT b.id, b.title, b.author, b.numberOfPages FROM books b ";
        if ($freeOnly === true) {
            $sql .= " WHERE b.owner IS NULL OR b.owner='0'";
        }
        $sql .= " ORDER BY id DESC";
        $conn = DBconn::connect();
        $books = $conn->query($sql);
        return $books;
    }

    /**
     * @param $ownerID
     * @return int
     */
    public function assignBookToOwner ($ownerID) {
        $conn = DBconn::connect();
        return $conn->update(
            'books',
            array(
                'owner' => $ownerID,
            ),
            array(
                'id' => $this->id
            )
        );
    }

    /**
     *
     */
    public function saveToDB () {
        $conn = DBconn::connect();
        if($this->id) {
            $conn->update(
                'books',
                array(
                    'title' => $this->title,
                    'author' => $this->author,
                    'numberOfPages' => $this->numberOfPages
                ),
                array(
                    'id' => $this->id
                )
            );
        } else {
            $conn->insert(
                'books',
                array(
                    'title' => $this->title,
                    'author' => $this->author,
                    'numberOfPages' => $this->numberOfPages
                )
            );
        }
    }

    /**
     * @param $id
     */
    public static function delete ($id) {
        $id = intval($id);
        $conn = DBconn::connect();
        $conn->delete('books', array('id' => $id));
    }

    /**
     * @return mixed
     */
    public function getNumberOfPages() {
        return $this->numberOfPages;
    }

    /**
     * @param mixed $numberOfPages
     */
    public function setNumberOfPages($numberOfPages) {
        $this->numberOfPages = $numberOfPages;
    }

    /**
     * @return mixed
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author) {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }
}