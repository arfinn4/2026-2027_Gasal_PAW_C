
<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

for ($x = 1; $x <= 5; $x++) {
    $fruits[] = "Buah Tambahan $x";
}

echo "Panjang array saat ini: " . count($fruits) . "<br><br>";

foreach ($fruits as $buah) {
    echo $buah . "<br>";
}
?>
