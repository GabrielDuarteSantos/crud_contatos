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

        $contactFields = [
            'full_name', 
            'birthdate', 
            'landline_number', 
            'phone_number', 
            'phone_number_has_whatsapp', 
            'send_email_notifications', 
            'send_sms_notifications'
        ];

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

        $contactFields = [
            'phone_number_has_whatsapp', 
            'send_email_notifications', 
            'send_sms_notifications'
        ];

        foreach ($contactFields as $field) {

            $processedData[$field] = (int)filter_var($processedData[$field], FILTER_VALIDATE_BOOLEAN);

        }

        return $processedData;

    }

}