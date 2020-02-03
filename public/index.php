<?php

use App\Declension;
use App\Gender;
use App\GrammarCase;

require_once '../vendor/autoload.php';

$dec = new Declension();

$dec->setGender(Gender::getFemaleGender());
echo 'Имя "Ирина" в дательном падеже будет: ' .  $dec->name('Ирина', GrammarCase::getDativeCase());

echo "<br/>";

$dec->setGender(Gender::getFemaleGender());
echo 'Фамилия "Долгих" в родительном падеже будет: ' . $dec->surname('Долгих', GrammarCase::getDativeCase());

echo "<br/>";

echo 'Фамилия "Долгорукая" в творительном падеже будет: '
    . $dec->surname('Долгорукая', GrammarCase::getInstrumentalCase());
