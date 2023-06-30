<?php

require_once 'models/Email.php';

class EmailsController {

    public static function createMultiple($emails, $contactId) {

        $dbEmails = [];

        foreach ($emails as $email) {

            $dbEmails[] = self::create($email, $contactId);

        }

        return $dbEmails;

    }

    public static function create($email, $contactId) {

        $emailData = self::processData($email, $contactId);

        $email = new Email($emailData);

        return $email->create();

    }

    private static function processData($email, $contactId) {

        $email = trim($email);
        $email = stripslashes($email);
        $email = htmlspecialchars($email);

        $processedData = [
            'email' => $email,
            'contacts_fk' => $contactId,
        ];

        return $processedData;

    }

}