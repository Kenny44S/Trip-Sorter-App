<?php
namespace App\Transportation;

abstract class Transportations{

    protected static $from;
    protected static $to;

    protected static $transportationNumber;
    protected static $seatNumber;

    const DESTINATION_ARRIVED_MESSAGE = "GREAT!! You have arrived at your destination.\n";

    public static function GuidePassenger(array $card)
    {

    }
}