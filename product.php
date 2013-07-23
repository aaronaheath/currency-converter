<?php

class product
{
  private $price;
  private $convertedPrice;

  public function getPrice()
  {
    return $this->price;
  }

  public function setPrice($price)
  {
    $this->price = $price;
  }

  public function getConvertedPrice()
  {
    return $this->convertedPrice;
  }

  public function setConvertedPrice($convertedPrice)
  {
    $this->convertedPrice = $convertedPrice;
  }

}

?>