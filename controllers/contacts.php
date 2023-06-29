<?php

require_once 'models/Contact.php';

class ContactsController {

    public static function create($contactData) {

        $contactData = self::processData($contactData);

        $contact = new Contact($contactData);

        return $contact->create();

    }

    public static function getAll() {

        return Contact::getAll();

    }

    private static function processData($contactData) {

        $contactFields = ['fullName', 'birthdate', 'landline', 'phoneNumber', 'hasWhatsapp', 'notifyEmail', 'notifySms'];
        $processedData = [];

        foreach ($contactFields as $field) {

            if (isset($contactData[$field]) && !empty($contactData[$field])) {

                $value = $contactData[$field];
                $value = trim($value);
                $value = stripslashes($value);
                $value = htmlspecialchars($value);

            } else {

                $value = null;

            }

            $processedData[$field] = $value;

        }

        $processedData['hasWhatsapp'] = (int)filter_var($processedData['hasWhatsapp'], FILTER_VALIDATE_BOOLEAN);
        $processedData['notifyEmail'] = (int)filter_var($processedData['notifyEmail'], FILTER_VALIDATE_BOOLEAN);
        $processedData['notifySms'] = (int)filter_var($processedData['notifySms'], FILTER_VALIDATE_BOOLEAN);

        return $processedData;

    }

}