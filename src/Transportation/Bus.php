<?php
namespace App\Transportation;

class Bus extends Transportations {

    private static $message = "Take the airport bus from %s to %s. No seat assignment.";

    public static function GuidePassenger(array $card)
    {
        self::setupMessage($card);
        self::printMessage();
        echo "\n";
    }

    public static function setupMessage($card = [])
    {
        self::$to              = isset($card['departure'])  ? $card['departure']  : '';
        self::$from            = isset($card['arrival'])    ? $card['arrival']    : '';
    }

    public static function printMessage()
    {
        echo sprintf(self::$message, self::$from, self::$to);
    }
}