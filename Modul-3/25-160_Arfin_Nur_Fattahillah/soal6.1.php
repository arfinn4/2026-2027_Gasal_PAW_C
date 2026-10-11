
<?php
// 1. Fungsi array_push()
$buah = array("A");
echo "Array awal: (\"A\")<br>";

array_push($buah, "B");
echo "Hasil array_push: " . implode(" ", $buah) . "<br><br>";


// 2. Fungsi array_merge()
$buah1 = array("A", "B");
$buah2 = array("C");

echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';

$hasil = array_merge($buah1, $buah2);
echo "Hasil array_merge: " . implode(" ", $hasil) . "<br><br>";


// 3. Fungsi array_values()
$data = array("x" => 1, "y" => 2);

echo 'Array awal: ("x" => 1, "y" => 2)<br>';

$hasil = array_values($data);
echo "Hasil array_values: " . implode(" ", $hasil) . "<br><br>";


// 4. Fungsi array_search()
$huruf = array("A", "B", "C");

echo 'Mencari "B" pada array: ("A", "B", "C")<br>';

$hasil = array_search("B", $huruf);
echo "Hasil array_search: " . $hasil . "<br><br>";


// 5. Fungsi array_filter()
$angka = array(0, 1, false, 2, "", 3, "array");

echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';

$hasil = array_filter($angka);
echo "Hasil array_filter: " . implode(" ", $hasil) . "<br><br>";


// 6. Fungsi sort() dan rsort()
$angka = array(3, 1, 2);

echo "Array awal: (3, 1, 2)<br>";

sort($angka);
echo "Hasil sort: " . implode(" ", $angka) . "<br>";

rsort($angka);
echo "Hasil rsort: " . implode(" ", $angka) . "<br><br>";


// 7. Fungsi asort(), arsort(), ksort()
$nilai = array("Peter" => 35, "Ben" => 37, "Joe" => 43);

echo 'Array awal: ("Peter" => 35, "Ben" => 37, "Joe" => 43)<br>';

asort($nilai);
echo "Hasil asort: ";
foreach ($nilai as $nama => $umur) {
    echo "$nama => $umur, ";
}
echo "<br>";

arsort($nilai);
echo "Hasil arsort: ";
foreach ($nilai as $nama => $umur) {
    echo "$nama => $umur, ";
}
echo "<br>";

ksort($nilai);
echo "Hasil ksort: ";
foreach ($nilai as $nama => $umur) {
    echo "$nama => $umur, ";
}
?>
