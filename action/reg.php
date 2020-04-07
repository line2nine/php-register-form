<?php
function loadJSON($filename)
{
    $jsonData = file_get_contents($filename);
    return json_decode($jsonData, true);
}

function saveJSON($filename, $name, $email, $phone)
{
    try {
        $contact = array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        );
        $arrData = loadJSON($filename);
        array_push($arrData, $contact);
        $jsonData = json_encode($arrData, JSON_PRETTY_PRINT);
        file_put_contents($filename, $jsonData);
        echo "Lưu dữ liệu thành công!";
    } catch (Exception $e) {
        echo 'Lỗi: ', $e->getMessage();
    }
}
