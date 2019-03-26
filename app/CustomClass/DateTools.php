<?php

namespace App\CustomClass;

use PDO;

/* 
 * File:  DateTools.php
 * 11.05.2012
 * @link http://thomas-rau.net
 * @author Thomas Rau <thrau@t-online.de>
 *
 * Modified by Patrick Curry
 * 25.03.2019
 * @version 1.1
 */
class DateTools
{
  var $holidays = array();
  var $year;
  
//******************************************************************************
/**
* Konstruktor
*/
//******************************************************************************
function __construct()
{ 
  unset($this->holidays);
  $this->year=0;
}
//******************************************************************************
/**
* GetHolidays
*
* GERMAN
*
* Erzeugt ein Array mit allen Feiertagen, die nicht grundsätzlich auf einem
* Sonntag liegen
* Ausgehend vom Ostersonntag werden die bewegliche Feiertag bestimmt
* Basiert auf der Gaußschen Osterformel (ergänzt Lichtenberg)
*
* ENGLISH
*
* This generates an array with all of the holidays that do not always 
* occur on Sundays
* Starting on Easter Sunday, the moving holidays are determined based on
* the Gaussian Easter formula (adding Lichtenberg)
* ADDED BY PATRICK
* Easter Sunday is the basis for all other moving holidays. Gauss created
* a formula to calcuate the dates of all the moving holidays, which is
* still used today. Thomas has coded the formula in php below.
*
http://de.wikipedia.org/wiki/Osterformel
http://www.ptb.de/cms/index.php?id=957&L=0

 1. die Säkularzahl:                                       
    K(X) = X div 100
 2. die säkulare Mondschaltung:                            
    M(K) = 15 + (3K + 3) div 4 − (8K + 13) div 25
 3. die säkulare Sonnenschaltung:                          
    S(K) = 2 − (3K + 3) div 4
 4. den Mondparameter:                                     
    A(X) = X mod 19
 5. den Keim für den ersten Vollmond im Frühling:        
    D(A,M) = (19A + M) mod 30
 6. die kalendarische Korrekturgröße:                    
    R(D,A) = D div 29 + (D div 28 − D div 29) (A div 11) 
    Denis Roegel kürzer geschriebene Größe 
    R(D,A) = (D + A div 11) div 29 bewirkt dasselbe
 7. die Ostergrenze:                                    
    OG(D,R) = 21 + D − R
 8. den ersten Sonntag im März:                         
    SZ(X,S) = 7 − (X + X div 4 + S) mod 7
 9. die Entfernung des Ostersonntags von der Ostergrenze 
    (Osterentfernung in Tagen):           
    OE(OG,SZ) = 7 − (OG − SZ) mod 7
10. das Datum des Ostersonntags als Märzdatum
    (32. März = 1. April usw.):                              
    OS = OG + OE

Feiertage DE: http://de.wikipedia.org/wiki/Feiertage_in_Deutschland 
*/
//******************************************************************************
/**
* GetHolidays
* Erzeugt ein Array mit allen Feiertagen, die nicht grundsätzlich auf einem
* Sonntag liegen
*/
//******************************************************************************
function getHolidays($year)
{
  $K=0;$M=0;$S=0;$A=0;$D=0;$R=0;$OG=0;$SZ=0;$OE=0;$OS=0;
  $X=$year;
  $K = intval($X / 100);
  $M = 15 + intval((3*$K + 3) / 4) - intval((8*$K + 13) / 25);
  $S = 2 - intval((3*$K + 3) / 4);
  $A = $X % 19;
  $D = (19*$A + $M) % 30;
  $R = intval($D/29) + (intval($D/28) - intval($D/ 29)) * intval($A/11);
  $OG = 21 + $D - $R;
  $SZ = 7 - ($X + intval($X/4) + $S) % 7;
  $OE = 7 - ($OG - $SZ) % 7;
  $OS = $OG + $OE;

  // m-d-y
  $i=0;
  $this->holidays['name'][$i]      = 'Neujahrstag';
  $this->holidays['timestamp'][$i] = mktime(0, 0, 0, 1, 1, $year);
  $this->holidays['date'][$i]      = date("d.m.Y", $this->holidays['timestamp'][$i]);

  $i++;
  $this->holidays['name'][$i]      = 'Karfreitag';
  $this->holidays['timestamp'][$i] = mktime(0, 0, 0, 3, $OS-2, $year);
  $this->holidays['date'][$i]      = date("d.m.Y", $this->holidays['timestamp'][$i]);  

  /*
  $i++;
  $this->holidays['name'][$i]      = 'Ostersonntag';
  $this->holidays['timestamp'][$i] = mktime(0, 0, 0, 3, $OS, $year);
  $this->holidays['date'][$i]      = date("d.m.Y", $this->holidays['timestamp'][$i]);   
  */

  $i++;
  $this->holidays['name'][$i]      = 'Ostermontag';
  $this->holidays['timestamp'][$i] = mktime(0, 0, 0, 3, $OS+1, $year);
  $this->holidays['date'][$i]      = date("d.m.Y", $this->holidays['timestamp'][$i]);   

  $i++;; // too many semicolons
  $this->holidays['name'][$i]      = 'Tag der Arbeit';
  $this->holidays['timestamp'][$i] = mktime(0, 0, 0, 5, 1, $year);
  $this->holidays['date'][$i]      = date("d.m.Y", $this->holidays['timestamp'][$i]);

  $i++;
  $this->holidays['name'][$i]      = 'Christi Himmelfahrt';
  $this->holidays['timestamp'][$i] = mktime(0, 0, 0, 3, $OS+39, $year);
  $this->holidays['date'][$i]      = date("d.m.Y", $this->holidays['timestamp'][$i]);  

  $i++;
  $this->holidays['name'][$i]      = 'Pfingstmontag';
  $this->holidays['timestamp'][$i] = mktime(0, 0, 0, 3, $OS+50, $year);
  $this->holidays['date'][$i]      = date("d.m.Y", $this->holidays['timestamp'][$i]);  

  $i++;;
  $this->holidays['name'][$i]      = 'Tag der Deutschen Einheit';
  $this->holidays['timestamp'][$i] = mktime(0, 0, 0, 10, 3, $year);
  $this->holidays['date'][$i]      = date("d.m.Y", $this->holidays['timestamp'][$i]);  

  $i++;;
  $this->holidays['name'][$i]      = 'Heiliger Abend';
  $this->holidays['timestamp'][$i] = mktime(0, 0, 0, 12, 24, $year);
  $this->holidays['date'][$i]      = date("d.m.Y", $this->holidays['timestamp'][$i]);   
  
  $i++;;
  $this->holidays['name'][$i]      = '1.Weihnachstag';
  $this->holidays['timestamp'][$i] = mktime(0, 0, 0, 12, 25, $year);
  $this->holidays['date'][$i]      = date("d.m.Y", $this->holidays['timestamp'][$i]);

  $i++;;
  $this->holidays['name'][$i]      = '1.Weihnachstag';
  $this->holidays['timestamp'][$i] = mktime(0, 0, 0, 12, 26, $year);
  $this->holidays['date'][$i]      = date("d.m.Y", $this->holidays['timestamp'][$i]);  
  
  $i++;;
  $this->holidays['name'][$i]      = 'Silvester';
  $this->holidays['timestamp'][$i] = mktime(0, 0, 0, 12, 31, $year);
  $this->holidays['date'][$i]      = date("d.m.Y", $this->holidays['timestamp'][$i]);  
  /* 
  echo "<pre>";
  var_dump($this->holidays);
  echo "</pre>";
  */
  //return $this->holidays;
}
//******************************************************************************
/**
* CheckHoliday
* Prüft, ob ein Tag ein Feiertag ist
*
* Check if a day is a holiday
*/
//******************************************************************************
function CheckHoliday($timestr)
{
  foreach($this->holidays['timestamp'] as $key =>$ts)
  { //echo "$timestr  -  $ts<br>";
  if($timestr==$ts) {return true;} }
  return false;
} 
//******************************************************************************
/**
* WorkDays
* Berechnet die Anzahl der tatsächlichen Arbeitstage zwischen zwei Daten
*/
//******************************************************************************
function WorkDays($fromDate, $toDate)
{        
  //Anfangsdatum
  $fd=explode('-',$fromDate); //jahr monat tag
  // Differenz Tage zwischen Anfangsdatum und Enddatum
  $days = floor((strtotime($toDate) - strtotime($fromDate))/86400); 
  $wdays=0;
  
  for($i=0; $i<=$days; $i++)
  {                     // m-d-y
    $dt=mktime(0, 0, 0, $fd[1], $fd[2]+$i, $fd[0]);
    //$tmpdate_str = date("d.m.Y", $dt);
    $year_str = date("Y", $dt);
    $tmpday_str = date("w", $dt);
    // Wochenende?
    if(($tmpday_str != 0) and 
       ($tmpday_str != 6)) 
    {
     // array nur aktualisieren, wenn Jahreswechsel
     if($this->year != $year_str) 
     { 
       $this->GetHolidays($year_str);
       $this->year = $year_str;
     } 
     // ist der Tag ein Feiertag?
     if (!$this->CheckHoliday($dt))
      {$wdays++; $str='';}
    } 
  } 
  return $wdays;
}

} // class
