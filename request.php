<?php
include_once('/home/aaronand/public_html/jiri/grano/currency/inc/currency_defs.php');
class Request
{
  private $ip;
    
  function Request($ip)
  {
    $this->ip = $ip;
  }
  
  public function getLocal()
  {
    if (! empty($this->ip))
    {
      $url = LOCALE_HOST.$this->ip;
      $parts = $this->doRequest($url);
      return $parts;
    }
  }
 
  public static function doRequest($url)
  {

    $request = curl_init($url);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($request);      
    curl_close($request);

    return $output;
  }

  
}
?>
