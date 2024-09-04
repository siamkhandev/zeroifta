<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IFTAController extends Controller
{
    public function findCheapestFuelStops(Request $request)
    {
        $route = $request->route; // Assuming route data is passed in the request
        $currentGallons = $request->currentGallons;
        $reserveGallons = 45; // Example reserve
        $desiredAdditionalEndingGallons = 0; // Example desired ending gallons

        list($routeWithStops, $remainingGallons) = $this->stopsAlgorithm($route, $currentGallons, $reserveGallons, $desiredAdditionalEndingGallons);

        return response()->json([
            'routeWithStops' => $routeWithStops,
            'remainingGallons' => $remainingGallons
        ]);
    }

    private function stopsAlgorithm($route, $currentGallons, $reserveGallons, $desiredAdditionalEndingGallons)
{
   

    // Calculate the total fuel needed for the route
    $fuelNeeded = $this->gallonsOfFuel($route['miles'], $route['truckMPG']) + $reserveGallons + $desiredAdditionalEndingGallons;

    // If the current fuel is sufficient, no stop is needed
    if ($fuelNeeded <= $currentGallons) {
        return [[], $currentGallons - $fuelNeeded];
    } else {
        // If a fuel stop is necessary
        $fuelStop = $this->findCheapestFuelStop($route);
        $routeSegmentA = $this->createRouteSegment($route['start'], $fuelStop['location'], $route);

        // Calculate for the first segment
        $gallonsUsedSegmentA = $this->gallonsOfFuel($routeSegmentA['miles'], $routeSegmentA['truckMPG']);
        $remainingGallonsAfterSegmentA = $currentGallons - $gallonsUsedSegmentA;

        // Calculate the amount of fuel to buy
        $gallonsToBuy = min(
            $this->amountOfFuelNeeded($routeSegmentA['miles'], $routeSegmentA['truckMPG']) + $reserveGallons + $desiredAdditionalEndingGallons,
            $route['truckTankCapacity']
        ) - $remainingGallonsAfterSegmentA;

        $stopsData = [
            ['fuelStop' => $fuelStop, 'gallonsToBuy' => $gallonsToBuy]
        ];

        // Update the route for the next segment
        $remainingMiles = $route['miles'] - $routeSegmentA['miles'];

      

        if ($remainingMiles > 0) {
            $routeSegmentB = $this->createRouteSegment($fuelStop['location'], $route['destination'], [
                'miles' => $remainingMiles,
                'truckMPG' => $route['truckMPG'],
                'truckTankCapacity' => $route['truckTankCapacity'],
                'start' => $fuelStop['location'],
                'destination' => $route['destination']
            ]);

            $remainingGallonsAfterBuying = $gallonsToBuy + $remainingGallonsAfterSegmentA;

            // Recursive call for the remaining segment
            list($segBstopsData, $gallonsRemaining) = $this->stopsAlgorithm($routeSegmentB, $remainingGallonsAfterBuying, $reserveGallons, $desiredAdditionalEndingGallons);

            return [array_merge($stopsData, $segBstopsData), $gallonsRemaining];
        } else {
            // In case there are no remaining miles, return the current data
            return [$stopsData, $gallonsToBuy + $remainingGallonsAfterSegmentA];
        }
    }
}


    private function gallonsOfFuel($miles, $MPG)
    {
        return $miles / $MPG;
    }

    private function amountOfFuelNeeded($miles, $MPG)
    {
        return $this->gallonsOfFuel($miles, $MPG);
    }

    private function findCheapestFuelStop($route)
    {
        // Implement your logic to find the cheapest fuel stop along the route.
        // This is a placeholder for demonstration purposes.
        return [
            'location' => 'Some Fuel Station',
            //'pricePerGallon' => 3.50
        ];
    }

    private function createRouteSegment($start, $end, $route)
    {
        // Check if 'segments' key exists in the route array
        if (isset($route['segments'])) {
            // Find the segment of the route that starts at $start and ends at $end
            foreach ($route['segments'] as $segment) {
                if ($segment['start'] === $start && $segment['end'] === $end) {
                    return [
                        'start' => $segment['start'],
                        'end' => $segment['end'],
                        'miles' => $segment['miles'],
                        'truckMPG' => $segment['truckMPG'],
                        'truckTankCapacity' => $route['truckTankCapacity']
                    ];
                }
            }
        }

        // Fallback if the 'segments' key doesn't exist or the segment is not found
        return [
            'start' => $start,
            'end' => $end,
            'miles' => $route['miles'], // Using full route miles if segment not found
            'truckMPG' => $route['truckMPG'], 
            'truckTankCapacity' => $route['truckTankCapacity']
        ];
    }
}
