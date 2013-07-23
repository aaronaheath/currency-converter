<?php
require_once('../../../php/param/get_param.php');
require_once('ConverterForm.php');
require_once('ConversionData.php');
require_once('request.php');
require_once('product.php');
require_once('inc/currency_defs.php');
require_once('db/db.php');
require_once('../../../php/inc/processFile.php');

class converter
{

  private function doDisplay($conversionData = '', $errors = '')
  {
    $converterForm = new ConverterForm($conversionData, $errors);
    echo $converterForm->doDisplay();
  }

  private function displayForm()
  {
    $conversionData = $this->marshallForm();
    $conversionData->setProducts($this->getProducts(null));
    $this->doDisplay($conversionData, null);
  }

  private function convert()
  {
    $conversionData = $this->marshallForm();
    $url = CONVERSION_HOST.$conversionData->getCode();
    
    $xml = false;
    $response = Request::doRequest($url);
    try
    {
      $xml = @simplexml_load_string($response);
    }
    catch (Exception $e)
    {
      echo "HELLO :)";

    }
    if (!$xml)
    {
      $conversionData = $this->selectConversion($conversionData);
    }
    else
    {
      $rate = $this->getRate($xml);
      
      $conversionData->setRate($rate);
      $this->insertConverstion($conversionData);
      $conversionData->setDate(getDate());
    }
    
    $conversionData->setConversion();
    $conversionData->setProducts($this->getProducts($rate));
    
    $this->doDisplay($conversionData, null);
    
  }

  private function insertConverstion($conversionData)
  {
    $db = new db();
    $db->insertConversion($conversionData);
    $db = null;
  }
  
  private function selectConversion($conversionData)
  {
    $db = new db();
    $conData = $db->selectConversion($conversionData);

    return $conData;
  }

  private function getProducts($rate = '')
  {
    $products = array();

    $p1 = $this->createProduct(PROD1, $rate);
    array_push($products, $p1);

    $p2 = $this->createProduct(PROD2, $rate);
    array_push($products, $p2);

    $p3 = $this->createProduct(PROD3, $rate);
    array_push($products, $p3);

    $p4 = $this->createProduct(PROD4, $rate);
    array_push($products, $p4);

    $p5 = $this->createProduct(PROD5, $rate);
    array_push($products, $p5);

    $p6 = $this->createProduct(PROD6, $rate);
    array_push($products, $p6);

    $p7 = $this->createProduct(PROD7, $rate);
    array_push($products, $p7);

    
    return $products;
    
  }
        
   private function createProduct($price, $rate = '')
  {
    $product = new product();
    
    if (! empty($rate))
    {
      $convertedPrice = round(($price / $rate), 0);
      $product->setConvertedPrice($convertedPrice);
    }
    
    $product->setPrice($price);
    return $product;
  }
  
  private function getRate($xmlResponse)
  {
    $rate = 0;
    
    if ($xmlResponse != null)
    {
        $rate = (float) $xmlResponse;
    }

    return $rate;
  }
  
  private function marshallForm()
  {
    $formData = new ConversionData();
    $formData->setFromCurrency(get_param::get_parameter(CONVERT_FROM));
    $formData->setToCurrency(get_param::get_parameter(CONVERT_TO));
    $formData->setInputs(get_param::get_parameter(INPUTS));
    
    return $formData;
  }

  public function handleRequest() 
  {
    $action = get_param::get_parameter(ACTION);
    
    if ($action == "") 
    {
      $action = DISPLAY_FORM;
    }  
    switch($action) 
    {
    case DISPLAY_FORM:
      $this->displayForm();
      break;
    case CONVERT:
      $this->convert();
      break;
    default:
      $this->displayForm();
   }    
  }


}

// Application start
$converter = new Converter();
$converter->handleRequest();

?>
