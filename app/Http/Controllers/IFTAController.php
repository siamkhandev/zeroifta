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
        $fuelNeeded = $this->gallonsOfFuel($route['miles'], $route['truckMPG']) + $reserveGallons + $desiredAdditionalEndingGallons;

        if ($fuelNeeded <= $currentGallons) {
            return [[], $currentGallons - $fuelNeeded];
        } else {
            $fuelStop = $this->findCheapestFuelStop($route);
            $routeSegmentA = $this->createRouteSegment($route['start'], $fuelStop);
            list($stopsData, $gallonsRemaining) = $this->stopsAlgorithm($routeSegmentA, $currentGallons, $reserveGallons, 0);

            $routeSegmentB = $this->createRouteSegment($fuelStop, $route['destination']);
            $gallonsToBuy = min(
                $this->amountOfFuelNeeded($routeSegmentB['miles'], $route['truckMPG']) + $reserveGallons + $desiredAdditionalEndingGallons,
                $route['truckTankCapacity']
            ) - $gallonsRemaining;

            $stopsData[] = ['fuelStop' => $fuelStop, 'gallonsToBuy' => $gallonsToBuy];

            list($segBstopsData, $gallonsRemaining) = $this->stopsAlgorithm($routeSegmentB, $gallonsToBuy + $gallonsRemaining, $reserveGallons, $desiredAdditionalEndingGallons);

            return [array_merge($stopsData, $segBstopsData), $gallonsRemaining];
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
            'pricePerGallon' => 3.50
        ];
    }

    private function createRouteSegment($start, $end)
    {
        // Implement logic to create a route segment from start to end
        // This is a placeholder for demonstration purposes.
        return [
            'start' => $start,
            'end' => $end,
            'miles' => rand(50, 200), // Example miles
            'truckMPG' => 8, // Example MPG
            'truckTankCapacity' => 150 // Example tank capacity
        ];
    }
}
