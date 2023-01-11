<?php

declare(strict_types=1);

if ($argc == 1) :
    print_r("You should pass a .json file as a parameter. (For example: 'php 02.php logbook.json').");
    die();
elseif ($argc == 2 && $argv[1]) :
    $str = $argv[1];
    $pattern = "/[0-9,a-z]+.json/";
    $match = preg_match($pattern, $str);

    if ($match == 1) :
        if (file_exists($str)) : 
            $visits = file_get_contents($str);
            $visits = json_decode($visits, true);
            
            foreach ($visits["vacation"] as $visit) :
                $island = $visit["island"];
                $arrDate = $visit["arrival_date"];
                $hotel = $visit["hotel"];
                $stars = $visit["stars"];
                printf("You arrived on %s on %s at the %s, which had %d stars.\n", $island, $arrDate, $hotel, $stars);
            endforeach; 

               /*  $counter = 0;
                foreach ($visit["features"] as $feature) :
                    $counter++;
                endforeach;
                $numFeatures = $counter;

                $test = [];
                foreach ($stars as $star) :
                    $test[] = $star;
                endforeach;

                print_r($test); */
        else :
            echo "File does not exist.\n";
            var_dump($str);
        endif;
    endif;
endif;

