<?php

require_once 'Database.php';

class Contact {

    private $full_name;
    private $birthdate;
    private $landline_number;
    private $phone_number;
    private $phone_number_has_whatsapp;
    private $send_email_notifications;
    private $send_sms_notifications;

    public function __construct($contactData) {
        
        $this->full_name = $contactData['full_name'];
        $this->birthdate = $contactData['birthdate'];
        $this->landline_number = $contactData['landline_number'];
        $this->phone_number = $contactData['phone_number'];
        $this->phone_number_has_whatsapp = $contactData['phone_number_has_whatsapp'];
        $this->send_email_notifications = $contactData['send_email_notifications'];
        $this->send_sms_notifications = $contactData['send_sms_notifications'];

    }

    public function create() {

        $db = Database::getConnection();

        $query = '
            INSERT INTO contacts (
                full_name, birthdate, landline_number, phone_number, phone_number_has_whatsapp, send_email_notifications, send_sms_notifications
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?
            )
        ';

        $statement = $db->prepare($query);

        $statement->bindValue(1, $this->full_name);
        $statement->bindValue(2, $this->birthdate);
        $statement->bindValue(3, $this->landline_number);
        $statement->bindValue(4, $this->phone_number);
        $statement->bindValue(5, $this->phone_number_has_whatsapp);
        $statement->bindValue(6, $this->send_email_notifications);
        $statement->bindValue(7, $this->send_sms_notifications);
        $statement->execute();

        return ['id' => $db->lastInsertId()];

    }

    public static function getAll() {

        $db = Database::getConnection();

        $query = '
            SELECT 
                cont.full_name, cont.birthdate, cont.landline_number, cont.phone_number, emails.email
            FROM contacts cont
            INNER JOIN contacts_emails emails ON cont.id = emails.contacts_fk
            GROUP BY cont.id
            ORDER BY cont.id DESC
        ';

        $statement = $db->prepare($query);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

}