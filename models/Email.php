<?php

require_once 'Database.php';

class Email {

    private $email;
    private $contacts_fk;

    public function __construct($contactData) {
        
        $this->email = $contactData['email'];
        $this->contacts_fk = $contactData['contacts_fk'];

    }

    public function create() {

        $db = Database::getConnection();

        $query = 'INSERT INTO contacts_emails (email, contacts_fk) VALUES (?, ?)';

        $statement = $db->prepare($query);

        $statement->bindValue(1, $this->email);
        $statement->bindValue(2, $this->contacts_fk);

        $statement->execute();

        return ['id' => $db->lastInsertId()];

    }

}