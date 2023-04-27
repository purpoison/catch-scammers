<?php 
require_once __DIR__.'/init.php';

$faker = Faker\Factory::create();

$dbh = connectToDatabase();

$num = 10;

$scammers = createScammers($num, $faker);

// fillScammers($dbh, $scammers);

$cases = createCases($num, $faker);

// fillCases($dbh, $cases);

require_once __DIR__.'/views/index.php';