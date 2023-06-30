<?php

require_once 'Database.php';

class ContactsOccupations {

    public static function create($contactId, $occupationId) {

        $db = Database::getConnection();
        $statement = $db->prepare('INSERT INTO contacts_occupations (contacts_fk, occupations_fk) VALUES (?, ?)');

        $statement->bindValue(1, $contactId);
        $statement->bindValue(2, $occupationId);
        $statement->execute();

        return ['id' => $db->lastInsertId()];

    }

}