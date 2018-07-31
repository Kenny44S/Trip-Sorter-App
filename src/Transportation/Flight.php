<?php
namespace App\Transportation;


class Flight extends Transportations {

    private static $defaultBaggageMessage = "Baggage will we automatically transferred from your last leg. ";
    private static $baggageMessage = "Baggage drop at ticket counter %s. ";

    private static $baggagePickupCounter;
    private static $gate;

    private static $message = "From %s, take flight %s to %s. Gate: %s, Seat: %s. ";


    public static function GuidePassenger(array $card)
    {
        self::setupMessage($card);
        self::printMessage();
        echo "\n";
    }


    public static function setupMessage($card = [])
    {
        self::$to                   = isset($card['departure'])         ? $card['departure']  : '';
        self::$from                 = isset($card['arrival'])           ? $card['arrival']    : '';
        self::$gate                 = isset($card['gate'])              ? $card['gate']       : '';
        self::$seatNumber           = isset($card['seat'])              ? $card['seat']       : '';
        self::$baggagePickupCounter = isset($card['baggage'])           ? $card['baggage']    : '';
        self::$transportationNumber = isset($card['transportation_no']) ? $card['transportation_no'] : '';
    }

    public static function printMessage()
    {
        echo sprintf(self::$message, self::$from, self::$transportationNumber, self::$to, self::$gate, self::$seatNumber);

        if(empty(self::$baggagePickupCounter))
            echo self::$defaultBaggageMessage;
        else
           echo sprintf(self::$baggageMessage, self::$baggagePickupCounter);
    }
}