<?php

$conn_string = "host=54.169.131.81 port=5432 dbname=db_tourism user=postgres password=1234";
$dbconn = pg_connect($conn_string);


$user_login = $_SESSION['user_login'];

$sqls =  "SELECT *  FROM tourism_experience INNER JOIN tourism_impressive ON  
        (tourism_experience.create_by = tourism_impressive.create_by) JOIN tourism_knowhow  ON 
        (tourism_experience.create_by = tourism_knowhow.create_by) JOIN tourism_story  ON
        (tourism_experience.create_by = tourism_story.create_by) WHERE tourism_experience.create_by = '$user_login' ";

$resulte = pg_query($dbconn,"SELECT * FROM tourism_experience WHERE create_by = '$user_login' AND tourism_experience_latitude IS NOT NULL ");
$resulti = pg_query($dbconn,"SELECT * FROM tourism_impressive WHERE create_by = '$user_login' AND tourism_impressive_latitude IS NOT NULL  ");
$resultk = pg_query($dbconn,"SELECT * FROM tourism_knowhow WHERE create_by = '$user_login' AND tourism_knowhow_latitude IS NOT NULL ");
$results = pg_query($dbconn,"SELECT * FROM tourism_story WHERE create_by = '$user_login' AND tourism_story_latitude IS NOT NULL  ");

$latitude = array();
$longitude =array();

while($rowe = pg_fetch_array($resulte)){

    array_push($latitude,$rowe['tourism_experience_latitude']);
    array_push($longitude,$rowe['tourism_experience_longitude']);
   
};
while($rowi = pg_fetch_array($resulti)){

    array_push($latitude,$rowi['tourism_impressive_latitude']);
    array_push($longitude,$rowi['tourism_impressive_longitude']);
   
};
while($rowk = pg_fetch_array($resultk)){

    array_push($latitude,$rowk['tourism_knowhow_latitude']);
    array_push($longitude,$rowk['tourism_knowhow_longitude']);
   
};
while($rows = pg_fetch_array($results)){

    array_push($latitude,$rows['tourism_story_latitude']);
    array_push($longitude,$rows['tourism_story_longitude']);
   
};


$latitudes = implode(",", $latitude);
$longitudes = implode(",", $longitude);

$j_latitudes = json_encode($latitude);
$j_longitudes = json_encode($longitude);








?>