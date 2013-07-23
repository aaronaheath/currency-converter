<?php
/* Written by Aaron Heath http://www.aaronandmeng.com
 26-August-2007
*/
// class takes a file and preforms operations on it.

class processFile {

  private $file = ''; 

  function processFile($file) {
    $this->file = $file;
  }


  // returns an array of items from the given comma seperated list file.	
  public function getCsvItemsFile() {

    $row = 1;
    $items = array();
    $handle = @fopen("$this->file", "r");
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      $num = count($data);
      $row++;
      for ($c= 0; $c < $num; $c++) {
	//trim off any spaces
	$item = trim($data[$c]);
	if (! empty($item)) {	
	    array_push($items, $item);
	}
      }
    }

    fclose($handle);
    sort($items);
    
    return $items;
  }

  public function getCsvItems($csvString)
  {
    $stringArray = array();
    if (! empty($csvString))
    {
      $stringArray = explode(",", $csvString);
    }
    return $stringArray;
  }
  
  //Returns an array containing the contents of a file.
  public function getFileTextArray() {
    
    return @file($this->file);
    
  } 

  // finds a property value when given a key.
  public function getPropertyValue($key)
  {
    $sitePropsArray = array();
    $sitePropsArray = $this->getFileTextArray();
    $sitePropsCount = count($sitePropsArray);
    $result = array();
    
    for ($i = 0; $i < $sitePropsCount; $i++)
    {
        $value = $sitePropsArray[$i]; 
	
	if (strpos($value, $key) !== false)
        {
	  $result = explode("=", $value, 2);
	  break;
	}
    }
    
    $propValue = $this->getValue($result);
    return trim($propValue);	
  }

  private function getValue($result)
  {
    $value = "";
    
    if (is_array($result))
    {
      if (count($result) == 2)
      {
	$value = $result[1];
      }
    }

    return $value;
  
  }

  //Returns a String containing the contents of a file.
  public function getFileText() {

    $file_data = "" ;
    $fh = @fopen($this->file, 'r');
    if (! empty($fh)) {
      $file_data = fread($fh, 1000);
      fclose($fh);
    }
    return $file_data;
  }

}
?>
