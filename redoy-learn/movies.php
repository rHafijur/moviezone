<?php
    // $movies=array();
    // $movies[]=[
    //     'title'=>'Avengers, Infinity war',
    //     'year'=>'2018'
    // ];
    // $movies[]=[
    //     'title'=>'Avengers, EndGame',
    //     'year'=>'2019'
    // ];
    // $movies[]=[
    //     'title'=>'Avengers, Age of altron',
    //     'year'=>'2016'
    // ];
    // $movies[]=[
    //     'title'=>'Captain america first avenger',
    //     'year'=>'2012'
    // ];
    $movies=[
        [
            'title'=>'Avengers, Infinity war',
            'year'=>'2018',
            'star'=>'Chris Helmsworth'
        ],
        [
            'title'=>'Avengers, EndGame',
            'year'=>'2019'
        ],
        [
            'title'=>'Avengers, Age of altron',
            'year'=>'2016'
        ],
        [
            'title'=>'Captain america first avenger',
            'year'=>'2012'
        ]

        ];
    foreach($movies as $movie){
        foreach($movie as $key => $value){
            echo $key.": ".$value." ";
        }
        echo "<br>";
    }
?>