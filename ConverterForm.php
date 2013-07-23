<?php

class ConverterForm
{
  private $fromCurrency;
  private $toCurrency;
  private $inputs;
  private $errors;
  private $products;
  private $rate;
  private $conversion;
  private $date;
  
  public function ConverterForm($conversionData = '', $errors = '')
  {
    $this->errors = $errors;

    if (! empty($conversionData))
    {
      $this->fromCurrency = $conversionData->getFromCurrency();
      $this->toCurrency = $conversionData->getToCurrency();
      $this->inputs = $conversionData->getInputs();
      $this->products = $conversionData->getProducts();
      $this->rate = $conversionData->getRate();
      $this->conversion = $conversionData->getConversion();
      $this->date = $conversionData->getDate();

      if ($this->conversion > 0)
	$this->conversion = round($this->conversion, 4);

      if (empty($this->date))
	$this->date = getDate();
    }
  }

  public function doDisplay()
  {
    
    ?>
    <style>

      body { font-family: arial; }
    p { font-size: 13px; }
    h2 { font-size: 24px; 
      font-style: italic;
    }
  

</style>
    <script language="javascript">
    function get() {
      //'var poststr = "toCurrency=" + encodeURI( document.getElementById("currency").value ) ;
      //'alert(poststr);
      document.conversion.submit();
      //makePOSTRequest("converter.php?action=convert", poststr);
      }
      </script>
      <form id="conversionForm" name="conversion" action="converter.php" method="post">
      <input type="hidden" name="<?php echo ACTION ?>" value="<?php echo CONVERT ?>">
 
<?php	  
$dropdown = '<select id="'.CONVERT_FROM.'" name="'.CONVERT_FROM.'" onchange="javascript:get();">'."\n";
    if (empty($this->fromCurrency))
      {
	$dropdown .= '<option value="">Select Your Local Currency</option>'."\n";
      }
    else
      {
	$dropdown .= '<option value="'.$this->fromCurrency.'">'.$this->fromCurrency.'</option>'."\n";
      }

    // get currencies
    $currency_list_file = new processFile("data/currency.csv");
    $currency_list_array = $currency_list_file->getCsvItemsFile();

    $currency_count = count($currency_list_array);
    for ($i = 0; $i < $currency_count; $i++) {
      $item = $currency_list_array[$i];
      $dropdown .= '<option value="'.$item.'">'.$item.'</option>'."\n";
    }

    $dropdown .= '</select>'."\n";
    ?>
      
       <table border="1" cellpadding="2" cellspacing="0" width="670" height="100%" 
       style="border-collapse: collapse" bordercolor="#111111">
        <tr>
        <td></td> 
        <td align="left">
	<?php if ($this->conversion > 0)
	{
	  //TODO:
	  $today = $this->date;
	  //	  var_dump($this->date);
	  $msg = "The Rate of $this->fromCurrency/EUR <br /> for $today[mday]-$today[month]-$today[year] <br /> is: $this->conversion";
	  echo $msg; 
        }
    
            ?>
        </td>
          <td width="59" align="right" bgcolor="#FFFF99" height="5%">
	  <b>&euro; (EURO)</b>
        </td>
         <td bgcolor="#FFFF99" height="5%"> 
		      <b><?php echo $dropdown; ?></b>
        </td>
        </tr>
        <tr>
          <td width="10" align="right" bgcolor="#FFFF99" height="3%">
          <b>1</b></td>
          <td width="526" align="left" bgcolor="#FFFF99" height="3%">
          Standard Sedimentation<b><a href="analyses.htm"> Analysis</a>
				   </b> (minimum of 10 samples) each.</td>
          <td width="63" align="right" bgcolor="#FFFFCC" height="3%">
						     <?php echo $this->products[0]->getPrice(); ?>						     
</td>
	  <td width="49" align="right" bgcolor="#FFFFCC" height="3%">
	  <?php echo $this->products[0]->getConvertedPrice() ?></td>
        </tr>
				   <tr>
          <td width="10" align="right" bgcolor="#FFFF99" height="5%"> 
           <b>2</b></td>
          <td width="526" align="left" bgcolor="#FFFF99" height="5%">
				   <b>SedVar &#0153; <b>Number Conversion &amp; Table Generation software;</b><br>useful for anybody.</td>
          <td width="63" align="right" bgcolor="#FFFFCC" height="5%">
	  <?php echo $this->products[1]->getPrice(); ?>
				      
</td>
          <td width="49" align="right" bgcolor="#FFFFCC" height="5%">
    <?php echo $this->products[1]->getConvertedPrice(); ?>

</td>
        </tr>
        <tr>
          <td width="10" align="right" bgcolor="#FFFF99" height="5%"><b>3</b></td>
          <td width="526" align="left" bgcolor="#FFFF99" height="5%">
          <b>SedVar &#0153; Distribution Processing software</b> of the ASCII files generated by the MacroGranometer &#0153; <i>(item 2 is included).</i></td>
 <td width="63" align="right" bgcolor="#FFFFCC" height="5%">     
 <?php echo $this->products[2]->getPrice(); ?>
 </td>
	<td width="49" align="right" bgcolor="#FFFFCC" height="5%">
      <?php echo $this->products[2]->getConvertedPrice(); ?>
     </td>
        </tr>
        <tr>
          <td width="10" align="right" bgcolor="#FFFF99" height="5%"><b>4</b></td>
          <td width="526" align="left" bgcolor="#FFFF99" height="5%">														 																			 <b>Shape &#0153; Program;</b> processes both the MacroGranometer &#0153;
    and sieving data (ASCII files).</td>
      <td width="63" align="right" bgcolor="#FFFFCC" height="5%">
            <?php echo $this->products[3]->getPrice(); ?>
      </td>
      <td width="49" align="right" bgcolor="#FFFFCC" height="5%">      <?php echo $this->products[3]->getConvertedPrice(); ?></td>
        </tr>
        <tr>
          <td width="10" align="right" bgcolor="#FFFF99" height="5%">
          <p style="margin-top: 0; margin-bottom: 0">
         <b>5</b></td>
          <td width="526" align="left" bgcolor="#FFFF99" height="5%">
      <p><b><i>Base &amp; Platform for item 6</i></b> (MacroGranometer's &#0153;)
           <i><b> or 7</b></i>
            (3S &#0153;)<i> includes installation, traveling
            &amp; transportation in Europe.</i>
            <p><i>Most University users may economically produce
            and install this option according to our CAD
          drawings and instructions.</i></td>
          <td width="63" align="right" bgcolor="#FFFFCC" height="5%"> 
      <?php echo $this->products[4]->getPrice(); ?>       
</td>
          <td width="49" align="right" bgcolor="#FFFFCC" height="5%">
                <?php echo $this->products[4]->getConvertedPrice(); ?>       </td>
        </tr>
        <tr>
          <td width="10" align="right" bgcolor="#FFFF99" height="5%"><b>6</b></td>
          <td width="526" align="left" bgcolor="#FFFF99" height="5%">
          <b><a href="analyzer.htm"> MacroGranometer &#0153; 2010</a>,complete analyzing system;</b>
          <i> includes the instrument's Measuring, Operation and Distribution Processing 
						       Software (SedVar</i>
								 <b>&#0153;</b><i>, item 3) but not the items 4 and 5</i>.</td>
                 <td width="63" align="right" bgcolor="#FFFFCC" height="5%"> 
      <?php echo $this->products[5]->getPrice(); ?>       
</td>
          <td width="49" align="right" bgcolor="#FFFFCC" height="5%">
						             <?php echo $this->products[5]->getConvertedPrice(); ?>       
						       </td>
        </tr>
        <tr>
          <td width="10" align="right" bgcolor="#FFFF99" height="5%"><b>7</b></td>
          <td width="526" align="left" bgcolor="#FFFF99" height="5%">
						       <b>Sand Sedimentation Separator 2010 (3S &#0153;),</b> 
          <i> complete separation system</i></span><i>.</i></font></td>
          <td width="63" align="right" bgcolor="#FFFFCC" height="5%"> 
	
    <?php echo $this->products[6]->getPrice(); ?>       

</td>
    <td width="49" align="right" bgcolor="#FFFFCC" height="5%" style="border-right-color: #111111; border-right-width: 1">
	    <?php echo $this->products[6]->getConvertedPrice(); ?>       
</td>
      <?php
  }
  
}
?>