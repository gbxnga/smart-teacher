<?php
date_default_timezone_set('UTC'); 
$month = 1;
$weekdays = array();
$d = 1;

do {
    $mk = mktime(0, 0, 0, $month, $d, date("Y"));
    @$weekdays[date("w", $mk)]++;
    $d++;
} while (date("m", $mk) == $month);

print_r($weekdays);

function getWeekdays($m, $y = NULL){
    $arrDtext = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri');

    if(is_null($y) || (!is_null($y) && $y == ''))
        $y = date('Y');

    $d = 1;
    $timestamp = mktime(0,0,0,$m,$d,$y);
    $lastDate = date('t', $timestamp);
    $workingDays = 0;
    for($i=$d; $i<=$lastDate; $i++){
        if(in_array(date('D', mktime(0,0,0,$m,$i,$y)), $arrDtext)){
            $workingDays++;
        }
    }
    return $workingDays;
}

echo getWeekDays(2).'<br/>';

function getWorkdays($date1, $date2, $workSat = FALSE, $patron = NULL) {
    if (!defined('SATURDAY')) define('SATURDAY', 6);
    if (!defined('SUNDAY')) define('SUNDAY', 0);
    // Array of all public festivities
    $publicHolidays = array('01-01', '01-06', '04-25', '05-01', '06-02', '08-15', '11-01', '12-08', '12-25', '12-26');
    // The Patron day (if any) is added to public festivities
    if ($patron) {
      $publicHolidays[] = $patron;
    }
    /*
     * Array of all Easter Mondays in the given interval
     */
    $yearStart = date('Y', strtotime($date1));
    $yearEnd   = date('Y', strtotime($date2));
    for ($i = $yearStart; $i <= $yearEnd; $i++) {
      $easter = date('Y-m-d', easter_date($i));
      list($y, $m, $g) = explode("-", $easter);
      $monday = mktime(0,0,0, date($m), date($g)+1, date($y));
      $easterMondays[] = $monday;
    }
    $start = strtotime($date1);
    $end   = strtotime($date2);
    $workdays = 0;
    for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
      $day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
      $mmgg = date('m-d', $i);
      if ($day != SUNDAY &&
        !in_array($mmgg, $publicHolidays) &&
        !in_array($i, $easterMondays) &&
        !($day == SATURDAY && $workSat == FALSE)) {
          $workdays++;
      }
    }
    return intval($workdays);
  }

  $today = date("Y-m-d");
  echo getWorkdays('2018-01',$today).'<br/>';

  $now = new \DateTime('now');
   $month = $now->format('m');
   $year = $now->format('Y');
   $month = 12;
   if (substr($month,0,1)=="0") $month = substr($month,1);
   echo 'current_month: '.$month;

   echo date('t',strtotime('today'));
  