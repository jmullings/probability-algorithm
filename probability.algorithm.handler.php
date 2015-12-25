<?php
include_once 'bighugelabs_class.php';
$synonyms = new BigHugeLabs();
$keywords = "algorithm";
$array = array_merge($synonyms-> getKeywordArray($keywords));
print_r($array);

?>
