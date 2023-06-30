<?php

require_once 'Database.php';

class ContactsOccupations {

    public static function create($contactId, $occupationId) {

        $db = Database::getConnection();

        $query = 'INSERT INTO contacts_occupations (contacts_fk, occupations_fk) VALUES (?, ?)';

        $statement = $db->prepare($query);

        $statement->bindValue(1, $contactId);
        $statement->bindValue(2, $occupationId);
        $statement->execute();

        return ['id' => $db->lastInsertId()];

    }

}