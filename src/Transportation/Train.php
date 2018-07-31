<?php
namespace App\Transportation;

class Train extends Transportations {

    private static $message = "Take train %s from %s to %s. Sit in seat %s.";

    public static function GuidePassenger(array $card)
    {
        self::setupMessage($card);
        self::printMessage();
        echo "\n";
    }

    public static function setupMessage($card = [])
    {
        self::$to              = isset($card['departure'])              ? $card['departure']         : '';
        self::$from            = isset($card['arrival'])                ? $card['arrival']           : '';
        self::$seatNumber      = isset($card['seat'])                   ? $card['seat']              : '';
        self::$transportationNumber = isset($card['transportation_no']) ? $card['transportation_no'] : '';
    }

    public static function printMessage()
    {
        echo sprintf(self::$message, self::$transportationNumber, self::$from, self::$to, self::$seatNumber);
    }
}