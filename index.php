<?php
namespace App;

require_once __DIR__ . '/vendor/autoload.php';

use App\Sorter\SimpleTripSorter;

$cards = __DIR__.'/src/BoardingCards/boarding_cards.json';

$boardingCards = json_decode(file_get_contents($cards), true);

$tripSorter = new SimpleTripSorter($boardingCards);

$tripSorter->sort()->GuidePassenger();
