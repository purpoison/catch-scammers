<?php 
    function connectToDatabase() {
        $dsn = 'mysql:host=localhost;dbname=badpeoples';
        $user = 'root';
        $password = '';
    
        try {
            $dbh = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {    
            die("Error! Code: {$e->getCode()}. Message: {$e->getMessage()}".PHP_EOL);
        }
        return $dbh;
    };

    function createScammers($num, $faker){
        $data = [];
        for($i = 0; $i < $num; $i++){
            $data[] = [
                'name' => $faker->name(),
                'phone' => $faker->numberBetween(1000000000, 9999999999),
                'card_num' => $faker->creditCardNumber('Visa')
            ];
        }
        return $data;
    };

    function fillScammers($dbh, $scammers){
        try {
            $sql = "INSERT INTO scammers (name, phone, card_num) VALUES (:name, :phone, :card_num);";
            $sth = $dbh->prepare($sql);
            $id = '';
            foreach($scammers as $scammer){
                $sth->execute([
                    'name' => $scammer['name'],
                    'phone' => $scammer['phone'],
                    'card_num' => $scammer['card_num']
                ]);
            }
            $id.= $dbh->lastInsertId();
    
        } catch (PDOException $e) {
            die("Error! Code: {$e->getCode()}. Message: {$e->getMessage()}".PHP_EOL);
            exit;
        }
        return $id;
    };

    function generateIDs($num){
        $scammer_ids = [];
        for($i = 1; $i <= $num; $i++){
            array_push($scammer_ids, rand(1, $num));
        }
        return $scammer_ids;
    };

    function createCases($num, $faker){
        $data = [];
        $ids = generateIDs($num);
        $estates = ['квартира', 'будинок', 'кімната'];
        $regions = ['Хмельницька', 'Львівська', 'Тернопільська', 'Івано-Франківська', 'Вінницька'];
        foreach($ids as $id){
            $data[] = [
                'scammer_id' => $id,
                'type_of_real_estate' => $estates[rand(0, count($estates) - 1)],
                'region' => $regions[rand(0, count($regions) - 1)].' область',
                'city' => $faker->word(),
                'title' => $faker->sentence(),
                'text' => $faker->text(100),
                'img_path' => $faker->image(null, 640, 480),
                'social' => $faker->url(),
                'date' => $faker->date("Y-m-d H:i:s")
            ];
        }
        return $data;
    };

    function fillCases($dbh, $cases){
        try {
            $sql = "INSERT INTO cases (scammer_id, type_of_real_estate, region, city, title, text, img_path, social, date) VALUES (:scammer_id, :type_of_real_estate, :region, :city, :title, :text, :img_path, :social, :date);";
            $sth = $dbh->prepare($sql);
            foreach($cases as $case){
                $sth->execute([
                    'scammer_id' => $case['scammer_id'],
                    'type_of_real_estate' => $case['type_of_real_estate'],
                    'region' => $case['region'],
                    'city' => $case['city'],
                    'title' => $case['title'],
                    'text' => $case['text'],
                    'img_path' => $case['img_path'],
                    'social' => $case['social'],
                    'date' => $case['date'],
                ]);
            }
    
        } catch (PDOException $e) {
            die("Error! Code: {$e->getCode()}. Message: {$e->getMessage()}".PHP_EOL);
            exit;
        }
    };

    function searching($dbh, $word){

        $sql = "SELECT scammers.*, cases.* FROM scammers
        JOIN cases ON scammers.id = cases.scammer_id
        WHERE scammers.name LIKE '%{$word}%' OR scammers.phone LIKE '%{$word}%' OR scammers.card_num LIKE '%{$word}%'";

        try {
            
            $sth = $dbh->query($sql);
            
        } catch (PDOException $e) {
            die("Error! Code: {$e->getCode()}. Message: {$e->getMessage()}".PHP_EOL);
            exit;
        }
        return $sth;
    }
    
    function showRecently($dbh){
        $sql = "SELECT scammers.*, cases.* FROM scammers
        JOIN cases ON scammers.id = cases.scammer_id ORDER BY cases.date DESC";
        try {
            $sth = $dbh->query($sql);
        } catch (PDOException $e) {
            die("Error! Code: {$e->getCode()}. Message: {$e->getMessage()}".PHP_EOL);
            exit;
        }
        return $sth;
    }
    
    function getTop($dbh){
        $sql = "SELECT MAX(name) as name, MAX(phone) as phone, card_num, COUNT(id) as cases FROM scammers GROUP BY card_num ORDER BY cases DESC;
        ";
        try {
            $sth = $dbh->query($sql);
        } catch (PDOException $e) {
            die("Error! Code: {$e->getCode()}. Message: {$e->getMessage()}".PHP_EOL);
            exit;
        }
        return $sth;
    }