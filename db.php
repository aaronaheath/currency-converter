<?php

class db
{
  private $dbFile;
  private $dbUser;
  private $db;
  private $dbPassword;
  private $conn;
  private $stmt;
  private $cfd;
  private $mySqlI;

  function db()
  {
    $this->dbFile = new processFile(DB_PROPERTIES);
    $this->dbUser = $this->dbFile->getPropertyValue(DB_USER);
    $this->db = $this->dbFile->getPropertyValue(DB);
    $this->dbPassword = $this->dbFile->getPropertyValue(DB_PASSWORD);
    $this->mySqlI = $this->connect();
    
  }

  private function connect()
  {
    $mySqlI = new MySQLi();
    try
    {
      $mySqlI->connect(ini_get("mysqli.default_host") ,$this->dbUser, $this->dbPassword, $this->db);
    }
    catch(Exception $ex)
    {
      echo "Problem connecting to db $ex->getMessage()\n";
    }

    return $mySqlI;
  }

  public function insertConversion($conversionData)
  {
    if ($conversionData != null)
    {
       try
	 {
	   $insertCurrencyStmt = $this->mySqlI->prepare("INSERT INTO currency (code, country, rate) VALUES(?, ?, ? )");
	   $deleteCurrencyStmt = $this->mySqlI->prepare("DELETE FROM currency WHERE code = ? ");
	   
	   $code = $conversionData->getCode();
	   $country = $conversionData->getFromCurrency();
	   $rate = $conversionData->getRate();
	   
	   $insertCurrencyStmt->bind_param("ssd",
					   $code,
					   $country,
					   $rate);

	   

	   $insertCurrencyStmt->execute();
	   if ($this->mySqlI->insert_id <= 0)
	   {
	     $deleteCurrencyStmt->bind_param("s", $code);
	     $deleteCurrencyStmt->execute();
	     $deleteCurrencyStmt->close();
	     $deleteCurrencyStmt = null;
	     
	     $insertCurrencyStmt->execute();
	   
	   }

	   $insertCurrencyStmt->close();
	   $insertCurrencyStmt = null;
	   
	 }
       catch (Exception $ex)
       {
	 echo "Error ";
       }
    }
  } 

  public function selectConversion($conversionData)
  {

    if (! empty($conversionData))
    {
       try
       {
           $selectConversionStmt = $this->mySqlI->prepare("SELECT country, rate, date FROM currency WHERE code = ? ");
	   $code = $conversionData->getCode();
	   $selectConversionStmt->bind_param("s",$code);
	   $selectConversionStmt->execute();
	   $selectConversionStmt->bind_result($country, 
					      $rate, 
					      $date);



	   while ($selectConversionStmt->fetch())
	   {
	     $conversionData->setRate($rate);
	     $conversionData->setDate($date);
	   }
       }
       catch (Exception $ex)
       {
	 echo "ERROR selecting rate.";
       }

    }

    return $conversionData;
  }

}
?>
