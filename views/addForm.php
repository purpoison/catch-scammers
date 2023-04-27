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
        <div class="mt-3 mb-3">    
            <a class='btn btn-primary' href='/views/index.php' role='button'>На головну</a>
        </div>
        <form action="../addNewScammer.php" method="POST" class="add-scammer" enctype="multipart/form-data">
            <div class="mt-4">
                <h3 class="title">Дані орендодавця</h3>
                <div class="border-bottom border-dark-subtle mb-4"></div>
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="John Smith" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="card_num" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Номер картки" maxlength=16>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">+38</span>
                    <input type="text" name="phone" class="form-control" placeholder="097997251"  aria-label="Username" aria-describedby="basic-addon1" maxlength=10>
                </div>
                <div class="mb-3">
                    <input type="text" name="social" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="https://instagram.com/johnsmith">
                </div>
            </div>
            <div class="mt-4">
                <h3 class="title">Житло</h3>
                <div class="border-bottom border-dark-subtle mb-4"></div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type_of_real_estate" id="inlineRadio1" value="квартира" checked>
                    <label class="form-check-label" for="inlineRadio1">квартира</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type_of_real_estate" id="inlineRadio2" value="будинок">
                    <label class="form-check-label" for="inlineRadio2">будинок</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type_of_real_estate" id="inlineRadio3" value="кімната">
                    <label class="form-check-label" for="inlineRadio3">кімната</label>
                </div>
                <select name="region" id="region" class="form-select mt-2">
                    <?php foreach ($regions as $region):?>
                        <?php $val = explode(' ', $region);
                        $new = str_replace(' ', '_', $region);
                        ?>
                    <option value=<?= $new?>><?= $region?></option>
                    <?php endforeach?>
                </select>
                <select name="city" id="city" class="form-select d-none mt-3">
                </select>
            </div>
            <div class="mt-4">
                <h3 class="title">Опишіть ситуацію</h3>
                <div class="border-bottom border-dark-subtle mb-4"></div>
                <div class="mb-3">
                    <label for="title" class="form-label">Коротко про ситуацію</label>
                    <input type="text" name="title" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Зник після отримання передоплати....">
                </div>


                <textarea class="form-control" id="exampleFormControlTextarea1" name="text" id="" cols="30" rows="10" placeholder="Опишіть детальніше, що конкретно трапилось"></textarea>
            </div>
            <div class="mt-4">
                <h3 class="title">Фотот/Скріншоти</h3>
                <div class="border-bottom border-dark-subtle mb-4"></div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Додайте фото: скріншоти переписки в месенжерах, соц.мережах, смс, квитанції оплат, тощо... Все що є підтвердженням шахрайськоі схеми.</label>
                    <input class="form-control" type="file" id="formFile" name="img_path">
                </div>
            </div>
            <!-- <div class="text-center mt-3 mb-5">  
                <a href="#">Додати ще файли</a>
            </div> -->
            <div class="border-bottom border-dark-subtle mb-4"></div>
            <div class="text-center mt-3 mb-5">  
                <button class="btn btn-primary" type="submit" name="submit">Опублікувати</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script> 
        fetch('../data/citys.json')
        .then((response) => response.json())
        .then((data) => {
            let regionSelect = document.getElementById('region');
            let citySelect = document.getElementById('city');
            regionSelect.addEventListener('change', e =>{
                let selectValue = regionSelect.value;
                let region = selectValue.replace(/_/g, ' ');
                let rez = region.toUpperCase();
                citySelect.classList.remove('d-none');
                let selectedcitys = data.filter(obj => obj.region === rez);
                let options = '';
                selectedcitys.forEach(e => {
                    let city = e['object_name'].toLowerCase();
                    let cityName = city[0].toUpperCase() + city.slice(1);
                    let cate
                    console.log();
                    options += `<option value="${cityName}">${e['object_category']} ${cityName}</option>`;
                });
                citySelect.innerHTML = options;
            })
        })
        .catch(error => console.error(error));
    </script>   
</body>
</html>