<?php
class BigHugeLabs{
    private $filename;
    private $base_url = 'http://words.bighugelabs.com/api/2';
    private $api_key = '????????';
    function __construct(){
    }
    private function generateFileName(){
        $this->filename = 'synonyms_'. time() .'.csv';
        return $this->filename;
    }
    private function writeToFile($keyword, $words){
        if (file_exists('tmp\\' . $this->filename))
            $fh = fopen('tmp\\' .$this->filename, 'a');
        else
            $fh = fopen('tmp\\' .$this->filename, 'w');
        fputcsv($fh, $words);
        fclose($fh);
    }
    private function getSynonyms($keyword, $format = 'php'){
        $url = $this->base_url.'/'.$this->api_key.'/'.$keyword.'/'.$format;
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec ($ch);
        curl_close ($ch);
        return $output;
    }
	 private function getAntonyms($keyword, $format = 'php'){
        $url = $this->base_url.'/'.$this->api_key.'/'.$keyword.'/'.$format;
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec ($ch);
        curl_close ($ch);
        return $output;
    }
	public function bighugelabs_search($search_for, $search_in) {
    foreach ($search_in as $key => $element) {
        if ( ($key === $search_for) || (is_array($element) && $this->bighugelabs_search($search_for, $element)) ){
            echo array_shift(array_values($element));
			exit;
        }
    }
    return NULL;
	exit;
}


	    public function getKeywordSynonyms($keyword){
         $keyword = trim($keyword);
        if(empty($keyword))
            return false;
        try {
            $output = $this->getAntonyms($keyword);
            $output = $this->bighugelabs_search("syn", unserialize($output));
            /*IF any input miss the data from target, again make a call*/
            if(empty($output)){
                $output = $this->getAntonyms($keyword);
                ///$output = json_decode($output,true);
            }
            return  $output;
        } catch (Exception $e) {
            //header('Content-Type: application/json');
            return array('status' => false, 'error_message' => $e->getMessage());
        }
    }
	
    public function getKeywordAntonyms($keyword){
        $keyword = trim($keyword);
        if(empty($keyword))
            return false;
        try {
            $output = $this->getAntonyms($keyword);
            $output = $this->bighugelabs_search("ant", unserialize($output));
            /*IF any input miss the data from target, again make a call*/
            if(empty($output)){
                $output = $this->getAntonyms($keyword);
                ///$output = json_decode($output,true);
            }
            return  $output;
        } catch (Exception $e) {
            //header('Content-Type: application/json');
            return array('status' => false, 'error_message' => $e->getMessage());
        }
    }
	    public function getKeywordArray($keyword){
        $keyword = trim($keyword);
        if(empty($keyword))
            return false;
        try {
            $output = $this->getAntonyms($keyword);
            $output = unserialize($output);
            /*IF any input miss the data from target, again make a call*/
            if(empty($output)){
                $output = $this->getAntonyms($keyword);
                ///$output = json_decode($output,true);
            }
            return  $output;
        } catch (Exception $e) {
            //header('Content-Type: application/json');
            return array('status' => false, 'error_message' => $e->getMessage());
        }
    }
	public function quit(){
		exit;
	}
	
}
?>
