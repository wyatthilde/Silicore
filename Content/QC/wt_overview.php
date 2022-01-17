<?php
/* * *****************************************************************************************************************************************
 * File Name: wt_overview.php
 * Project: Silicore
 * Description: This file allows the user to edit QC sample details.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 0?/0?/2017|mnutsch|KACE:? - Initial creation
 * 06/30/2017|mnutsch|KACE:17366 - Added new functionality
 * 07/11/2017|mnutsch|KACE:17366 - Continued development.
 * 07/13/2017|mnutsch|KACE:17366 - Added specific location functionality.
 * 07/14/2017|mnutsch|KACE:17366 - Continued development.
 * 07/21/2017|mnutsch|KACE:17366 - Redesigned the tables based on feedback.
 * 07/24/2017|mnutsch|KACE:17366 - Updated labels in the data blocks.
 * 07/26/2017|mnutsch|KACE:17366 - Fixed bugs related to date range values. Added new features.
 * 07/27/2017|mnutsch|KACE:17366 - Added the ability to select the date range for statistic values.
 * 08/02/2017|mnutsch|KACE:17366 - Modified a function call.
 * 08/29/2017|mnutsch|KACE:17957 - Updated code to only use the last completed sample; and to include sieves 11-18.
 * 09/14/2014|mnutsch|KACE:17957 - Updated file location and name references.
 * 10/04/2017|mnutsch|KACE:17957 - Added Specific Location boxes.
 * 10/25/2017|mnutsch|KACE:19254 - Updated formula calculations in the tables.
 * 10/26/2017|mnutsch|KACE:19259 - Updated the text color in the tables. 
 * 10/27/2017|mnutsch|KACE:19257 - Added the -70 +140 Sieve range.
 * 
 * **************************************************************************************************************************************** */

require_once('../../Includes/QC/wt_qcfunctions.php'); //contains QC database query functions

/*******************************************************************************
 * Function Name: renderSpecificLocationBox($argSpecificLocationID)
 * Description:
 * This function will render a report box about a give QC Specific Location.
 *
 ******************************************************************************/
function renderSpecificLocationBox($argSpecificLocationID, $argStartDate, $argEndDate, $argPlantID)
{
  $oversizeAvg = 0;
  $oversizeStd = 0;
  $plus40Avg = 0;
  $plus40Std = 0;
  $neg40Plus70Avg = 0;
  $neg40Plus70Std = 0;
  $neg60Plus70Avg = 0;
  $neg60Plus70Std = 0;
  $neg70Plus140Avg = 0;
  $neg70Plus140Std = 0;
  $neg50Plus140Avg = 0;
  $neg50Plus140Std = 0;
  $nearSizeAvg = 0;
  $nearSizeStd = 0;
  $neg140Plus325Avg = 0;
  $neg140Plus325Std = 0;
  $neg140Avg = 0;
  $neg140Std = 0;


  $oversizeAverages = 0;
  $plus40Averages = 0;
  $neg40Plus70Averages = 0;
  $neg60Plus70Averages = 0;
  $neg70Plus140Averages = 0;
  $neg50Plus140Averages = 0;
  $nearSizeAverages = 0;
  $neg140Plus325Averages = 0;
  $neg140Averages = 0;

    $oversizeStdDev = 0;
    $plus40StdDev = 0;
    $neg40Plus70StdDev = 0;
    $neg60Plus70StdDev = 0;
    $neg70Plus140StdDev = 0;
    $neg50Plus140StdDev = 0;
    $nearSizeStdDev = 0;
    $neg140Plus325StdDev = 0;
    $neg140StdDev = 0;

    $oversizeMaximums = 0;
    $plus40Maximums = 0;
    $neg40Plus70Maximums = 0;
    $neg60Plus70Maximums = 0;
    $neg70Plus140Maximums = 0;
    $neg50Plus140Maximums = 0;
    $nearSizeMaximums = 0;
    $neg140Plus325Maximums = 0;
    $neg140Maximums = 0;

    $oversizeMinimums = 0;
    $plus40Minimums = 0;
    $neg40Plus70Minimums = 0;
    $neg60Plus70Minimums = 0;
    $neg70Plus140Minimums = 0;
    $neg50Plus140Minimums = 0;
    $nearSizeMinimums = 0;
    $neg140Plus325Minimums = 0;
    $neg140Minimums = 0;
    
  //if the specific location ID is set 
  if($argSpecificLocationID != "")
  {
    $sampleObject = NULL;
    $sampleId = "";
    $sampleDate = "";
    $sampleTime = "";
    $arrayOfDateRangeAverages = NULL;
    $arrayOfDateRangeStdDev = NULL;

      $oversizeAvg = 0;
      $oversizeStd = 0;
      $plus40Avg = 0;
      $plus40Std = 0;
      $neg40Plus70Avg = 0;
      $neg40Plus70Std = 0;
      $neg60Plus70Avg = 0;
      $neg60Plus70Std = 0;
      $neg70Plus140Avg = 0;
      $neg70Plus140Std = 0;
      $neg50Plus140Avg = 0;
      $neg50Plus140Std = 0;
      $nearSizeAvg = 0;
      $nearSizeStd = 0;
      $neg140Plus325Avg = 0;
      $neg140Plus325Std = 0;
      $neg140Avg = 0;
      $neg140Std = 0;


        //get the most recent sample
        $sampleObject = getMostRecentSampleBySpecificLocation($argSpecificLocationID);
        //ar_dump($sampleObject);
        if($sampleObject != NULL)
        {
            $sampleId = $sampleObject->vars["id"];
            $sampleDate = $sampleObject->vars["date"];
            $sampleTime = $sampleObject->vars["time"];
            $specificLocationObject = getSpecificLocationByID($sampleObject->vars["specificLocation"]);
            $specificLocationDescription = "unknown";
            if($specificLocationObject != NULL)
            {
                $specificLocationDescription = $specificLocationObject->vars["description"];
            }
            $arrayOfDateRangeAverages = getDateRangePercentAveragesBySpecificLocation($argSpecificLocationID, $argStartDate, $argEndDate);
            $arrayOfDateRangeStdDev = getDateRangePercentStandardDeviationsBySpecificLocation($argSpecificLocationID, $argStartDate, $argEndDate);
            $arrayOfDateRangeMaximums = getDateRangePercentMaxBySpecificLocation($argSpecificLocationID, $argStartDate, $argEndDate);
            $arrayOfDateRangeMinimums = getDateRangePercentMinBySpecificLocation($argSpecificLocationID, $argStartDate, $argEndDate);
        }

        if($sampleObject != NULL)
        {

            echo "<div class='overviewTableSpecificLocation overviewTableSpecificLocationID" . $specificLocationObject->vars["qc_location_id"] , "' style='display:none;'>";
            echo "<table class='table table-striped table-bordered'>".
                "<tbody>" .
                "<tr><th colspan='6' class='sectionTitle'>Specific Location: " . $specificLocationDescription . "</th></tr>" .
                "<tr><th colspan='2' class='sectionTitle'>Latest Sample ID: <a href='wt_sampleview.php?sampleId=" . $sampleId . "' target='_blank'>" . $sampleId . "</a>".
                "<br/>Date Time: " .
                $sampleDate . " " . $sampleTime .
                "<br/><br/>" .
                "</th><th colspan='4' style='background-color: #eee;'>" .
                "Date Range Statistics:<br/>" .
                substr($argStartDate, 0, 10) .
                " through " .
                substr($argEndDate, 0, 10) . "</tr>" .
                "<tr><th style='background-color: #FFF;'>Description</th><th style='background-color: #FFF;'>Value</th><th style='background-color: #eee;'>Avg</th><th style='background-color: #eee;'>Std</th><th style='background-color: #eee;'>Max</th><th style='background-color: #eee;'>Min</th></tr>";

            //Building the string to output for the values. This is necessary, so that we can dynamically color the cell background based on values.
            //sieve1
            if($sampleObject->vars["sieve_1_desc"] != NULL)
            {
                $sieve1ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_1_desc"], $specificLocationObject->vars["qc_location_id"]);
                if($sampleObject->vars["sieve_1_value"] < $sieve1ThresholdCheckValue->vars["low_threshold"])
                {
                    $sieveValue1Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_1_value"],4) * 100) . "%</td>";
                }
                else
                    if($sampleObject->vars["sieve_1_value"] > $sieve1ThresholdCheckValue->vars["high_threshold"])
                    {
                        $sieveValue1Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_1_value"],4) * 100) . "%</td>";
                    }
                    else
                    {
                        $sieveValue1Output = "<td>" . (round($sampleObject->vars["sieve_1_value"],4) * 100) . "%</td>";
                    }
            }
            else
            {
                $sieveValue1Output = "<td>" . (round($sampleObject->vars["sieve_1_value"],4) * 100) . "%</td>";
            }

            //sieve2
            if($sampleObject->vars["sieve_2_desc"] != NULL)
            {
                $sieve2ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_2_desc"], $specificLocationObject->vars["qc_location_id"]);
                if($sampleObject->vars["sieve_2_value"] < $sieve2ThresholdCheckValue->vars["low_threshold"])
                {
                    $sieveValue2Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_2_value"],4) * 100) . "%</td>";
                }
                else
                    if($sampleObject->vars["sieve_2_value"] > $sieve2ThresholdCheckValue->vars["high_threshold"])
                    {
                        $sieveValue2Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_2_value"],4) * 100) . "%</td>";
                    }
                    else
                    {
                        $sieveValue2Output = "<td>" . (round($sampleObject->vars["sieve_2_value"],4) * 100) . "%</td>";
                    }
            }
            else
            {
                $sieveValue2Output = "<td>" . (round($sampleObject->vars["sieve_2_value"],4) * 100) . "%</td>";
            }

            //sieve3
            if($sampleObject->vars["sieve_3_desc"] != NULL)
            {
                $sieve3ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_3_desc"], $specificLocationObject->vars["qc_location_id"]);
                if($sampleObject->vars["sieve_3_value"] < $sieve3ThresholdCheckValue->vars["low_threshold"])
                {
                    $sieveValue3Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_3_value"],4) * 100) . "%</td>";
                }
                else
                    if($sampleObject->vars["sieve_3_value"] > $sieve3ThresholdCheckValue->vars["high_threshold"])
                    {
                        $sieveValue3Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_3_value"],4) * 100) . "%</td>";
                    }
                    else
                    {
                        $sieveValue3Output = "<td>" . (round($sampleObject->vars["sieve_3_value"],4) * 100) . "%</td>";
                    }
            }
            else
            {
                $sieveValue3Output = "<td>" . (round($sampleObject->vars["sieve_3_value"],4) * 100) . "%</td>";
            }

            //sieve4
            if($sampleObject->vars["sieve_4_desc"] != NULL)
            {
                $sieve4ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_4_desc"], $specificLocationObject->vars["qc_location_id"]);
                if($sampleObject->vars["sieve_4_value"] < $sieve4ThresholdCheckValue->vars["low_threshold"])
                {
                    $sieveValue4Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_4_value"],4) * 100) . "%</td>";
                }
                else
                    if($sampleObject->vars["sieve_4_value"] > $sieve4ThresholdCheckValue->vars["high_threshold"])
                    {
                        $sieveValue4Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_4_value"],4) * 100) . "%</td>";
                    }
                    else
                    {
                        $sieveValue4Output = "<td>" . (round($sampleObject->vars["sieve_4_value"],4) * 100) . "%</td>";
                    }
            }
            else
            {
                $sieveValue4Output = "<td>" . (round($sampleObject->vars["sieve_4_value"],4) * 100) . "%</td>";
            }

            //sieve5
            if($sampleObject->vars["sieve_5_desc"] != NULL)
            {
                $sieve5ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_5_desc"], $specificLocationObject->vars["qc_location_id"]);
                if($sampleObject->vars["sieve_5_value"] < $sieve5ThresholdCheckValue->vars["low_threshold"])
                {
                    $sieveValue5Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_5_value"],4) * 100) . "%</td>";
                }
                else
                    if($sampleObject->vars["sieve_5_value"] > $sieve5ThresholdCheckValue->vars["high_threshold"])
                    {
                        $sieveValue5Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_5_value"],4) * 100) . "%</td>";
                    }
                    else
                    {
                        $sieveValue5Output = "<td>" . (round($sampleObject->vars["sieve_5_value"],4) * 100) . "%</td>";
                    }
            }
            else
            {
                $sieveValue5Output = "<td>" . (round($sampleObject->vars["sieve_5_value"],4) * 100) . "%</td>";
            }

            //sieve6
            if($sampleObject->vars["sieve_6_desc"] != NULL)
            {
                $sieve6ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_6_desc"], $specificLocationObject->vars["qc_location_id"]);
                if($sampleObject->vars["sieve_6_value"] < $sieve6ThresholdCheckValue->vars["low_threshold"])
                {
                    $sieveValue6Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_6_value"],4) * 100) . "%</td>";
                }
                else
                    if($sampleObject->vars["sieve_6_value"] > $sieve6ThresholdCheckValue->vars["high_threshold"])
                    {
                        $sieveValue6Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_6_value"],4) * 100) . "%</td>";
                    }
                    else
                    {
                        $sieveValue6Output = "<td>" . (round($sampleObject->vars["sieve_6_value"],4) * 100) . "%</td>";
                    }
            }
            else
            {
                $sieveValue6Output = "<td>" . (round($sampleObject->vars["sieve_6_value"],4) * 100) . "%</td>";
            }

            //sieve7
            if($sampleObject->vars["sieve_7_desc"] != NULL)
            {
                $sieve7ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_7_desc"], $specificLocationObject->vars["qc_location_id"]);
                if($sampleObject->vars["sieve_7_value"] < $sieve7ThresholdCheckValue->vars["low_threshold"])
                {
                    $sieveValue7Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_7_value"],4) * 100) . "%</td>";
                }
                else
                    if($sampleObject->vars["sieve_7_value"] > $sieve7ThresholdCheckValue->vars["high_threshold"])
                    {
                        $sieveValue7Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_7_value"],4) * 100) . "%</td>";
                    }
                    else
                    {
                        $sieveValue7Output = "<td>" . (round($sampleObject->vars["sieve_7_value"],4) * 100) . "%</td>";
                    }
            }
            else
            {
                $sieveValue7Output = "<td>" . (round($sampleObject->vars["sieve_7_value"],4) * 100) . "%</td>";
            }

            //sieve8
            if($sampleObject->vars["sieve_8_desc"] != NULL)
            {
                $sieve8ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_8_desc"], $specificLocationObject->vars["qc_location_id"]);
                if($sampleObject->vars["sieve_8_value"] < $sieve8ThresholdCheckValue->vars["low_threshold"])
                {
                    $sieveValue8Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_8_value"],4) * 100) . "%</td>";
                }
                else
                    if($sampleObject->vars["sieve_8_value"] > $sieve8ThresholdCheckValue->vars["high_threshold"])
                    {
                        $sieveValue8Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_8_value"],4) * 100) . "%</td>";
                    }
                    else
                    {
                        $sieveValue8Output = "<td>" . (round($sampleObject->vars["sieve_8_value"],4) * 100) . "%</td>";
                    }
            }
            else
            {
                $sieveValue8Output = "<td>" . (round($sampleObject->vars["sieve_8_value"],4) * 100) . "%</td>";
            }

            //sieve9
            if($sampleObject->vars["sieve_9_desc"] != NULL)
            {
                $sieve9ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_9_desc"], $specificLocationObject->vars["qc_location_id"]);
                if($sampleObject->vars["sieve_9_value"] < $sieve9ThresholdCheckValue->vars["low_threshold"])
                {
                    $sieveValue9Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_9_value"],4) * 100) . "%</td>";
                }
                else
                    if($sampleObject->vars["sieve_9_value"] > $sieve9ThresholdCheckValue->vars["high_threshold"])
                    {
                        $sieveValue9Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_9_value"],4) * 100) . "%</td>";
                    }
                    else
                    {
                        $sieveValue9Output = "<td>" . (round($sampleObject->vars["sieve_9_value"],4) * 100) . "%</td>";
                    }
            }
            else
            {
                $sieveValue9Output = "<td>" . (round($sampleObject->vars["sieve_9_value"],4) * 100) . "%</td>";
            }

            //sieve10
            if($sampleObject->vars["sieve_10_desc"] != NULL)
            {
                $sieve10ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_10_desc"], $specificLocationObject->vars["qc_location_id"]);
                if($sampleObject->vars["sieve_10_value"] < $sieve10ThresholdCheckValue->vars["low_threshold"])
                {
                    $sieveValue10Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_10_value"],4) * 100) . "%</td>";
                }
                else
                    if($sampleObject->vars["sieve_10_value"] > $sieve10ThresholdCheckValue->vars["high_threshold"])
                    {
                        $sieveValue10Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_10_value"],4) * 100) . "%</td>";
                    }
                    else
                    {
                        $sieveValue10Output = "<td>" . (round($sampleObject->vars["sieve_10_value"],4) * 100) . "%</td>";
                    }
            }
            else
            {
                $sieveValue10Output = "<td>" . (round($sampleObject->vars["sieve_10_value"],4) * 100) . "%</td>";
            }

            //sieve11
            if(isset($sampleObject->vars["sieve_11_desc"]))
            {
                if($sampleObject->vars["sieve_11_desc"] != "")
                {
                    $sieve11ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_11_desc"], $specificLocationObject->vars["qc_location_id"]);
                    if($sampleObject->vars["sieve_11_value"] < $sieve11ThresholdCheckValue->vars["low_threshold"])
                    {
                        $sieveValue11Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_11_value"],4) * 100) . "%</td>";
                    }
                    else
                        if($sampleObject->vars["sieve_11_value"] > $sieve11ThresholdCheckValue->vars["high_threshold"])
                        {
                            $sieveValue11Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_11_value"],4) * 100) . "%</td>";
                        }
                        else
                        {
                            $sieveValue11Output = "<td>" . (round($sampleObject->vars["sieve_11_value"],4) * 100) . "%</td>";
                        }
                }
                else
                {
                    $sieveValue11Output = "<td>" . (round($sampleObject->vars["sieve_11_value"],4) * 100) . "%</td>";
                }
            }

            if(isset($sampleObject->vars["sieve_12_desc"]))
            {
                //sieve12
                if($sampleObject->vars["sieve_12_desc"] != "")
                {
                    $sieve12ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_12_desc"], $specificLocationObject->vars["qc_location_id"]);
                    if($sampleObject->vars["sieve_12_value"] < $sieve12ThresholdCheckValue->vars["low_threshold"])
                    {
                        $sieveValue12Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_12_value"],4) * 100) . "%</td>";
                    }
                    else
                        if($sampleObject->vars["sieve_12_value"] > $sieve12ThresholdCheckValue->vars["high_threshold"])
                        {
                            $sieveValue12Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_12_value"],4) * 100) . "%</td>";
                        }
                        else
                        {
                            $sieveValue12Output = "<td>" . (round($sampleObject->vars["sieve_12_value"],4) * 100) . "%</td>";
                        }
                }
                else
                {
                    $sieveValue12Output = "<td>" . (round($sampleObject->vars["sieve_12_value"],4) * 100) . "%</td>";
                }
            }

            if(isset($sampleObject->vars["sieve_13_desc"]))
            {
                //sieve13
                if($sampleObject->vars["sieve_13_desc"] != "")
                {
                    $sieve13ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_13_desc"], $specificLocationObject->vars["qc_location_id"]);
                    if($sampleObject->vars["sieve_13_value"] < $sieve13ThresholdCheckValue->vars["low_threshold"])
                    {
                        $sieveValue13Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_13_value"],4) * 100) . "%</td>";
                    }
                    else
                        if($sampleObject->vars["sieve_13_value"] > $sieve13ThresholdCheckValue->vars["high_threshold"])
                        {
                            $sieveValue13Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_13_value"],4) * 100) . "%</td>";
                        }
                        else
                        {
                            $sieveValue13Output = "<td>" . (round($sampleObject->vars["sieve_13_value"],4) * 100) . "%</td>";
                        }
                }
                else
                {
                    $sieveValue13Output = "<td>" . (round($sampleObject->vars["sieve_13_value"],4) * 100) . "%</td>";
                }
            }

            if(isset($sampleObject->vars["sieve_14_desc"]))
            {
                //sieve14
                if($sampleObject->vars["sieve_14_desc"] != "")
                {
                    $sieve14ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_14_desc"], $specificLocationObject->vars["qc_location_id"]);
                    if($sampleObject->vars["sieve_14_value"] < $sieve14ThresholdCheckValue->vars["low_threshold"])
                    {
                        $sieveValue14Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_14_value"],4) * 100) . "%</td>";
                    }
                    else
                        if($sampleObject->vars["sieve_14_value"] > $sieve14ThresholdCheckValue->vars["high_threshold"])
                        {
                            $sieveValue14Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_14_value"],4) * 100) . "%</td>";
                        }
                        else
                        {
                            $sieveValue14Output = "<td>" . (round($sampleObject->vars["sieve_14_value"],4) * 100) . "%</td>";
                        }
                }
                else
                {
                    $sieveValue14Output = "<td>" . (round($sampleObject->vars["sieve_14_value"],4) * 100) . "%</td>";
                }
            }

            if(isset($sampleObject->vars["sieve_15_desc"]))
            {
                //sieve15
                if($sampleObject->vars["sieve_15_desc"] != "")
                {
                    $sieve15ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_15_desc"], $specificLocationObject->vars["qc_location_id"]);
                    if($sampleObject->vars["sieve_15_value"] < $sieve15ThresholdCheckValue->vars["low_threshold"])
                    {
                        $sieveValue15Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_15_value"],4) * 100) . "%</td>";
                    }
                    else
                        if($sampleObject->vars["sieve_15_value"] > $sieve15ThresholdCheckValue->vars["high_threshold"])
                        {
                            $sieveValue15Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_15_value"],4) * 100) . "%</td>";
                        }
                        else
                        {
                            $sieveValue15Output = "<td>" . (round($sampleObject->vars["sieve_15_value"],4) * 100) . "%</td>";
                        }
                }
                else
                {
                    $sieveValue15Output = "<td>" . (round($sampleObject->vars["sieve_15_value"],4) * 100) . "%</td>";
                }
            }

            if(isset($sampleObject->vars["sieve_16_desc"]))
            {
                //sieve16
                if($sampleObject->vars["sieve_16_desc"] != "")
                {
                    $sieve16ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_16_desc"], $specificLocationObject->vars["qc_location_id"]);
                    if($sampleObject->vars["sieve_16_value"] < $sieve16ThresholdCheckValue->vars["low_threshold"])
                    {
                        $sieveValue16Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_16_value"],4) * 100) . "%</td>";
                    }
                    else
                        if($sampleObject->vars["sieve_16_value"] > $sieve16ThresholdCheckValue->vars["high_threshold"])
                        {
                            $sieveValue16Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_16_value"],4) * 100) . "%</td>";
                        }
                        else
                        {
                            $sieveValue16Output = "<td>" . (round($sampleObject->vars["sieve_16_value"],4) * 100) . "%</td>";
                        }
                }
                else
                {
                    $sieveValue16Output = "<td>" . (round($sampleObject->vars["sieve_16_value"],4) * 100) . "%</td>";
                }
            }

            if(isset($sampleObject->vars["sieve_17_desc"]))
            {
                //sieve17
                if($sampleObject->vars["sieve_17_desc"] != "")
                {
                    $sieve17ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_17_desc"], $specificLocationObject->vars["qc_location_id"]);
                    if($sampleObject->vars["sieve_17_value"] < $sieve17ThresholdCheckValue->vars["low_threshold"])
                    {
                        $sieveValue17Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_17_value"],4) * 100) . "%</td>";
                    }
                    else
                        if($sampleObject->vars["sieve_17_value"] > $sieve17ThresholdCheckValue->vars["high_threshold"])
                        {
                            $sieveValue17Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_17_value"],4) * 100) . "%</td>";
                        }
                        else
                        {
                            $sieveValue17Output = "<td>" . (round($sampleObject->vars["sieve_17_value"],4) * 100) . "%</td>";
                        }
                }
                else
                {
                    $sieveValue17Output = "<td>" . (round($sampleObject->vars["sieve_17_value"],4) * 100) . "%</td>";
                }
            }

            if(isset($sampleObject->vars["sieve_18_desc"]))
            {
                //sieve18
                if($sampleObject->vars["sieve_18_desc"] != "")
                {
                    $sieve18ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_18_desc"], $specificLocationObject->vars["qc_location_id"]);
                    if($sampleObject->vars["sieve_18_value"] < $sieve18ThresholdCheckValue->vars["low_threshold"])
                    {
                        $sieveValue18Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_18_value"],4) * 100) . "%</td>";
                    }
                    else
                        if($sampleObject->vars["sieve_18_value"] > $sieve18ThresholdCheckValue->vars["high_threshold"])
                        {
                            $sieveValue18Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_18_value"],4) * 100) . "%</td>";
                        }
                        else
                        {
                            $sieveValue18Output = "<td>" . (round($sampleObject->vars["sieve_18_value"],4) * 100) . "%</td>";
                        }
                }
                else
                {
                    $sieveValue18Output = "<td>" . (round($sampleObject->vars["sieve_18_value"],4) * 100) . "%</td>";
                }
            }



      /************************************************************************/
      //Output the table rows
      /************************************************************************/

            if(isset($sampleObject->vars["sieve_1_desc"]))
            {
                if((string)$sampleObject->vars["sieve_1_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_1_desc"] . "</td>" . $sieveValue1Output . "<td>" . (round($arrayOfDateRangeAverages[0],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[0],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[0],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[0],4) * 100) . "%" . "</td></tr>";
                }
            }

            if(isset($sampleObject->vars["sieve_2_desc"]))
            {
                if((string)$sampleObject->vars["sieve_2_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_2_desc"] . "</td>" . $sieveValue2Output . "<td>" . (round($arrayOfDateRangeAverages[1],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[1],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[1],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[1],4) * 100) . "%" . "</td></tr>";
                }
            }

            if(isset($sampleObject->vars["sieve_3_desc"]))
            {
                if((string)$sampleObject->vars["sieve_3_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_3_desc"] . "</td>" . $sieveValue3Output . "<td>" . (round($arrayOfDateRangeAverages[2],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[2],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[2],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[2],4) * 100) . "%" . "</td></tr>";
                }
            }

            if(isset($sampleObject->vars["sieve_4_desc"]))
            {
                if((string)$sampleObject->vars["sieve_4_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_4_desc"] . "</td>" . $sieveValue4Output . "<td>" . (round($arrayOfDateRangeAverages[3],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[3],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[3],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[3],4) * 100) . "%" . "</td></tr>";
                }
            }

            if(isset($sampleObject->vars["sieve_5_desc"]))
            {
                if((string)$sampleObject->vars["sieve_5_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_5_desc"] . "</td>" . $sieveValue5Output . "<td>" . (round($arrayOfDateRangeAverages[4],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[4],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[4],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[4],4) * 100) . "%" . "</td></tr>";
                }
            }

            if(isset($sampleObject->vars["sieve_6_desc"]))
            {
                if((string)$sampleObject->vars["sieve_6_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_6_desc"] . "</td>" . $sieveValue6Output . "<td>" . (round($arrayOfDateRangeAverages[5],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[5],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[5],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[5],4) * 100) . "%" . "</td></tr>";
                }
            }

            if(isset($sampleObject->vars["sieve_7_desc"]))
            {
                if((string)$sampleObject->vars["sieve_7_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_7_desc"] . "</td>" . $sieveValue7Output . "<td>" . (round($arrayOfDateRangeAverages[6],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[6],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[6],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[6],4) * 100) . "%" . "</td></tr>";
                }
            }

            if(isset($sampleObject->vars["sieve_8_desc"]))
            {
                if((string)$sampleObject->vars["sieve_8_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_8_desc"] . "</td>" . $sieveValue8Output . "<td>" . (round($arrayOfDateRangeAverages[7],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[7],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[7],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[7],4) * 100) . "%" . "</td></tr>";
                }
            }

            if(isset($sampleObject->vars["sieve_9_desc"]))
            {
                if((string)$sampleObject->vars["sieve_9_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_9_desc"] . "</td>" . $sieveValue9Output . "<td>" . (round($arrayOfDateRangeAverages[8],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[8],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[8],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[8],4) * 100) . "%" . "</td></tr>";
                }
            }

            if(isset($sampleObject->vars["sieve_10_desc"]))
            {
                if((string)$sampleObject->vars["sieve_10_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_10_desc"] . "</td>" . $sieveValue10Output . "<td>" . (round($arrayOfDateRangeAverages[9],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[9],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[9],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[9],4) * 100) . "%" . "</td></tr>";
                }
            }

            if(isset($sampleObject->vars["sieve_11_desc"]))
            {
                if((string)$sampleObject->vars["sieve_11_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_11_desc"] . "</td>" . $sieveValue11Output . "<td>" . (round($arrayOfDateRangeAverages[10],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[10],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[10],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[10],4) * 100) . "%" . "</td></tr>";
                }
            }

            if(isset($sampleObject->vars["sieve_12_desc"]))
            {
                if((string)$sampleObject->vars["sieve_12_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_12_desc"] . "</td>" . $sieveValue12Output . "<td>" . (round($arrayOfDateRangeAverages[11],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[11],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[11],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[11],4) * 100) . "%" . "</td></tr>";
                }
            }

            if(isset($sampleObject->vars["sieve_13_desc"]))
            {
                if((string)$sampleObject->vars["sieve_13_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_13_desc"] . "</td>" . $sieveValue13Output . "<td>" . (round($arrayOfDateRangeAverages[12],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[12],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[12],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[12],4) * 100) . "%" . "</td></tr>";
                }
            }

            if(isset($sampleObject->vars["sieve_14_desc"]))
            {
                if((string)$sampleObject->vars["sieve_14_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_14_desc"] . "</td>" . $sieveValue14Output . "<td>" . (round($arrayOfDateRangeAverages[13],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[13],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[13],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[13],4) * 100) . "%" . "</td></tr>";
                }
            }

            if(isset($sampleObject->vars["sieve_15_desc"]))
            {
                if((string)$sampleObject->vars["sieve_15_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_15_desc"] . "</td>" . $sieveValue15Output . "<td>" . (round($arrayOfDateRangeAverages[14],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[14],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[14],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[14],4) * 100) . "%" . "</td></tr>";
                }
            }

            if(isset($sampleObject->vars["sieve_16_desc"]))
            {
                if((string)$sampleObject->vars["sieve_16_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_16_desc"] . "</td>" . $sieveValue16Output . "<td>" . (round($arrayOfDateRangeAverages[15],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[15],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[15],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[15],4) * 100) . "%" . "</td></tr>";
                }
            }

            if(isset($sampleObject->vars["sieve_17_desc"]))
            {
                if((string)$sampleObject->vars["sieve_17_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_17_desc"] . "</td>" . $sieveValue17Output . "<td>" . (round($arrayOfDateRangeAverages[16],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[16],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[16],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[16],4) * 100) . "%" . "</td></tr>";
                }
            }
            if(isset($sampleObject->vars["sieve_18_desc"]))
            {
                if((string)$sampleObject->vars["sieve_18_desc"] != (string)"0")
                {
                    echo "<tr><td>" . $sampleObject->vars["sieve_18_desc"] . "</td>" . $sieveValue18Output . "<td>" . (round($arrayOfDateRangeAverages[17],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[17],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[17],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[17],4) * 100) . "%" . "</td></tr>";
                }
            }

            echo("<td colspan='6' class='sectionTitle'>Calculations</td>");

        $oversizeAverages = "n/a";
        $plus40Averages = "n/a";
        $neg40Plus70Averages = "n/a";
        $neg60Plus70Averages = "n/a";
        $neg70Plus140Averages = "n/a";
        $neg50Plus140Averages = "n/a";
        $nearSizeAverages = "n/a";
        $neg140Plus325Averages = "n/a";
        $neg140Averages = "n/a";
      
      if($arrayOfDateRangeAverages[18] != NULL)
      {
          $oversizeAverages = (round($arrayOfDateRangeAverages[18],4) * 100) . "%";
      }
      if($arrayOfDateRangeAverages[19] != NULL)
      {
          $plus40Averages = (round($arrayOfDateRangeAverages[19],4) * 100) . "%";
      }
      if($arrayOfDateRangeAverages[20] != NULL)
      {
          $neg40Plus70Averages = (round($arrayOfDateRangeAverages[20],4) * 100) . "%";
      }
      if($arrayOfDateRangeAverages[21] != NULL)
      {
          $neg60Plus70Averages = (round($arrayOfDateRangeAverages[21],4) * 100) . "%";
      }
      if($arrayOfDateRangeAverages[22] != NULL)
      {
          $neg70Plus140Averages = (round($arrayOfDateRangeAverages[22],4) * 100) . "%";
      }
        if($arrayOfDateRangeAverages[23] != NULL)
        {
            $neg50Plus140Averages = (round($arrayOfDateRangeAverages[23],4) * 100) . "%";
        }
        if($arrayOfDateRangeAverages[24] != NULL)
        {
            $nearSizeAverages = (round($arrayOfDateRangeAverages[24],4) * 100) . "%";
        }
        if($arrayOfDateRangeAverages[25] != NULL)
        {
            $neg140Plus325Averages = (round($arrayOfDateRangeAverages[25],4) * 100) . "%";
        }
        if($arrayOfDateRangeAverages[26] != NULL)
        {
            $neg140Averages = (round($arrayOfDateRangeAverages[26],4) * 100) . "%";
        }

        $oversizeStdDev = "n/a";
        $plus40StdDev = "n/a";
        $neg40Plus70StdDev = "n/a";
        $neg60Plus70StdDev = "n/a";
        $neg70Plus140StdDev = "n/a";
        $neg50Plus140StdDev = "n/a";
        $nearSizeStdDev = "n/a";
        $neg140Plus325StdDev = "n/a";
        $neg140StdDev = "n/a";
      
        if(isset($arrayOfDateRangeStdDev[18]))
        {
        if($arrayOfDateRangeStdDev[18] != NULL)
        {
            $oversizeStdDev = (round($arrayOfDateRangeStdDev[18],4) * 100) . "%";
        }
        }
        if(isset($arrayOfDateRangeStdDev[19]))
        {
        if($arrayOfDateRangeStdDev[19] != NULL)
        {
            $plus40StdDev = (round($arrayOfDateRangeStdDev[19],4) * 100) . "%";
        }
        }
        if(isset($arrayOfDateRangeStdDev[20]))
        {
        if($arrayOfDateRangeStdDev[20] != NULL)
        {
            $neg40Plus70StdDev = (round($arrayOfDateRangeStdDev[20],4) * 100) . "%";
        }
        }
        if(isset($arrayOfDateRangeStdDev[21]))
        {
        if($arrayOfDateRangeStdDev[21] != NULL)
        {
            $neg60Plus70StdDev = (round($arrayOfDateRangeStdDev[21],4) * 100) . "%";
        }
        }
        if(isset($arrayOfDateRangeStdDev[22]))
        {
        if($arrayOfDateRangeStdDev[22] != NULL)
        {
            $neg70Plus140StdDev = (round($arrayOfDateRangeStdDev[22],4) * 100) . "%";
        }
        }
        if(isset($arrayOfDateRangeStdDev[23]))
        {
            if($arrayOfDateRangeStdDev[23] != NULL)
            {
                $neg50Plus140StdDev = (round($arrayOfDateRangeStdDev[23],4) * 100) . "%";
            }
        }
        if(isset($arrayOfDateRangeStdDev[24]))
        {
            if($arrayOfDateRangeStdDev[24] != NULL)
            {
                $nearSizeStdDev = (round($arrayOfDateRangeStdDev[24],4) * 100) . "%";
            }
        }
        if(isset($arrayOfDateRangeStdDev[25]))
        {
            if($arrayOfDateRangeStdDev[25] != NULL)
            {
                $neg140Plus325StdDev = (round($arrayOfDateRangeStdDev[25],4) * 100) . "%";
            }
        }
        if(isset($arrayOfDateRangeStdDev[26]))
        {
            if($arrayOfDateRangeStdDev[26] != NULL)
            {
                $neg140StdDev = (round($arrayOfDateRangeStdDev[26],4) * 100) . "%";
            }
        }

        $oversizeMaximums = "n/a";
        $plus40Maximums = "n/a";
        $neg40Plus70Maximums = "n/a";
        $neg60Plus70Maximums = "n/a";
        $neg70Plus140Maximums = "n/a";
        $neg50Plus140Maximums = "n/a";
        $nearSizeMaximums = "n/a";
        $neg140Plus325Maximums = "n/a";
        $neg140Maximums = "n/a";
      
        if($arrayOfDateRangeMaximums[18] != NULL)
        {
        $oversizeMaximums = (round($arrayOfDateRangeMaximums[18],4) * 100) . "%";
        }
        if($arrayOfDateRangeMaximums[19] != NULL)
        {
        $plus40Maximums = (round($arrayOfDateRangeMaximums[19],4) * 100) . "%";
        }
        if($arrayOfDateRangeMaximums[20] != NULL)
        {
        $neg40Plus70Maximums = (round($arrayOfDateRangeMaximums[20],4) * 100) . "%";
        }
        if($arrayOfDateRangeMaximums[21] != NULL)
        {
        $neg60Plus70Maximums = (round($arrayOfDateRangeMaximums[21],4) * 100) . "%";
        }
        if($arrayOfDateRangeMaximums[22] != NULL)
        {
        $neg70Plus140Maximums = (round($arrayOfDateRangeMaximums[22],4) * 100) . "%";
        }
        if($arrayOfDateRangeMaximums[23] != NULL)
        {
            $neg50Plus140Maximums = (round($arrayOfDateRangeMaximums[23],4) * 100) . "%";
        }
        if($arrayOfDateRangeMaximums[24] != NULL)
        {
            $nearSizeMaximums = (round($arrayOfDateRangeMaximums[24],4) * 100) . "%";
        }
        if($arrayOfDateRangeMaximums[25] != NULL)
        {
            $neg140Plus325Maximums = (round($arrayOfDateRangeMaximums[25],4) * 100) . "%";
        }
        if($arrayOfDateRangeMaximums[26] != NULL)
        {
            $neg140Maximums = (round($arrayOfDateRangeMaximums[26],4) * 100) . "%";
        }


        $oversizeMinimums = "n/a";
        $plus40Minimums = "n/a";
        $neg40Plus70Minimums = "n/a";
        $neg60Plus70Minimums = "n/a";
        $neg70Plus140Minimums = "n/a";
        $neg50Plus140Minimums = "n/a";
        $nearSizeMinimums = "n/a";
        $neg140Plus325Minimums = "n/a";
        $neg140Minimums = "n/a";
      
        if($arrayOfDateRangeMinimums[18] != 1)
        {
            $oversizeMinimums = (round($arrayOfDateRangeMinimums[18],4) * 100) . "%";
        }
        if($arrayOfDateRangeMinimums[19] != 1)
        {
            $plus40Minimums = (round($arrayOfDateRangeMinimums[19],4) * 100) . "%";
        }
        if($arrayOfDateRangeMinimums[20] != 1)
        {
            $neg40Plus70Minimums = (round($arrayOfDateRangeMinimums[20],4) * 100) . "%";
        }
        if($arrayOfDateRangeMinimums[21] != 1)
        {
            $neg60Plus70Minimums = (round($arrayOfDateRangeMinimums[21],4) * 100) . "%";
        }
        if($arrayOfDateRangeMinimums[22] != 1)
        {
        $neg70Plus140Minimums = (round($arrayOfDateRangeMinimums[22],4) * 100) . "%";
        }
        if($arrayOfDateRangeMinimums[23] != 1)
        {
        $neg50Plus140Minimums = (round($arrayOfDateRangeMinimums[23],4) * 100) . "%";
        }
        if($arrayOfDateRangeMinimums[24] != 1)
        {
        $nearSizeMinimums = (round($arrayOfDateRangeMinimums[24],4) * 100) . "%";
        }
        if($arrayOfDateRangeMinimums[25] != 1)
        {
        $neg140Plus325Minimums = (round($arrayOfDateRangeMinimums[25],4) * 100) . "%";
        }
        if($arrayOfDateRangeMinimums[26] != 1)
        {
        $neg140Minimums = (round($arrayOfDateRangeMinimums[26],4) * 100) . "%";
        }

      echo "<tr><td>+10</td><td>" . ($sampleObject->vars["oversize_percent"] * 100) . "%" . "</td><td>" . $oversizeAverages . "</td><td>" . $oversizeStdDev . "</td><td>" . $oversizeMaximums . "</td><td>" . $oversizeMinimums . "</td></tr>";
      echo "<tr><td>-10+40</td><td>" . ($sampleObject->vars["plus_40"] * 100) . "%" . "</td><td>" . $plus40Averages . "</td><td>" . $plus40StdDev . "</td><td>" . $plus40Maximums . "</td><td>" . $plus40Minimums . "</td></tr>";
      echo "<tr><td>-40+70</td><td>" . ($sampleObject->vars["minus_40_plus_70"] * 100) . "%" . "</td><td>" . $neg40Plus70Averages . "</td><td>" . $neg40Plus70StdDev . "</td><td>" . $neg40Plus70Maximums . "</td><td>" . $neg40Plus70Minimums . "</td></tr>";
      echo "<tr><td>-60+70</td><td>" . ($sampleObject->vars["minus_60_plus_70"] * 100) . "%" . "</td><td>" . $neg60Plus70Averages . "</td><td>" . $neg60Plus70StdDev . "</td><td>" . $neg60Plus70Maximums . "</td><td>" . $neg60Plus70Minimums . "</td></tr>";
      echo "<tr><td>-70+140</td><td>" . ($sampleObject->vars["minus_70_plus_140"] * 100) . "%" . "</td><td>" . $neg70Plus140Averages . "</td><td>" . $neg70Plus140StdDev . "</td><td>" . $neg70Plus140Maximums . "</td><td>" . $neg70Plus140Minimums . "</td></tr>";      
      echo "<tr><td>-50+140</td><td>" . ($sampleObject->vars["minus_50_plus_140"] * 100) . "%" . "</td><td>" . $neg50Plus140Averages . "</td><td>" . $neg50Plus140StdDev . "</td><td>" . $neg50Plus140Maximums . "</td><td>" . $neg50Plus140Minimums . "</td></tr>";
      echo "<tr><td>Near Size</td><td>" . ($sampleObject->vars["near_size"] * 100) . "%" . "</td><td>" . $nearSizeAverages . "</td><td>" . $nearSizeStdDev . "</td><td>" . $nearSizeMaximums . "</td><td>" . $nearSizeMinimums . "</td></tr>";
      echo "<tr><td>-140+325</td><td>" . ($sampleObject->vars["minus_140_plus_325"] * 100) . "%" . "</td><td>" . $neg140Plus325Averages . "</td><td>" . $neg140Plus325StdDev . "</td><td>" . $neg140Plus325Maximums . "</td><td>" . $neg140Plus325Minimums . "</td></tr>";
      echo "<tr><td>-140</td><td>" . ($sampleObject->vars["minus_140"] * 100) . "%" . "</td><td>" . $neg140Averages . "</td><td>" . $neg140StdDev . "</td><td>" . $neg140Maximums . "</td><td>" . $neg140Minimums . "</td></tr>";

            echo "<tr><td>Moisture Rate</td><td>" . ($sampleObject->vars["moistureRate"] * 100) . "%" . "</td><td colspan='4' ></td></tr>";
            echo "<tr><td>Turbidity</td><td>" . ($sampleObject->vars["turbidity"]) . "</td><td colspan='4' ></td></tr>";
            echo("<td colspan='6' class='sectionTitle'>Plant Settings</td>");

            //dynamically display the PLC devices for this Plant, along with the values for this sample

            //get an array of items
            $plcArray = getKPIPLCTagsByPlantID($argPlantID);

            //iterate through the array and display a table row for each
            if(count($plcArray) > 0)
            {
                $objectCounter = 0;
                //for each device
                foreach ($plcArray as $plcObject)
                {
                    //check for a value in the database
                    $tagObject = "";
                    $tagObject = getPlantSettingsDataByTagAndSampleId($plcObject->vars["id"], $sampleId);

                    if($tagObject != NULL) //if there is already a value in the database for this tag and sample combination
                    {
                        //output the row with the value present
                        echo "<tr><td>" . $plcObject->vars["device"] . "</td><td>" . $tagObject->vars['value'] . "</td><td colspan='4'></td></tr>";
                    }
                    else
                    {
                        //output the row without a value
                        echo "<tr><td>" . $plcObject->vars["device"] . "</td><td></td><td colspan='4'></td></tr>";
                    }
                    $objectCounter++;
                }
            }
            else
            {
                echo "<tr><td colspan='6'>No KPI PLC Devices for this Specific Location</td></tr>";
            }

            echo "</tbody>" .
                "</table>";
            echo "</div>"; //overviewTable
        }
        else
        {
            //echo("No samples exist for specific location " . $argSpecificLocationID . ".<br/>");          
        }
    }

} //renderSpecificLocation()

?>

<!-- HTML -->

<link type="text/css" rel="stylesheet" href="../../Includes/qcstyles.css">
<link type="text/css" rel="stylesheet" href="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.css">
<script src="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.full.js"></script>

<div id="qc_groups" class="tabcontent">

    <h3>QC Overview</h3><br/>

    <?php
    $siteId = "";
    $plantId = "";
    $plantName = "";
    $specificLocationObject = NULL;

    $date30DaysPrior = date("Y-m-d", mktime(date("G"), date("i"), date("s"), date("m"), date("d")-30, date("Y")));
    $dateToday = date("Y-m-d", mktime(date("G"), date("i"), date("s"), date("m"), date("d"), date("Y")));

    //check if there is a GET variable for site
    if(isset($_GET['startDate']) && strlen($_GET['startDate']) > 1)
    {
        $startDate = urldecode(test_input($_GET['startDate']));
    }
    else
    {
        $startDate = $date30DaysPrior;
    }

    if(isset($_GET['endDate']) && strlen($_GET['endDate']) > 1)
    {
        $endDate = urldecode(test_input($_GET['endDate']));
    }
    else
    {
        $endDate = $dateToday;
    }

    if(isset($_GET['siteId']))
    {
        $siteId = test_input($_GET['siteId']);
        if($siteId == "")
        {
            //if the siteId parameter received is empty, then default it to west texas (ID # 10)
            $siteId = 60;
        }
    }
    else
    {
        //if there isn't a siteId parameter received, then default it to west texas (ID # 10)
        $siteId = 60;
    }

    //check if there is a GET variable for plant
    if(isset($_GET['plantId']))
    {
        $plantId = test_input($_GET['plantId']);
    }

    ?>

    <div class="form-group">
        <label for="start_date_filter">Start Date:</label>
        <input type="text" id="start_date_filter" name="start_date_filter" value="<?php echo $startDate; ?>" onchange="reloadPage();" autocomplete="off"/>
    </div>
    <br/>

    <div class="form-group">
        <label for="end_date_filter">End Date:</label>
        <input type="text" id="end_date_filter" name="end_date_filter" value="<?php echo $endDate; ?>" onchange="reloadPage();" autocomplete="off"/>
    </div>
    <br/>

    <div class="form-group">
        <label for="siteId">Site:</label>
        <select name="siteId" id="siteId" onchange="reloadPage();">
            <option value=""></option>
            <?php
            $siteObjectArray = getSites(); //get a list of site options
            foreach ($siteObjectArray as $siteObject)
            {
                if($siteObject->vars["id"] == $siteId)
                {
                    echo "<option value='" . $siteObject->vars["id"] . "' selected='selected'>" . $siteObject->vars["description"] . "</option>";
                }
                else
                {
                    echo "<option value='" . $siteObject->vars["id"] . "'>" . $siteObject->vars["description"] . "</option>";
                }
            }
            ?>
        </select>
    </div><br/>

    <div class="form-group">
        <label for="plantId">Plant:</label>
        <select name="plantId" id="plantId" onchange="reloadPage();">
            <option value=""></option>
            <?php
            $plantIsInList = 0;
            $plantObjectArray = getPlants(); //get a list of plant options
            foreach ($plantObjectArray as $plantObject)
            {
                if($plantObject->vars["site"] == $siteId) //only display sites for our plant
                {
                    if($plantObject->vars["id"] == $plantId)
                    {
                        echo "<option value='" . $plantObject->vars["id"] . "' selected='selected'>" . $plantObject->vars["description"] . "</option>";

                        //save the plant's name in a variable, so that we can display it later
                        $plantName = $plantObject->vars["description"];

                        //track if the plant received belongs to this site
                        $plantIsInList = 1;
                    }
                    else
                    {
                        echo "<option value='" . $plantObject->vars["id"] . "'>" . $plantObject->vars["description"] . "</option>";
                    }
                }
            }
            ?>
        </select>
    </div><br/>
    <hr>
    <?php

    //if plant is set AND it belongs to the selected site
    if(($plantId != "") && ($plantIsInList == 1))
    {
        echo "<h4>" . $plantName . "</h4>";

        //dynamically display charts for each location in the selected plant
        $arrayOfLocations = getLocations();
        $arrayLength = count($arrayOfLocations);

  $sampleObject = NULL;
  $sampleId = "";
  $sampleDate = "";
  $sampleTime = "";
  $arrayOfDateRangeAverages = NULL;
  $arrayOfDateRangeStdDev = NULL;
  
  echo "<div class='overviewTableWrapper' id='overviewTableWrapper'>";
  
  for($i = 0; $i < $arrayLength; $i++)
  {
    
    //variables for the new method of range calculation, added 9-8-2017 KACE # 18585
      $oversizeAvg = 0;
      $oversizeStd = 0;
      $plus40Avg = 0;
      $plus40Std = 0;
      $neg40Plus70Avg = 0;
      $neg40Plus70Std = 0;
      $neg60Plus70Avg = 0;
      $neg60Plus70Std = 0;
      $neg70Plus140Avg = 0;
      $neg70Plus140Std = 0;
      $neg50Plus140Avg = 0;
      $neg50Plus140Std = 0;
      $nearSizeAvg = 0;
      $nearSizeStd = 0;
      $neg140Plus325Avg = 0;
      $neg140Plus325Std = 0;
      $neg140Avg = 0;
      $neg140Std = 0;


      $oversizeAverages = 0;
      $plus40Averages = 0;
      $neg40Plus70Averages = 0;
      $neg60Plus70Averages = 0;
      $neg70Plus140Averages = 0;
      $neg50Plus140Averages = 0;
      $nearSizeAverages = 0;
      $neg140Plus325Averages = 0;
      $neg140Averages = 0;

      $oversizeStdDev = 0;
      $plus40StdDev = 0;
      $neg40Plus70StdDev = 0;
      $neg60Plus70StdDev = 0;
      $neg70Plus140StdDev = 0;
      $neg50Plus140StdDev = 0;
      $nearSizeStdDev = 0;
      $neg140Plus325StdDev = 0;
      $neg140StdDev = 0;

      $oversizeMaximums = 0;
      $plus40Maximums = 0;
      $neg40Plus70Maximums = 0;
      $neg60Plus70Maximums = 0;
      $neg70Plus140Maximums = 0;
      $neg50Plus140Maximums = 0;
      $nearSizeMaximums = 0;
      $neg140Plus325Maximums = 0;
      $neg140Maximums = 0;

      $oversizeMinimums = 0;
      $plus40Minimums = 0;
      $neg40Plus70Minimums = 0;
      $neg60Plus70Minimums = 0;
      $neg70Plus140Minimums = 0;
      $neg50Plus140Minimums = 0;
      $nearSizeMinimums = 0;
      $neg140Plus325Minimums = 0;
      $neg140Minimums = 0;
    if($arrayOfLocations[$i]->vars['plant'] == $plantId)
    {
      

                //get the most recent sample
                $sampleObject = getMostRecentSampleByLocation($arrayOfLocations[$i]->vars['id']);
                //ar_dump($sampleObject);
                if($sampleObject != NULL)
                {
                    $sampleId = $sampleObject->vars["id"];
                    $sampleDate = $sampleObject->vars["date"];
                    $sampleTime = $sampleObject->vars["time"];
                    $specificLocationObject = getSpecificLocationByID($sampleObject->vars["specificLocation"]);
                    $specificLocationDescription = "unknown";
                    if($specificLocationObject != NULL)
                    {
                        $specificLocationDescription = $specificLocationObject->vars["description"];
                    }
                    $arrayOfDateRangeAverages = getDateRangePercentAverages($arrayOfLocations[$i]->vars['id'], $startDate, $endDate);
                    $arrayOfDateRangeStdDev = getDateRangePercentStandardDeviations($arrayOfLocations[$i]->vars['id'], $startDate, $endDate);
                    $arrayOfDateRangeMaximums = getDateRangePercentMax($arrayOfLocations[$i]->vars['id'], $startDate, $endDate);
                    $arrayOfDateRangeMinimums = getDateRangePercentMin($arrayOfLocations[$i]->vars['id'], $startDate, $endDate);
                }

                if($sampleObject != NULL)
                {

                    echo "<div class='overviewTable'>";
                    echo "<table class='table table-striped table-bordered table-responsive'>".
                        "<tbody>" .
                        "<tr><th colspan='6' class='sectionTitle'>Location: " . $arrayOfLocations[$i]->vars['description'] . " <span class='toggleButton" . $arrayOfLocations[$i]->vars['id'] . "'><a href='#overviewTableWrapper' onclick='toggleSpecificLocations(" . $arrayOfLocations[$i]->vars['id'] . ");' id='toggleLink" . $arrayOfLocations[$i]->vars['id'] . "'>+</a></span></th></tr>" .
                        "<tr><th colspan='2' class='sectionTitle'>Latest Sample ID: <a href='wt_sampleview.php?sampleId=" . $sampleId . "' target='_blank'>" . $sampleId . "</a>".
                        "<br/>"  .
                        "Specific Location: " .
                        $specificLocationDescription .
                        "<br/>Date Time: " .
                        $sampleDate . " " . $sampleTime .
                        "</th><th colspan='4' style='background-color: #eee;'>" .
                        "Date Range Statistics:<br/>" .
                        substr($startDate, 0, 10) .
                        " through " .
                        substr($endDate, 0, 10) . "</tr>" .
                        "<tr><th style='background-color: #FFF;'>Description</th><th style='background-color: #FFF;'>Value</th><th style='background-color: #eee;'>Avg</th><th style='background-color: #eee;'>Std</th><th style='background-color: #eee;'>Max</th><th style='background-color: #eee;'>Min</th></tr>";

                    //Building the string to output for the values. This is necessary, so that we can dynamically color the cell background based on values.
                    //sieve1
                    if($sampleObject->vars["sieve_1_desc"] != NULL)
                    {
                        $sieve1ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_1_desc"], $arrayOfLocations[$i]->vars['id']);
                        if($sampleObject->vars["sieve_1_value"] < $sieve1ThresholdCheckValue->vars["low_threshold"])
                        {
                            $sieveValue1Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_1_value"],4) * 100) . "%</td>";
                        }
                        else
                            if($sampleObject->vars["sieve_1_value"] > $sieve1ThresholdCheckValue->vars["high_threshold"])
                            {
                                $sieveValue1Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_1_value"],4) * 100) . "%</td>";
                            }
                            else
                            {
                                $sieveValue1Output = "<td>" . (round($sampleObject->vars["sieve_1_value"],4) * 100) . "%</td>";
                            }
                    }
                    else
                    {
                        $sieveValue1Output = "<td>" . (round($sampleObject->vars["sieve_1_value"],4) * 100) . "%</td>";
                    }

                    //sieve2
                    if($sampleObject->vars["sieve_2_desc"] != NULL)
                    {
                        $sieve2ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_2_desc"], $arrayOfLocations[$i]->vars['id']);
                        if($sampleObject->vars["sieve_2_value"] < $sieve2ThresholdCheckValue->vars["low_threshold"])
                        {
                            $sieveValue2Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_2_value"],4) * 100) . "%</td>";
                        }
                        else
                            if($sampleObject->vars["sieve_2_value"] > $sieve2ThresholdCheckValue->vars["high_threshold"])
                            {
                                $sieveValue2Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_2_value"],4) * 100) . "%</td>";
                            }
                            else
                            {
                                $sieveValue2Output = "<td>" . (round($sampleObject->vars["sieve_2_value"],4) * 100) . "%</td>";
                            }
                    }
                    else
                    {
                        $sieveValue2Output = "<td>" . (round($sampleObject->vars["sieve_2_value"],4) * 100) . "%</td>";
                    }

                    //sieve3
                    if($sampleObject->vars["sieve_3_desc"] != NULL)
                    {
                        $sieve3ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_3_desc"], $arrayOfLocations[$i]->vars['id']);
                        if($sampleObject->vars["sieve_3_value"] < $sieve3ThresholdCheckValue->vars["low_threshold"])
                        {
                            $sieveValue3Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_3_value"],4) * 100) . "%</td>";
                        }
                        else
                            if($sampleObject->vars["sieve_3_value"] > $sieve3ThresholdCheckValue->vars["high_threshold"])
                            {
                                $sieveValue3Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_3_value"],4) * 100) . "%</td>";
                            }
                            else
                            {
                                $sieveValue3Output = "<td>" . (round($sampleObject->vars["sieve_3_value"],4) * 100) . "%</td>";
                            }
                    }
                    else
                    {
                        $sieveValue3Output = "<td>" . (round($sampleObject->vars["sieve_3_value"],4) * 100) . "%</td>";
                    }

                    //sieve4
                    if($sampleObject->vars["sieve_4_desc"] != NULL)
                    {
                        $sieve4ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_4_desc"], $arrayOfLocations[$i]->vars['id']);
                        if($sampleObject->vars["sieve_4_value"] < $sieve4ThresholdCheckValue->vars["low_threshold"])
                        {
                            $sieveValue4Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_4_value"],4) * 100) . "%</td>";
                        }
                        else
                            if($sampleObject->vars["sieve_4_value"] > $sieve4ThresholdCheckValue->vars["high_threshold"])
                            {
                                $sieveValue4Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_4_value"],4) * 100) . "%</td>";
                            }
                            else
                            {
                                $sieveValue4Output = "<td>" . (round($sampleObject->vars["sieve_4_value"],4) * 100) . "%</td>";
                            }
                    }
                    else
                    {
                        $sieveValue4Output = "<td>" . (round($sampleObject->vars["sieve_4_value"],4) * 100) . "%</td>";
                    }

                    //sieve5
                    if($sampleObject->vars["sieve_5_desc"] != NULL)
                    {
                        $sieve5ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_5_desc"], $arrayOfLocations[$i]->vars['id']);
                        if($sampleObject->vars["sieve_5_value"] < $sieve5ThresholdCheckValue->vars["low_threshold"])
                        {
                            $sieveValue5Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_5_value"],4) * 100) . "%</td>";
                        }
                        else
                            if($sampleObject->vars["sieve_5_value"] > $sieve5ThresholdCheckValue->vars["high_threshold"])
                            {
                                $sieveValue5Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_5_value"],4) * 100) . "%</td>";
                            }
                            else
                            {
                                $sieveValue5Output = "<td>" . (round($sampleObject->vars["sieve_5_value"],4) * 100) . "%</td>";
                            }
                    }
                    else
                    {
                        $sieveValue5Output = "<td>" . (round($sampleObject->vars["sieve_5_value"],4) * 100) . "%</td>";
                    }

                    //sieve6
                    if($sampleObject->vars["sieve_6_desc"] != NULL)
                    {
                        $sieve6ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_6_desc"], $arrayOfLocations[$i]->vars['id']);
                        if($sampleObject->vars["sieve_6_value"] < $sieve6ThresholdCheckValue->vars["low_threshold"])
                        {
                            $sieveValue6Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_6_value"],4) * 100) . "%</td>";
                        }
                        else
                            if($sampleObject->vars["sieve_6_value"] > $sieve6ThresholdCheckValue->vars["high_threshold"])
                            {
                                $sieveValue6Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_6_value"],4) * 100) . "%</td>";
                            }
                            else
                            {
                                $sieveValue6Output = "<td>" . (round($sampleObject->vars["sieve_6_value"],4) * 100) . "%</td>";
                            }
                    }
                    else
                    {
                        $sieveValue6Output = "<td>" . (round($sampleObject->vars["sieve_6_value"],4) * 100) . "%</td>";
                    }

                    //sieve7
                    if($sampleObject->vars["sieve_7_desc"] != NULL)
                    {
                        $sieve7ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_7_desc"], $arrayOfLocations[$i]->vars['id']);
                        if($sampleObject->vars["sieve_7_value"] < $sieve7ThresholdCheckValue->vars["low_threshold"])
                        {
                            $sieveValue7Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_7_value"],4) * 100) . "%</td>";
                        }
                        else
                            if($sampleObject->vars["sieve_7_value"] > $sieve7ThresholdCheckValue->vars["high_threshold"])
                            {
                                $sieveValue7Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_7_value"],4) * 100) . "%</td>";
                            }
                            else
                            {
                                $sieveValue7Output = "<td>" . (round($sampleObject->vars["sieve_7_value"],4) * 100) . "%</td>";
                            }
                    }
                    else
                    {
                        $sieveValue7Output = "<td>" . (round($sampleObject->vars["sieve_7_value"],4) * 100) . "%</td>";
                    }

                    //sieve8
                    if($sampleObject->vars["sieve_8_desc"] != NULL)
                    {
                        $sieve8ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_8_desc"], $arrayOfLocations[$i]->vars['id']);
                        if($sampleObject->vars["sieve_8_value"] < $sieve8ThresholdCheckValue->vars["low_threshold"])
                        {
                            $sieveValue8Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_8_value"],4) * 100) . "%</td>";
                        }
                        else
                            if($sampleObject->vars["sieve_8_value"] > $sieve8ThresholdCheckValue->vars["high_threshold"])
                            {
                                $sieveValue8Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_8_value"],4) * 100) . "%</td>";
                            }
                            else
                            {
                                $sieveValue8Output = "<td>" . (round($sampleObject->vars["sieve_8_value"],4) * 100) . "%</td>";
                            }
                    }
                    else
                    {
                        $sieveValue8Output = "<td>" . (round($sampleObject->vars["sieve_8_value"],4) * 100) . "%</td>";
                    }

                    //sieve9
                    if($sampleObject->vars["sieve_9_desc"] != NULL)
                    {
                        $sieve9ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_9_desc"], $arrayOfLocations[$i]->vars['id']);
                        if($sampleObject->vars["sieve_9_value"] < $sieve9ThresholdCheckValue->vars["low_threshold"])
                        {
                            $sieveValue9Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_9_value"],4) * 100) . "%</td>";
                        }
                        else
                            if($sampleObject->vars["sieve_9_value"] > $sieve9ThresholdCheckValue->vars["high_threshold"])
                            {
                                $sieveValue9Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_9_value"],4) * 100) . "%</td>";
                            }
                            else
                            {
                                $sieveValue9Output = "<td>" . (round($sampleObject->vars["sieve_9_value"],4) * 100) . "%</td>";
                            }
                    }
                    else
                    {
                        $sieveValue9Output = "<td>" . (round($sampleObject->vars["sieve_9_value"],4) * 100) . "%</td>";
                    }

          //sieve10
          if($sampleObject->vars["sieve_10_desc"] != NULL)
          {
            $sieve10ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_10_desc"], $arrayOfLocations[$i]->vars['id']);
            if($sampleObject->vars["sieve_10_value"] < $sieve10ThresholdCheckValue->vars["low_threshold"])
            {
              $sieveValue10Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_10_value"],4) * 100) . "%</td>";
            }
            else
            if($sampleObject->vars["sieve_10_value"] > $sieve10ThresholdCheckValue->vars["high_threshold"])
            {
              $sieveValue10Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_10_value"],4) * 100) . "%</td>";
            }
            else
            {
              $sieveValue10Output = "<td>" . (round($sampleObject->vars["sieve_10_value"],4) * 100) . "%</td>";
            }
          }
          else
          {
            $sieveValue10Output = "<td>" . (round($sampleObject->vars["sieve_10_value"],4) * 100) . "%</td>";
          }
          
          //sieve11
          if(isset($sampleObject->vars["sieve_11_desc"]))
          {
            if($sampleObject->vars["sieve_11_desc"] != "")
            {
              $sieve11ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_11_desc"], $arrayOfLocations[$i]->vars['id']);
              if($sampleObject->vars["sieve_11_value"] < $sieve11ThresholdCheckValue->vars["low_threshold"])
              {
                $sieveValue11Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_11_value"],4) * 100) . "%</td>";
              }
              else
              if($sampleObject->vars["sieve_11_value"] > $sieve11ThresholdCheckValue->vars["high_threshold"])
              {
                $sieveValue11Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_11_value"],4) * 100) . "%</td>";
              }
              else
              {
                $sieveValue11Output = "<td>" . (round($sampleObject->vars["sieve_11_value"],4) * 100) . "%</td>";
              }
            }
            else
            {
              $sieveValue11Output = "<td>" . (round($sampleObject->vars["sieve_11_value"],4) * 100) . "%</td>";
            }
          }
          
          if(isset($sampleObject->vars["sieve_12_desc"]))
          {
            //sieve12
            if($sampleObject->vars["sieve_12_desc"] != "")
            {
              $sieve12ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_12_desc"], $arrayOfLocations[$i]->vars['id']);
              if($sampleObject->vars["sieve_12_value"] < $sieve12ThresholdCheckValue->vars["low_threshold"])
              {
                $sieveValue12Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_12_value"],4) * 100) . "%</td>";
              }
              else
              if($sampleObject->vars["sieve_12_value"] > $sieve12ThresholdCheckValue->vars["high_threshold"])
              {
                $sieveValue12Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_12_value"],4) * 100) . "%</td>";
              }
              else
              {
                $sieveValue12Output = "<td>" . (round($sampleObject->vars["sieve_12_value"],4) * 100) . "%</td>";
              }
            }
            else
            {
              $sieveValue12Output = "<td>" . (round($sampleObject->vars["sieve_12_value"],4) * 100) . "%</td>";
            }
          }
          
          if(isset($sampleObject->vars["sieve_13_desc"]))
          {
            //sieve13
            if($sampleObject->vars["sieve_13_desc"] != "")
            {
              $sieve13ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_13_desc"], $arrayOfLocations[$i]->vars['id']);
              if($sampleObject->vars["sieve_13_value"] < $sieve13ThresholdCheckValue->vars["low_threshold"])
              {
                $sieveValue13Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_13_value"],4) * 100) . "%</td>";
              }
              else
              if($sampleObject->vars["sieve_13_value"] > $sieve13ThresholdCheckValue->vars["high_threshold"])
              {
                $sieveValue13Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_13_value"],4) * 100) . "%</td>";
              }
              else
              {
                $sieveValue13Output = "<td>" . (round($sampleObject->vars["sieve_13_value"],4) * 100) . "%</td>";
              }
            }
            else
            {
              $sieveValue13Output = "<td>" . (round($sampleObject->vars["sieve_13_value"],4) * 100) . "%</td>";
            }
          }
          
          if(isset($sampleObject->vars["sieve_14_desc"]))
          {
            //sieve14
            if($sampleObject->vars["sieve_14_desc"] != "")
            {
              $sieve14ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_14_desc"], $arrayOfLocations[$i]->vars['id']);
              if($sampleObject->vars["sieve_14_value"] < $sieve14ThresholdCheckValue->vars["low_threshold"])
              {
                $sieveValue14Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_14_value"],4) * 100) . "%</td>";
              }
              else
              if($sampleObject->vars["sieve_14_value"] > $sieve14ThresholdCheckValue->vars["high_threshold"])
              {
                $sieveValue14Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_14_value"],4) * 100) . "%</td>";
              }
              else
              {
                $sieveValue14Output = "<td>" . (round($sampleObject->vars["sieve_14_value"],4) * 100) . "%</td>";
              }
            }
            else
            {
              $sieveValue14Output = "<td>" . (round($sampleObject->vars["sieve_14_value"],4) * 100) . "%</td>";
            }
          }
          
          if(isset($sampleObject->vars["sieve_15_desc"]))
          {
            //sieve15
            if($sampleObject->vars["sieve_15_desc"] != "")
            {
              $sieve15ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_15_desc"], $arrayOfLocations[$i]->vars['id']);
              if($sampleObject->vars["sieve_15_value"] < $sieve15ThresholdCheckValue->vars["low_threshold"])
              {
                $sieveValue15Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_15_value"],4) * 100) . "%</td>";
              }
              else
              if($sampleObject->vars["sieve_15_value"] > $sieve15ThresholdCheckValue->vars["high_threshold"])
              {
                $sieveValue15Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_15_value"],4) * 100) . "%</td>";
              }
              else
              {
                $sieveValue15Output = "<td>" . (round($sampleObject->vars["sieve_15_value"],4) * 100) . "%</td>";
              }
            }
            else
            {
              $sieveValue15Output = "<td>" . (round($sampleObject->vars["sieve_15_value"],4) * 100) . "%</td>";
            }
          }
          
          if(isset($sampleObject->vars["sieve_16_desc"]))
          {
            //sieve16
            if($sampleObject->vars["sieve_16_desc"] != "")
            {
              $sieve16ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_16_desc"], $arrayOfLocations[$i]->vars['id']);
              if($sampleObject->vars["sieve_16_value"] < $sieve16ThresholdCheckValue->vars["low_threshold"])
              {
                $sieveValue16Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_16_value"],4) * 100) . "%</td>";
              }
              else
              if($sampleObject->vars["sieve_16_value"] > $sieve16ThresholdCheckValue->vars["high_threshold"])
              {
                $sieveValue16Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_16_value"],4) * 100) . "%</td>";
              }
              else
              {
                $sieveValue16Output = "<td>" . (round($sampleObject->vars["sieve_16_value"],4) * 100) . "%</td>";
              }
            }
            else
            {
              $sieveValue16Output = "<td>" . (round($sampleObject->vars["sieve_16_value"],4) * 100) . "%</td>";
            }
          }
          
          if(isset($sampleObject->vars["sieve_17_desc"]))
          {
            //sieve17
            if($sampleObject->vars["sieve_17_desc"] != "")
            {
              $sieve17ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_17_desc"], $arrayOfLocations[$i]->vars['id']);
              if($sampleObject->vars["sieve_17_value"] < $sieve17ThresholdCheckValue->vars["low_threshold"])
              {
                $sieveValue17Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_17_value"],4) * 100) . "%</td>";
              }
              else
              if($sampleObject->vars["sieve_17_value"] > $sieve17ThresholdCheckValue->vars["high_threshold"])
              {
                $sieveValue17Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_17_value"],4) * 100) . "%</td>";
              }
              else
              {
                $sieveValue17Output = "<td>" . (round($sampleObject->vars["sieve_17_value"],4) * 100) . "%</td>";
              }
            }
            else
            {
              $sieveValue17Output = "<td>" . (round($sampleObject->vars["sieve_17_value"],4) * 100) . "%</td>";
            }
          }
          
          if(isset($sampleObject->vars["sieve_18_desc"]))
          {
            //sieve18
            if($sampleObject->vars["sieve_18_desc"] != "")
            {
              $sieve18ThresholdCheckValue = getQCThresholds($sampleObject->vars["sieve_18_desc"], $arrayOfLocations[$i]->vars['id']);
              if($sampleObject->vars["sieve_18_value"] < $sieve18ThresholdCheckValue->vars["low_threshold"])
              {
                $sieveValue18Output = "<td bgcolor='#FF0000'>" . (round($sampleObject->vars["sieve_18_value"],4) * 100) . "%</td>";
              }
              else
              if($sampleObject->vars["sieve_18_value"] > $sieve18ThresholdCheckValue->vars["high_threshold"])
              {
                $sieveValue18Output = "<td bgcolor='00FF00'>" . (round($sampleObject->vars["sieve_18_value"],4) * 100) . "%</td>";
              }
              else
              {
                $sieveValue18Output = "<td>" . (round($sampleObject->vars["sieve_18_value"],4) * 100) . "%</td>";
              }
            }
            else
            {
              $sieveValue18Output = "<td>" . (round($sampleObject->vars["sieve_18_value"],4) * 100) . "%</td>";
            }
          }
          

                    /************************************************************************/
                    //Output the table rows
                    /************************************************************************/

                    if(isset($sampleObject->vars["sieve_1_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_1_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_1_desc"] . "</td>" . $sieveValue1Output . "<td>" . (round($arrayOfDateRangeAverages[0],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[0],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[0],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[0],4) * 100) . "%" . "</td></tr>";
                        }
                    }

                    if(isset($sampleObject->vars["sieve_2_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_2_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_2_desc"] . "</td>" . $sieveValue2Output . "<td>" . (round($arrayOfDateRangeAverages[1],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[1],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[1],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[1],4) * 100) . "%" . "</td></tr>";
                        }
                    }

                    if(isset($sampleObject->vars["sieve_3_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_3_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_3_desc"] . "</td>" . $sieveValue3Output . "<td>" . (round($arrayOfDateRangeAverages[2],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[2],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[2],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[2],4) * 100) . "%" . "</td></tr>";
                        }
                    }

                    if(isset($sampleObject->vars["sieve_4_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_4_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_4_desc"] . "</td>" . $sieveValue4Output . "<td>" . (round($arrayOfDateRangeAverages[3],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[3],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[3],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[3],4) * 100) . "%" . "</td></tr>";
                        }
                    }

                    if(isset($sampleObject->vars["sieve_5_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_5_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_5_desc"] . "</td>" . $sieveValue5Output . "<td>" . (round($arrayOfDateRangeAverages[4],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[4],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[4],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[4],4) * 100) . "%" . "</td></tr>";
                        }
                    }

                    if(isset($sampleObject->vars["sieve_6_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_6_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_6_desc"] . "</td>" . $sieveValue6Output . "<td>" . (round($arrayOfDateRangeAverages[5],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[5],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[5],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[5],4) * 100) . "%" . "</td></tr>";
                        }
                    }

                    if(isset($sampleObject->vars["sieve_7_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_7_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_7_desc"] . "</td>" . $sieveValue7Output . "<td>" . (round($arrayOfDateRangeAverages[6],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[6],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[6],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[6],4) * 100) . "%" . "</td></tr>";
                        }
                    }

                    if(isset($sampleObject->vars["sieve_8_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_8_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_8_desc"] . "</td>" . $sieveValue8Output . "<td>" . (round($arrayOfDateRangeAverages[7],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[7],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[7],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[7],4) * 100) . "%" . "</td></tr>";
                        }
                    }

                    if(isset($sampleObject->vars["sieve_9_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_9_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_9_desc"] . "</td>" . $sieveValue9Output . "<td>" . (round($arrayOfDateRangeAverages[8],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[8],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[8],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[8],4) * 100) . "%" . "</td></tr>";
                        }
                    }

                    if(isset($sampleObject->vars["sieve_10_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_10_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_10_desc"] . "</td>" . $sieveValue10Output . "<td>" . (round($arrayOfDateRangeAverages[9],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[9],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[9],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[9],4) * 100) . "%" . "</td></tr>";
                        }
                    }

                    if(isset($sampleObject->vars["sieve_11_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_11_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_11_desc"] . "</td>" . $sieveValue11Output . "<td>" . (round($arrayOfDateRangeAverages[10],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[10],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[10],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[10],4) * 100) . "%" . "</td></tr>";
                        }
                    }

                    if(isset($sampleObject->vars["sieve_12_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_12_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_12_desc"] . "</td>" . $sieveValue12Output . "<td>" . (round($arrayOfDateRangeAverages[11],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[11],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[11],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[11],4) * 100) . "%" . "</td></tr>";
                        }
                    }

                    if(isset($sampleObject->vars["sieve_13_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_13_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_13_desc"] . "</td>" . $sieveValue13Output . "<td>" . (round($arrayOfDateRangeAverages[12],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[12],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[12],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[12],4) * 100) . "%" . "</td></tr>";
                        }
                    }

                    if(isset($sampleObject->vars["sieve_14_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_14_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_14_desc"] . "</td>" . $sieveValue14Output . "<td>" . (round($arrayOfDateRangeAverages[13],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[13],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[13],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[13],4) * 100) . "%" . "</td></tr>";
                        }
                    }

                    if(isset($sampleObject->vars["sieve_15_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_15_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_15_desc"] . "</td>" . $sieveValue15Output . "<td>" . (round($arrayOfDateRangeAverages[14],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[14],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[14],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[14],4) * 100) . "%" . "</td></tr>";
                        }
                    }

                    if(isset($sampleObject->vars["sieve_16_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_16_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_16_desc"] . "</td>" . $sieveValue16Output . "<td>" . (round($arrayOfDateRangeAverages[15],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[15],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[15],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[15],4) * 100) . "%" . "</td></tr>";
                        }
                    }

                    if(isset($sampleObject->vars["sieve_17_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_17_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_17_desc"] . "</td>" . $sieveValue17Output . "<td>" . (round($arrayOfDateRangeAverages[16],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[16],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[16],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[16],4) * 100) . "%" . "</td></tr>";
                        }
                    }
                    if(isset($sampleObject->vars["sieve_18_desc"]))
                    {
                        if((string)$sampleObject->vars["sieve_18_desc"] != (string)"0")
                        {
                            echo "<tr><td>" . $sampleObject->vars["sieve_18_desc"] . "</td>" . $sieveValue18Output . "<td>" . (round($arrayOfDateRangeAverages[17],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeStdDev[17],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMaximums[17],4) * 100) . "%" . "</td><td>" . (round($arrayOfDateRangeMinimums[17],4) * 100) . "%" . "</td></tr>";
                        }
                    }

                    echo("<td colspan='6' class='sectionTitle'>Calculations</td>");

            $oversizeAverages = "n/a";
            $plus40Averages = "n/a";
            $neg40Plus70Averages = "n/a";
            $neg60Plus70Averages = "n/a";
            $neg70Plus140Averages = "n/a";
            $neg50Plus140Averages = "n/a";
            $nearSizeAverages = "n/a";
            $neg140Plus325Averages = "n/a";
            $neg140Averages = "n/a";

            if($arrayOfDateRangeAverages[18] != NULL)
            {
                $oversizeAverages = (round($arrayOfDateRangeAverages[18],4) * 100) . "%";
            }
            if($arrayOfDateRangeAverages[19] != NULL)
            {
                $plus40Averages = (round($arrayOfDateRangeAverages[19],4) * 100) . "%";
            }
            if($arrayOfDateRangeAverages[20] != NULL)
            {
                $neg40Plus70Averages = (round($arrayOfDateRangeAverages[20],4) * 100) . "%";
            }
            if($arrayOfDateRangeAverages[21] != NULL)
            {
                $neg60Plus70Averages = (round($arrayOfDateRangeAverages[21],4) * 100) . "%";
            }
            if($arrayOfDateRangeAverages[22] != NULL)
            {
                $neg70Plus140Averages = (round($arrayOfDateRangeAverages[22],4) * 100) . "%";
            }
            if($arrayOfDateRangeAverages[23] != NULL)
            {
                $neg50Plus140Averages = (round($arrayOfDateRangeAverages[23],4) * 100) . "%";
            }
            if($arrayOfDateRangeAverages[24] != NULL)
            {
                $nearSizeAverages = (round($arrayOfDateRangeAverages[24],4) * 100) . "%";
            }
            if($arrayOfDateRangeAverages[25] != NULL)
            {
                $neg140Plus325Averages = (round($arrayOfDateRangeAverages[25],4) * 100) . "%";
            }
            if($arrayOfDateRangeAverages[26] != NULL)
            {
                $neg140Averages = (round($arrayOfDateRangeAverages[26],4) * 100) . "%";
            }

            $oversizeStdDev = "n/a";
            $plus40StdDev = "n/a";
            $neg40Plus70StdDev = "n/a";
            $neg60Plus70StdDev = "n/a";
            $neg70Plus140StdDev = "n/a";
            $neg50Plus140StdDev = "n/a";
            $nearSizeStdDev = "n/a";
            $neg140Plus325StdDev = "n/a";
            $neg140StdDev = "n/a";

            if(isset($arrayOfDateRangeStdDev[18]))
            {
                if($arrayOfDateRangeStdDev[18] != NULL)
                {
                    $oversizeStdDev = (round($arrayOfDateRangeStdDev[18],4) * 100) . "%";
                }
            }
            if(isset($arrayOfDateRangeStdDev[19]))
            {
                if($arrayOfDateRangeStdDev[19] != NULL)
                {
                    $plus40StdDev = (round($arrayOfDateRangeStdDev[19],4) * 100) . "%";
                }
            }
            if(isset($arrayOfDateRangeStdDev[20]))
            {
                if($arrayOfDateRangeStdDev[20] != NULL)
                {
                    $neg40Plus70StdDev = (round($arrayOfDateRangeStdDev[20],4) * 100) . "%";
                }
            }
            if(isset($arrayOfDateRangeStdDev[21]))
            {
                if($arrayOfDateRangeStdDev[21] != NULL)
                {
                    $neg60Plus70StdDev = (round($arrayOfDateRangeStdDev[21],4) * 100) . "%";
                }
            }
            if(isset($arrayOfDateRangeStdDev[22]))
            {
                if($arrayOfDateRangeStdDev[22] != NULL)
                {
                    $neg70Plus140StdDev = (round($arrayOfDateRangeStdDev[22],4) * 100) . "%";
                }
            }
            if(isset($arrayOfDateRangeStdDev[23]))
            {
                if($arrayOfDateRangeStdDev[23] != NULL)
                {
                    $neg50Plus140StdDev = (round($arrayOfDateRangeStdDev[23],4) * 100) . "%";
                }
            }
            if(isset($arrayOfDateRangeStdDev[24]))
            {
                if($arrayOfDateRangeStdDev[24] != NULL)
                {
                    $nearSizeStdDev = (round($arrayOfDateRangeStdDev[24],4) * 100) . "%";
                }
            }
            if(isset($arrayOfDateRangeStdDev[25]))
            {
                if($arrayOfDateRangeStdDev[25] != NULL)
                {
                    $neg140Plus325StdDev = (round($arrayOfDateRangeStdDev[25],4) * 100) . "%";
                }
            }
            if(isset($arrayOfDateRangeStdDev[26]))
            {
                if($arrayOfDateRangeStdDev[26] != NULL)
                {
                    $neg140StdDev = (round($arrayOfDateRangeStdDev[26],4) * 100) . "%";
                }
            }

            $oversizeMaximums = "n/a";
            $plus40Maximums = "n/a";
            $neg40Plus70Maximums = "n/a";
            $neg60Plus70Maximums = "n/a";
            $neg70Plus140Maximums = "n/a";
            $neg50Plus140Maximums = "n/a";
            $nearSizeMaximums = "n/a";
            $neg140Plus325Maximums = "n/a";
            $neg140Maximums = "n/a";

            if($arrayOfDateRangeMaximums[18] != NULL)
            {
                $oversizeMaximums = (round($arrayOfDateRangeMaximums[18],4) * 100) . "%";
            }
            if($arrayOfDateRangeMaximums[19] != NULL)
            {
                $plus40Maximums = (round($arrayOfDateRangeMaximums[19],4) * 100) . "%";
            }
            if($arrayOfDateRangeMaximums[20] != NULL)
            {
                $neg40Plus70Maximums = (round($arrayOfDateRangeMaximums[20],4) * 100) . "%";
            }
            if($arrayOfDateRangeMaximums[21] != NULL)
            {
                $neg60Plus70Maximums = (round($arrayOfDateRangeMaximums[21],4) * 100) . "%";
            }
            if($arrayOfDateRangeMaximums[22] != NULL)
            {
                $neg70Plus140Maximums = (round($arrayOfDateRangeMaximums[22],4) * 100) . "%";
            }
            if($arrayOfDateRangeMaximums[23] != NULL)
            {
                $neg50Plus140Maximums = (round($arrayOfDateRangeMaximums[23],4) * 100) . "%";
            }
            if($arrayOfDateRangeMaximums[24] != NULL)
            {
                $nearSizeMaximums = (round($arrayOfDateRangeMaximums[24],4) * 100) . "%";
            }
            if($arrayOfDateRangeMaximums[25] != NULL)
            {
                $neg140Plus325Maximums = (round($arrayOfDateRangeMaximums[25],4) * 100) . "%";
            }
            if($arrayOfDateRangeMaximums[26] != NULL)
            {
                $neg140Maximums = (round($arrayOfDateRangeMaximums[26],4) * 100) . "%";
            }


            $oversizeMinimums = "n/a";
            $plus40Minimums = "n/a";
            $neg40Plus70Minimums = "n/a";
            $neg60Plus70Minimums = "n/a";
            $neg70Plus140Minimums = "n/a";
            $neg50Plus140Minimums = "n/a";
            $nearSizeMinimums = "n/a";
            $neg140Plus325Minimums = "n/a";
            $neg140Minimums = "n/a";

            if($arrayOfDateRangeMinimums[18] != 1)
            {
                $oversizeMinimums = (round($arrayOfDateRangeMinimums[18],4) * 100) . "%";
            }
            if($arrayOfDateRangeMinimums[19] != 1)
            {
                $plus40Minimums = (round($arrayOfDateRangeMinimums[19],4) * 100) . "%";
            }
            if($arrayOfDateRangeMinimums[20] != 1)
            {
                $neg40Plus70Minimums = (round($arrayOfDateRangeMinimums[20],4) * 100) . "%";
            }
            if($arrayOfDateRangeMinimums[21] != 1)
            {
                $neg60Plus70Minimums = (round($arrayOfDateRangeMinimums[21],4) * 100) . "%";
            }
            if($arrayOfDateRangeMinimums[22] != 1)
            {
                $neg70Plus140Minimums = (round($arrayOfDateRangeMinimums[22],4) * 100) . "%";
            }
            if($arrayOfDateRangeMinimums[23] != 1)
            {
                $neg50Plus140Minimums = (round($arrayOfDateRangeMinimums[23],4) * 100) . "%";
            }
            if($arrayOfDateRangeMinimums[24] != 1)
            {
                $nearSizeMinimums = (round($arrayOfDateRangeMinimums[24],4) * 100) . "%";
            }
            if($arrayOfDateRangeMinimums[25] != 1)
            {
                $neg140Plus325Minimums = (round($arrayOfDateRangeMinimums[25],4) * 100) . "%";
            }
            if($arrayOfDateRangeMinimums[26] != 1)
            {
                $neg140Minimums = (round($arrayOfDateRangeMinimums[26],4) * 100) . "%";
            }

            echo "<tr><td>+10</td><td>" . ($sampleObject->vars["oversizePercent"] * 100) . "%" . "</td><td>" . $oversizeAverages . "</td><td>" . $oversizeStdDev . "</td><td>" . $oversizeMaximums . "</td><td>" . $oversizeMinimums . "</td></tr>";
            echo "<tr><td>-10+40</td><td>" . ($sampleObject->vars["plus_40"] * 100) . "%" . "</td><td>" . $plus40Averages . "</td><td>" . $plus40StdDev . "</td><td>" . $plus40Maximums . "</td><td>" . $plus40Minimums . "</td></tr>";
            echo "<tr><td>-40+70</td><td>" . ($sampleObject->vars["minus_40_plus_70"] * 100) . "%" . "</td><td>" . $neg40Plus70Averages . "</td><td>" . $neg40Plus70StdDev . "</td><td>" . $neg40Plus70Maximums . "</td><td>" . $neg40Plus70Minimums . "</td></tr>";
            echo "<tr><td>-60+70</td><td>" . ($sampleObject->vars["minus_60_plus_70"] * 100) . "%" . "</td><td>" . $neg60Plus70Averages . "</td><td>" . $neg60Plus70StdDev . "</td><td>" . $neg60Plus70Maximums . "</td><td>" . $neg60Plus70Minimums . "</td></tr>";
            echo "<tr><td>-70+140</td><td>" . ($sampleObject->vars["minus_70_plus_140"] * 100) . "%" . "</td><td>" . $neg70Plus140Averages . "</td><td>" . $neg70Plus140StdDev . "</td><td>" . $neg70Plus140Maximums . "</td><td>" . $neg70Plus140Minimums . "</td></tr>";
            echo "<tr><td>-50+140</td><td>" . ($sampleObject->vars["minus_50_plus_140"] * 100) . "%" . "</td><td>" . $neg50Plus140Averages . "</td><td>" . $neg50Plus140StdDev . "</td><td>" . $neg50Plus140Maximums . "</td><td>" . $neg50Plus140Minimums . "</td></tr>";
            echo "<tr><td>Near Size</td><td>" . ($sampleObject->vars["nearSize"] * 100) . "%" . "</td><td>" . $nearSizeAverages . "</td><td>" . $nearSizeStdDev . "</td><td>" . $nearSizeMaximums . "</td><td>" . $nearSizeMinimums . "</td></tr>";
            echo "<tr><td>-140+325</td><td>" . ($sampleObject->vars["minus_140_plus_325"] * 100) . "%" . "</td><td>" . $neg140Plus325Averages . "</td><td>" . $neg140Plus325StdDev . "</td><td>" . $neg140Plus325Maximums . "</td><td>" . $neg140Plus325Minimums . "</td></tr>";
            echo "<tr><td>-140</td><td>" . ($sampleObject->vars["minus_140"] * 100) . "%" . "</td><td>" . $neg140Averages . "</td><td>" . $neg140StdDev . "</td><td>" . $neg140Maximums . "</td><td>" . $neg140Minimums . "</td></tr>";

                    echo "<tr><td>Moisture Rate</td><td>" . ($sampleObject->vars["moistureRate"] * 100) . "%" . "</td><td colspan='4' ></td></tr>";
                    echo "<tr><td>Turbidity</td><td>" . ($sampleObject->vars["turbidity"]) . "</td><td colspan='4' ></td></tr>";
                    echo("<td colspan='6' class='sectionTitle'>Plant Settings</td>");

                    //dynamically display the PLC devices for this Plant, along with the values for this sample

                    //get an array of items
                    $plcArray = getKPIPLCTagsByPlantID($plantId);

                    //iterate through the array and display a table row for each
                    if(count($plcArray) > 0)
                    {
                        $objectCounter = 0;
                        //for each device
                        foreach ($plcArray as $plcObject)
                        {
                            //check for a value in the database
                            $tagObject = "";
                            $tagObject = getPlantSettingsDataByTagAndSampleId($plcObject->vars["id"], $sampleId);

                            if($tagObject != NULL) //if there is already a value in the database for this tag and sample combination
                            {
                                //output the row with the value present
                                echo "<tr><td>" . $plcObject->vars["device"] . "</td><td>" . $tagObject->vars['value'] . "</td><td colspan='4'></td></tr>";
                            }
                            else
                            {
                                //output the row without a value
                                echo "<tr><td>" . $plcObject->vars["device"] . "</td><td></td><td colspan='4'></td></tr>";
                            }
                            $objectCounter++;
                        }
                    }
                    else
                    {
                        echo "<tr><td colspan='6'>No KPI PLC Devices for this Location</td></tr>";
                    }

                    echo "</tbody>" .
                        "</table>";
                    echo "</div>"; //overviewTable


                }
                else
                {
                    //echo "<div class='overviewTable'>";
                    //echo("No samples exist for location " . $arrayOfLocations[$i]->vars['description'] . ".<br/>");          
                    //echo "</div>"; //overviewTable
                }

                //render the Specific Location boxes
                $specificLocationArray = getSpecificLocationsByLocation($arrayOfLocations[$i]->vars['id']); //get an array of specific locations
                for($l = 0; $l < count($specificLocationArray); $l++)
                {
                    echo "<div>";
                    renderSpecificLocationBox($specificLocationArray[$l]->vars["id"], $startDate, $endDate, $plantId);
                    echo "</div>";
                }

            }

        }

        echo "</div>"; //overviewTableWrapper
    }
    else
    {
        echo "Please select a Site and Plant from the inputs above.";
    }
    ?>

    <br/>
    <hr>
    <div class="overviewBottomContent">
        <input type="button" class="btn btn-vprop-blue" value="Refresh Page" onClick="window.location.reload()">
    </div>

</div> <!-- tab content -->

<script>
    //call JQuery to render the datepicker tool
    $(function()
    {
        $("#start_date_filter").datetimepicker(
            {
                format: 'Y-m-d H:i',
                //dateFormat: 'yy-mm-dd',
                onSelect: function(datetext)
                {
                    var d = new Date(); // for now

                    var h = d.getHours();
                    h = (h < 10) ? ("0" + h) : h ;

                    var m = d.getMinutes();
                    m = (m < 10) ? ("0" + m) : m ;

                    var s = d.getSeconds();
                    s = (s < 10) ? ("0" + s) : s ;

                    datetext = datetext + " " + h + ":" + m + ":" + s;
                    $('#start_date_filter').val(datetext);
                },
            });

        $("#end_date_filter").datetimepicker(
            {
                format: 'Y-m-d H:i',
                //dateFormat: 'yy-mm-dd',
                onSelect: function(datetext)
                {
                    var d = new Date(); // for now

                    var h = d.getHours();
                    h = (h < 10) ? ("0" + h) : h ;

                    var m = d.getMinutes();
                    m = (m < 10) ? ("0" + m) : m ;

                    var s = d.getSeconds();
                    s = (s < 10) ? ("0" + s) : s ;

                    datetext = datetext + " " + h + ":" + m + ":" + s;
                    $('#end_date_filter').val(datetext);
                },
            });
    });
</script>
<script type="text/javascript">
    //reload the page with the selected options
    function reloadPage()
    {
        var startDate = document.getElementById('start_date_filter').value;
        startDate = encodeURI(startDate);

        var endDate = document.getElementById('end_date_filter').value;
        endDate = encodeURI(endDate);

        var siteId = document.getElementById("siteId").value;
        siteId = encodeURI(siteId);

        var plantId = document.getElementById("plantId").value;
        plantId = encodeURI(plantId);

        window.location.replace("wt_overview.php?siteId=" + siteId + "&plantId=" + plantId + "&startDate=" + startDate + "&endDate=" + endDate);
    }

    //show or hide the specific location boxes
    function toggleSpecificLocations(locationID)
    {
        //console.log("DEBUG: toggleSpecificLocations function called with the location ID = " + locationID);

        var toggleLink = document.getElementById('toggleLink' + locationID);

        var specificLocationBoxArray = new Array();
        specificLocationBoxArray = document.getElementsByClassName('overviewTableSpecificLocationID' + locationID);

        //console.log("The toggleLink innerHTML = " + toggleLink.innerHTML);
        //console.log("The toggleLink text = " + toggleLink.text);
        //console.log("specificLocationBoxArray.length = " + specificLocationBoxArray.length);

        if(toggleLink.text == "+")
        {
            //console.log("toggleLink.text == +");
            toggleLink.text = "-";
            //show the Specific Location boxes
            for(i = 0; i < specificLocationBoxArray.length; i++)
            {
                //console.log(i);
                specificLocationBoxArray[i].style.display = "block";
            }
        }
        else if(toggleLink.text == "-")
        {
            //console.log("toggleLink.text == -");
            toggleLink.text = "+";
            //hide the Specific Location boxes
            for(i = 0; i < specificLocationBoxArray.length; i++)
            {
                //console.log(i);
                specificLocationBoxArray[i].style.display = "none";
            }
        }

    }
</script>

<?php
/***************************************
 * Name: function test_input($data)
 * Description: This function removes harmful characters from input.
 * Source: https://www.w3schools.com/php/php_form_validation.asp
 ****************************************/
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//====================================================================== END PHP

?>
