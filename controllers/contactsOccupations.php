<?php

require_once 'models/ContactsOccupations.php';

class ContactsOccupationsController {

    public static function createMultiple($contacts, $occupations) {

        $dbLinks = [];

        foreach ($contacts as $contact) {

            foreach ($occupations as $occupation) {

                $dbLinks[] = self::create($contact, $occupation);

            }

        }

    }

    public static function create($contact, $occupation) {

        ContactsOccupations::create($contact['id'], $occupation['id']);

    }

}