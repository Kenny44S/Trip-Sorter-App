<?php
namespace App\Sorter;


use App\Transportation\Transportations;

class SimpleTripSorter implements TripSorterInterface {

    private $transportation = [
                               "Train"  => "App\Transportation\Train",
                               "Bus"    => "App\Transportation\Bus",
                               "Flight" => "App\Transportation\Flight"
                              ];

    private $boardingCards;
    private $sortedBoardingCards;

    private $totalCardsCount;


    private $departures = [];
    private $arrivals   = [];

    private $lastCard;

    public function __construct($boardingCards)
    {
        $this->boardingCards = $boardingCards;
        $this->totalCardsCount = count($boardingCards);
    }


    public function sort()
    {
        $this->SegregateDeparturesAndArrivals();

        $this->GetFirstAndLastCard();

        $this->ConnectRemainingCards();

        $this->ValidateCards();

        $this->ShowQuickGuide();

        return $this;
    }


    // We create 2 different arrays, ie: 1st consisting all the ARRIVALS, 2nd consisting all the DEPARTURES.
    // GOTO to GetFirstAndLastCard();
    public function SegregateDeparturesAndArrivals()
    {
        if($this->boardingCards < 2)
            return;

        for($i = 0; $i < count($this->boardingCards); $i++)
        {
            $this->departures[] = strtolower($this->boardingCards[$i]['departure']);
            $this->arrivals[]   = strtolower($this->boardingCards[$i]['arrival']);
        }
    }


    // After segregating Arrivals and Departures, we search for every Arrivals in Departures array.
    // If the arrival is found in departure array, we remove both.
    // In the end we are left with 1 Arrival & 1 Departure each.
    // These are our Starting point & Ending point.
    // **Explanation**: When the arrival is not found in departure it means that the arrival is the starting point.
    // & vice versa.
    public function GetFirstAndLastCard()
    {
        for($i = 0; $i < $this->totalCardsCount; $i++)
        {
            if (($key = array_search($this->departures[$i], $this->arrivals)) !== false)
            {
                unset($this->departures[$i]);
                unset($this->arrivals[$key]);
            }
        }

        // We add our first card in our NEW SortedBoardingCards array.
        // Also we save our last card in a seperate variable.
        $this->sortedBoardingCards[] = $this->boardingCards[array_keys($this->arrivals)[0]];
        $this->lastCard  = $this->boardingCards[array_keys($this->departures)[0]];

        // We unset the first & last card from our boarding cards array as it is not needed anymore.
        unset($this->boardingCards[array_keys($this->arrivals)[0]]);
        unset($this->boardingCards[array_keys($this->departures)[0]]);

        // Merge arrays so that the array keys are reset.
        $this->boardingCards = array_merge($this->boardingCards);
    }


    // We connect the remaining n-2 boarding cards, where n = number of boarding cards.
    public function ConnectRemainingCards()
    {
        $count = count($this->boardingCards);

        // To connect our NEXT boarding card, we need the current boarding card's departure.
        // Initially we take the first boarding card's departure as we already have it.
        $NextArrival = $this->sortedBoardingCards[0]['departure'];

        for($i = 0; $i < $count; $i++)
        {
            for($z = 0; $z < $count; $z++)
            {
                //Ignore the same card.
                if($z == $i)
                    continue;

                // If we find current departure name in any boarding card's arrival
                // we start adding it to our SortedBoardingCards list
                // and also update our NextArrival.
                if($NextArrival == $this->boardingCards[$z]['arrival'])
                {
                    $NextArrival = $this->boardingCards[$z]['departure'];
                    $this->sortedBoardingCards[] = $this->boardingCards[$z];
                }
            }
        }
        // In the end we add the lastCard to the end of SortedBoardingCards list
        $this->sortedBoardingCards[] = $this->lastCard;
    }


    // Function which calls each Transportation Type Class's GuidePassenger method..
    public function GuidePassenger()
    {
        foreach ($this->sortedBoardingCards as $key => $card)
        {
            $this->transportation[$card['transportation']]::GuidePassenger($card);
        }
        echo Transportations::DESTINATION_ARRIVED_MESSAGE;
    }

    public function ShowQuickGuide()
    {
        echo sprintf("Your starting point is: %s & Destination is: %s",
                                                              $this->sortedBoardingCards[0]['departure'],
                                                              $this->lastCard['departure']);
        echo "\n----------------------------------------------------------------------------------------------------\n";
    }

    public function ValidateCards()
    {
        if($this->totalCardsCount != count($this->sortedBoardingCards))
        {
            echo ("Boarding Cards are NOT VALID. Please check and try again..\n");
            exit;
        }
    }
}