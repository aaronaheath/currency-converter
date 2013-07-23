<?php

/* Standard routine to retrieve parameter values using GET or POST
 *
 * $Id: get_param.ph,v 1.2 2007/04/23 20:18:37 aheath Exp $ 
 *
 * $Log: get_param.ph,v $
 * Revision 1.2  2007/04/23 20:18:37  aheath
 * Initial entry.
 *
 * Revision 1.1.2.2  2007/04/23 20:15:10  aheath
 * Changed name of class to get_param.
 *
 * Revision 1.1.2.1  2007/04/19 19:29:13  aheath
 * Initial entry.
 *
 *
 */


class get_param {

    // get the value of the specified parameter and return
    // it without escape characters
   public static function get_parameter($parameter) {
      
     $value = $_GET[$parameter];
     if ($value == '') {
       $value = $_POST[$parameter];
     }
     return rawurldecode(stripslashes($value));
   }
}
?>
