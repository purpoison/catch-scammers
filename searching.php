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

    if(isset($_POST['startSearch'])){
        $sth = searching($dbh, $_POST['searchName']);
        if ($sth) {
            $allRows = $sth->fetchAll(PDO::FETCH_OBJ);
            if(!empty($allRows)){
              $counter = $sth->rowCount();
              echo "<div class ='container mt-5'>
              <div class='mt-3 mb-3'>    
              <a class='btn btn-primary' href='/views/index.php' role='button'>На головну</a>
              </div>
              <h2>Знайдено за запитом ({$counter})</h2>
              <div class='row justify-content-between'>";
              foreach ($allRows as $row) {
                  echo "
                  <div class='card w-50 mb-3 me-3'>
                  <div class='card-body'>
                    <h5 class='card-title'>{$row->name}</h5>
                    <p class='card-text'>{$row->title}</p>
                    <p class='card-text'>{$row->text}</p>
                    <p class='card-text'>{$row->card_num}</p>
                    <div class='row gap-3'>
                      <span>{$row->region}</span>
                      <span>+38{$row->phone}</span>
                      <span>{$row->date}</span>
                    </div>
                  </div>
                </div>
                ";
              }
              echo "</div>
              </div>";
            }else{
              echo "<div class ='container mt-5'>
              <div class='mt-3 mb-3'>    
              <a class='btn btn-primary' href='/views/index.php' role='button'>На головну</a>
              </div>
                <h2>Зa Вашим запитом нічого не знайдено</h2>
                </div>";
            }
        }
    }
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
