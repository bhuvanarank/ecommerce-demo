<?php
$vehicle_types = ['sport-car', 'truck', 'bike', 'boat'];

// assign vehicles speed in km/h
$vehicles_speed_one = [150, 60, 100, 50]; 
// assign destination distance in km
$distance_one = 350; 

// assign another vehicles speed in km/h
$vehicles_speed_two = [200, 100, 140, 80]; 
// assign another destination distance in km
$distance_two = 400; 

//call the same function using different values
duration_calculation($vehicle_types, $vehicles_speed_one, $distance_one);
duration_calculation($vehicle_types, $vehicles_speed_two, $distance_two);

function duration_calculation($vehicle_types, $vehicles_speed, $distance)
{
    
    print ('<b>'. "Duration of each vehicle to reach destination\n". '</b><br>');
    for ($i = 0;$i < count($vehicle_typ
        es);$i++)
    {
        // The boat needs extra 15 min to get ready, so we add + 0.25H
        if ($vehicle_types[$i] == 'boat')
        {
            print ($vehicle_types[$i] . ": " . number_format((($distance / $vehicles_speed[$i]) + 0.25),2). '<br>');
        }
        else
        {
            print ($vehicle_types[$i] . ": " . number_format($distance / $vehicles_speed[$i],2) . '<br>');
        }
    }
}
?>
