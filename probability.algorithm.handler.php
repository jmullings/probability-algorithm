<?php

ini_set('memory_limit', substr('0223705295M', 1));
error_reporting(E_ALL^E_NOTICE);

#Source any online thesaurus 
include_once 'bighugelabs_class.php';

$synonyms = new BigHugeLabs();
$keywords = "test";

class probabilityMatrix
 {
   #private vars
   var 
   $prob_array = array(), 
   $p_array = array();
   
   #flatten each array
   public function makeRecursive( $ar = "" )
   {
     $toflat = array(
        $ar 
     );
     $res    = array();
     while ( ( $r = array_shift( $toflat ) ) !== NULL ) {
       foreach ( $r as $v ) {
         if ( is_array( $v ) ) {
           $toflat[] = $v;
         } else {
           $res[] = $v;
         }
       }
     }
     return $res;
   }
   #Asort by probability
   public function returnProbability( $array = array())
   {
	 $array  = $this->makeRecursive( $array );  
     $this->p_array = array_count_values( $array );
	 
     foreach ( $this->p_array as $words => $val ) {
       $this->prob_array[$words] = $val/array_sum( $this->p_array ) * 100;
     }
     
     arsort( $this->prob_array );
     return $this->prob_array;
   }
 }
 
 
 $pm    = new probabilityMatrix;
 /* SKIP FOR EASE
 $array = $pm->makeRecursive( $synonyms->getKeywordArray( $keywords ) );
 
 foreach ( $array as $word ) {
   $secondary_array[] = $synonyms->getKeywordArray( $word );
 }
 
 $test_array = array_merge( $array,  $secondary_array  );
 
 
*/

include_once 'test.word.array.php';

global $test_array;

print_r( $pm->returnProbability( $test_array ) );
