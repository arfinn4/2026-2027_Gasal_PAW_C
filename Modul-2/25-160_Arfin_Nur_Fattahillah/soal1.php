<?php

$Smatkul = array(
    "PTI",
    "ALPRO",
    "DPW",
    "STRUKDAT",
    "JARKOM",
    "PAW",
    "PSBF",
    "RPL"
);

$Spraktikum = array(
    "JARKOM",
    "PAW"
);

for ($i = 0; $i < count($Smatkul); $i++) {

    $matkul = $Smatkul[$i];

    if (in_array($matkul, $Spraktikum)) {

        echo "Saya sedang mengambil matkul $matkul termasuk praktikum nya<br>";

    } elseif ($i == 6 || $i == 7) {

        echo "Saya belum mengambil matkul $matkul<br>";

    } else {

        echo "Saya sudah mengambil matkul $matkul semester lalu<br>";
    }
}

?>