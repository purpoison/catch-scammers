<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bad peoples</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
<?php
    require_once __DIR__.'/init.php';
    $dbh = connectToDatabase();
    if(isset($_POST['submit'])){
        $file = $_FILES['img_path'];
        $fileName = $_FILES['img_path']['name'];
        $fileTmpName = $_FILES['img_path']['tmp_name'];
        $filePath = 'uploads/'.$fileName;
        move_uploaded_file($fileTmpName, $filePath);
        $newScammer = [ 
            [
            'name' => $_POST['name'],
            'phone' => $_POST['phone'],
            'card_num' => $_POST['card_num'],
            ]
        ];

        $scammer_id = fillScammers($dbh, $newScammer);
        $region = str_replace("_", " ", $_POST['region']);
        $newCase = [
                [
                'scammer_id' => $scammer_id,
                'type_of_real_estate' => $_POST['type_of_real_estate'],
                'region' => $region,
                'city' => $_POST['city'],
                'title' => $_POST['title'],
                'text' => $_POST['text'],
                'img_path' =>  $filePath,
                'social' => $_POST['social'],
                'date' => date("Y-m-d H:i:s")
                ]
        ];

        fillCases($dbh, $newCase);
        echo "<div class='container mt-3'><a class='btn btn-primary' href='/views/index.php' role='button'>На головну</a> <div class='text-center'><h2> Дані про шахрая успішно додані</h2></div></div>";
    }
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>

