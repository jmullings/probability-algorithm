<?php

ini_set('memory_limit', substr('0223705295M', 1));
error_reporting(E_ALL^E_NOTICE);

#Source any online thesaurus 
include_once 'bighugelabs_class.php';

$synonyms = new BigHugeLabs();
$keywords = "test";

class probabilityRandom {
	#private vars
	var
		$data = array(),
		$universe = 0;
	#flattern array	
	function makeRecursive($array =""){
		$array = call_user_func_array('array_merge_recursive', $array);
		foreach($array as $value){
		if(is_array($value))
		return makeRecursive($array);
		else
		$rec_array []= $value;
		}	
		return $rec_array;
	}	

	#add an item to the list and defines its probability of beeing chosen
	function add( $data, $probability ){
		$this->data[ $x = sizeof( $this->data ) ] = new stdClass;
		$this->data[ $x ]->value = $data;
		$this->universe += $this->data[ $x ]->probability = abs( $probability );
	}

	#remove an item from the list
	function remove( $index ){
		if( $index > -1 && $index < sizeof( $this->data ) ) {
			$item = array_splice( $this->data, $index, 1 );
			$this->universe -= $item->probability;
		}
	}

	#clears the class
	function clear(){
		$this->universe = sizeof( $this->data = array() );
	}

	#return a randomized item from the list
	function get(){
		if( !$this->universe )
			return null;
		$x = round( mt_rand( 0, $this->universe ) );
		$max = $i = 0;
		do
			$max += $this->data[ $i++ ]->probability;
		while( $x > $max );
		return $this->data[ $i-1 ]->value;
	}
}

$prExample = new probabilityRandom;
/*
$array = $prExample->makeRecursive($synonyms-> getKeywordArray($keywords));

///Can be repeated for wider scope
foreach($array as $word){
	
	$secondary_array []= $synonyms-> getKeywordArray($word);
	
	}

foreach($prExample->makeRecursive($secondary_array) as $test_array)
{
	
	echo $test_array."<br />";
	
};
*/
include_once 'test.word.array.php';

global $test_array;

foreach(array_count_values($test_array) as $prob_words => $val)
{
	
	$prExample->add($prob_words, $val*100 );
	
};
#Possible adjustment for array / prob ratio and inclusion to class!!
for( $x=10; $x--; print strtolower( $prExample->get() ). '<br />' );
