<?php

function loadJSON($filename)
{
    $jsonData = file_get_contents($filename);
    return json_decode($jsonData);
}

function saveJSON($filename, $data)
{
    try {
        $arrData = loadJSON($filename);
        array_push($arrData, $data);
        $jsonData = json_encode($arrData);
        file_put_contents($filename, $jsonData);
        echo "Lưu dữ liệu thành công!";
    } catch (Exception $e) {
        echo 'Lỗi: ', $e->getMessage();
    }
}

$nameErr = NULL;
$emailErr = NULL;
$phoneErr = NULL;
$name = NULL;
$email = NULL;
$phone = NULL;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_REQUEST["name"];
    $email = $_REQUEST["email"];
    $phone = $_REQUEST["phone"];
    $hasError = false;

    if (empty($name)) {
        $nameErr = "Tên đăng nhập không được để trống!";
        $hasError = true;
    }

    if (empty($email)) {
        $emailErr = "Email không được để trống!";
        $hasError = true;
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Định dạng email sai (xxx@xxx.xxx.xxx)!";
            $hasError = true;
        }
    }

    if (empty($phone)) {
        $phoneErr = " Số điện thoại không được để trống!";
        $hasError = true;
    }

    if ($hasError == false) {
        saveJSON("user.json", $data);
        $data = [
            "name" => $name,
            "email" => $email,
            "phone" => $phone
        ];
    }
}

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <style>
        .error {
            color: #FF0000;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: solid 1px #ccc;
        }

        form {
            width: 450px;
        }
    </style>
    <title>Register Form</title>
</head>
<body>
<h2>Registration Form</h2>
<form method="post">
    <fieldset>
        <legend>Details</legend>
        Name: <input type="text" name="name" value="<?php echo $name; ?>">
        <span class="error">* <?php echo $nameErr; ?></span>
        <br><br>
        E-mail: <input type="text" name="email" value="<?php echo $email; ?>">
        <span class="error">* <?php echo $emailErr; ?></span>
        <br><br>
        Phone: <input type="text" name="phone" value="<?php echo $phone; ?>">
        <span class="error">*<?php echo $phoneErr; ?></span>
        <br><br>
        <input type="submit" name="submit" value="Register">
        <p><span class="error">* required field.</span></p>
    </fieldset>
</form>

<?php
$registrations = loadJSON('user.json');
?>
<h2>Registration list</h2>
<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
    </tr>
    <?php foreach ($registrations as $registration): ?>
        <tr>
            <td><?= $registration['name']; ?></td>
            <td><?= $registration['email']; ?></td>
            <td><?= $registration['phone']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>