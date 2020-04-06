<?php

function loadJSON($filepath)
{
    $jsonData = file_get_contents($filepath);
    return json_decode($jsonData);
}

function dataJSON($filepath, $username, $email, $phone)
{
    try {
        $contact = ["username" => $username, "email" => $email, "phone" => $phone];

        $arr = loadJSON($filepath);
        array_push($arr, $contact);
        $jsonData = json_encode($arr);
        file_put_contents($filepath, $jsonData);
        echo "Saved Register";
    }
    catch (Exception $exception){
        echo "Error: ", $exception->getMessage();
    }
}
