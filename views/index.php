<?php require_once __DIR__.'../../init.php';?>  
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
    <div class="container">
    <div class="text-end mt-4">
            <a class="btn btn-success" href="/views/addForm.php" role="button">Повідомити про шахрайство</a>
        </div>
        <div class="text-center mt-5">
            <h1>Шукайте і додавайте шахраїв</h1>
            <p>На сайті можна знайти а також додати шахраїв по номеру телефона, банківській карті та ПІБ
            Вони ошукали велику кількість людей, будьте уважними та відповідальними, не даруйте шахраям свої кошти (а іноді останні). Перевіряйте реквізити.</p>
        </div>
    <form class="d-flex mt-4" role="search" action="/searching.php" method="POST">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="searchName">
            <button class="btn btn-outline-success" type="submit" name="startSearch">Пошук</button>
    </form>
    <div class="border-bottom border-dark-subtle mt-4"></div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h2 class="text-start mb-4">Нещодавно додані</h2>
                    <?php 
                        $dbh = connectToDatabase();
                    $sth = showRecently($dbh);
                    if ($sth) {
                        $allRows = $sth->fetchAll(PDO::FETCH_OBJ);
                        $counter = $sth->rowCount();
                        foreach ($allRows as $row) {
                            echo "
                            <div class='mb-3 mb-sm-0'>
                                <div class='card text-start mb-3'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>{$row->title}</h5>
                                        <p class='card-text'>{$row->text}</p>
                                        <div class='d-flex justify-content-between'>
                                        <p>{$row->date}</p>
                                        <div><a href='#' class=''>Детальніше про історію</a> </div>
                                        </div>
                                    </div>
                                    <div class='card-header'>
                                    <p>Карта: <b>{$row->card_num}</b></p>
                                    <p>Телефон: <b>+38{$row->phone}</b></p>
                                </div>
                                </div>
                            </div>
                            ";
                        }
                    }
                    ?>
            </div>
            <div class="col">
            <h2 class="text-start mb-4">Топ шахраїв</h2>
            <?php $sth = getTop($dbh);
                        if ($sth) {
                            $rows = $sth->fetchAll(PDO::FETCH_OBJ);
                            foreach($rows as $row){
                                echo "
                                <div class='card bg-warning-subtle mb-3'>
                                <h5 class='card-header p-3'>Історій шахрайства ({$row->cases})</h5>
                                <div class='card-body'>
                                <h5 class='card-title'>{$row->name}</h5>
                                <p class='card-text'>Карта: <b>{$row->card_num}</b></p>
                                <p class='card-text'>Телефоні: <b>{$row->phone}</b></p>
                                <div class='d-flex'>
                                    <a href='#' class='btn btn-outline-primary me-2'>Всі історії</a>
                                    <a href='#' class='btn btn-outline-primary'>Додати свою історію</a>
                                </div>
                            </div>
                            </div>
                                ";
                            }
                        }
                    ?>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
