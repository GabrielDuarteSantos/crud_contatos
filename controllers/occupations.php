<?php

require_once 'models/Occupation.php';

class OccupationsController {

    public static function ensureMultiple($occupationNames) {

        $dbOccupations = [];

        foreach ($occupationNames as $occupationName) {

            $dbOccupations[] = self::ensure($occupationName);

        }

        return $dbOccupations;

    }

    public static function ensure($occupationName) {

        $occupationData = self::processData($occupationName);

        $dbOccupation = Occupation::getByName($occupationData['name']);

        if (empty($dbOccupation)) {

            $occupation = new Occupation($occupationData);

            $dbOccupation = $occupation->create();

        }

        return $dbOccupation;

    }

    private static function processData($occupationName) {

        $occupationName = trim($occupationName);
        $occupationName = stripslashes($occupationName);
        $occupationName = htmlspecialchars($occupationName);

        $processedData = [
            'name' => $occupationName,
        ];

        return $processedData;

    }

}