<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_plc_01_ProductInsert.php
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/15/2017|nolliff|KACE:16787 - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('/var/www/sites/silicore/Includes/security.php');
require_once('/var/www/sites/silicore/Includes/Security/dbaccess.php');
require_once('/var/www/sites/silicore/Includes/emailfunctions.php');
require_once('/var/www/sites/silicore/Includes/Production/productionfunctions.php');

try
{
  $maxIdSQL = "CALL sp_gb_plc_ProductionMaxIdGet()";
  $maxIdResult = mysqli_query(dbmysqli(),$maxIdSQL);
  while($id= mysqli_fetch_array($maxIdResult))
  {
    $maxID = $id['maxId'];
  }
}
catch(Exception $ex)
{
  echo("Error: " .  __LINE__ . " " .$ex->getMessage());
}
if($maxID == "" or $maxID == null)
    {
      $maxID = 0;
    }
try
{
  $mssqlcon = mssqldb();
    

  
  $date = '2017-10-31';
//  $productsSql = "EXECUTE sp_gb_plc_ProductsByDateGet @date='" . $date . "'";
  
  $productsSql = 'EXECUTE sp_gb_plc_ProductsGet @id=' . $maxID;

  echo $productsSql;
  
  $products = sqlsrv_query($mssqlcon,$productsSql);
  
}
catch(Exception $e)
{
  echo "Error: ". __LINE__ . " " .$e->getMessage();
}

while($product = sqlsrv_fetch_array($products)) 
{
  $productId = 0;
  $tagId = 'null';
  $tag = $product['TotalDesc'];
//  echo $tag . "<br>";
  $analogTagSQL = "CALL sp_gb_plc_AnalogTagGet('" . $tag . "')";
  $prodIdSQL = "CALL sp_gb_plc_ProdProductsGet('" . $tag . "')";

  try
  {
   $analogTag= mysqli_query(dbmysqli(), $analogTagSQL);
  }
  catch(Exception $ex)
  {
    echo("Error: " .  __LINE__ . " " .$ex->getMessage());
  }
  
  while($anTag = mysqli_fetch_array($analogTag))
  {
    $tagId = $anTag['id'];
  }
  

	try
    {
     $productIdRes = mysqli_query(dbmysqli(), $prodIdSQL);
    }
  catch(Exception $ex)
    {
      echo("Error: " .  __LINE__ . " " .$ex->getMessage());
    }
    
	while($productTagID = mysqli_fetch_array($productIdRes))
  {
		$productId = $productTagID['id'];
	}
	
	$id = $product['Id'];
	$ptId = $product['PtId'];
	$shiftId = $product['ShiftId'];
	$value = $product['TotalVal'];
	$productType = $product['ProdType'];
  
  try
    {
      $mySqlProduct ='CALL sp_gb_plc_PlantProductShiftTagGet (' . $shiftId . ',' . $tagId . ',' . $productId . ')';
      $tagRes = mysqli_query(dbmysqli(),$mySqlProduct);
    }
  catch(Exception $ex)
    {
      echo("Error: " .  __LINE__ . " " .$ex->getMessage());
    }
  if (mysqli_num_rows($tagRes) == 0 && $value > 0) 
    {            
			try
        {
          $productInsertSQL = "call sp_gb_plc_ProductionInsert("
                              . $id . ","
                              . $shiftId. ","
                              . $value . "," 
                              . $tagId . ",'"
                              . $tag . "',"
                              . $productId . ",'"
                              . $productType . "')";
          echo $productInsertSQL . " 1 <br>";
          mysqli_query(dbmysqli(),$productInsertSQL);
        } 
			catch (Exception $ex) 
        {
          echo("Error: " .  __LINE__ . " " .$ex->getMessage());
        }
			
		} 
    else 
    {
      while($product2 = mysqli_fetch_array($tagRes))
        {
        //update the record
          try
            {
              if($value > 0)
                {
                  $productInsertSQL = "call sp_gb_plc_ProductionInsert("
                                      . $id . ","
                                      . $shiftId. ","
                                      . $value . "," 
                                      . $tagId . ",'"
                                      . $tag . "',"
                                      . $productId . ",'"
                                      . $productType . "')";
                  echo $productInsertSQL . " 2 <br>";
              
                }
              mysqli_query(dbmysqli(),$productInsertSQL);
            } 
          catch (Exception $ex) 
            {
              echo($ExceptionDump . $ex->getMessage());
            }
        }		
    }
}
//========================================================================================== END PHP
?>

<!-- HTML -->