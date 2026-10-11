
<?php
$height = array(
    "Andy" => 170,
    "Barry" => 165,
    "Charlie" => 170,
    "David" => 180,
    "Eva" => 172,
    "Frank" => 168,
    "George" => 175,
    "Henry" => 182
);

echo "height = ";
print_r($height);
echo "<br>";

echo "Nilai dengan indeks terakhir: " . $height["Henry"];
echo "<br><br>";

unset($height["Charlie"]);

echo "height = ";
print_r($height);
echo "<br>";

echo "Nilai dengan indeks terakhir: " . $height["Henry"];
?>
