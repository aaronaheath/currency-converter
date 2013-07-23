<?php

class ConversionData
{
  private $fromCurrency;
  private $toCurrency = "EUR";
  private $inputs;
  private $code;
  private $products;
  private $rate;
  private $conversion;
  private $date;

  public function getCode()
  {
    $this->code = "";
    if (! empty($this->fromCurrency))
    {
      $parts = explode(":", $this->fromCurrency);
      $this->code = $parts[1]; 
    }

    return $this->code;
  }
  
  public function setFromCurrency($fromCurrency)
  {
    $this->fromCurrency = $fromCurrency;
  }

  public function getFromCurrency()
  {
    return $this->fromCurrency;
  }

  public function setToCurrency($toCurrency)
  {
    $this->toCurrency = $toCurrency;
  }
  
  public function getToCurrency()
  {
    return $this->toCurrency;
  }

  public function setInputs($inputs)
  {
    $this->inputs = $inputs;
  }

  public function getInputs()
  {
    return $this->inputs;
  }
  
  public function setProducts($products)
  {
    $this->products = $products;
  }

  public function getProducts()
  {
    return $this->products;
  }

  public function setRate($rate)
  {
    $this->rate = $rate;
  }

  public function getRate()
  {
    return $this->rate;
  }
  
  public function setConversion()
  {
    if ($this->rate > 0)
      $this->conversion = 1/$this->rate;
    
    else
      $this->conversion = 0;
  }

  public function getConversion()
  {
    return $this->conversion;
  }

  public function setDate($date)
  {
    $this->date = $date;
  }

  public function getDate()
  {
    return $this->date;
  }

  public function validateForm() 
  {
    $errors = array();
    if (empty($this->fromCurrency)) 
    {
      array_push($errors, "Please Select your currency.\n");
    }
    
    return $errors;
  }
}
?>