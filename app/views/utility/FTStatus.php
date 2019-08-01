<?php
/**
 * Created by PhpStorm.
 * User: TCP85_000
 * Date: 1/12/2016
 * Time: 9:44 PM
 */
$br = "<br />";
$startMoment = strtotime( '2016-01-12 11:24:21' ) ;
    $endMoment = strtotime( '2016-01-15 11:24:21' );

$startDate = date('Y-m-d H:i:s', $startMoment);
$endDate = date('Y-m-d H:i:s',  $endMoment);
$nowDate = date('Y-m-d H:i:s');
 $totalRecords = 1392647;
$fixer = $endMoment - strtotime($nowDate);
$tFixer = $endMoment - $startMoment;
$itemsLeft = floor( ($fixer/$tFixer) * $totalRecords);
$precLeft = ($itemsLeft/$totalRecords) * 100;
echo "<h1>File Transfer Status</h1>".$br;
echo "<strong>Started Time:</strong> ". $startDate.$br.$br;
echo "<strong>Total Objects to Transfer: </strong>" . number_format($totalRecords) .$br;
echo "<strong>Objects Left to Transfer: </strong>" . number_format($itemsLeft) . ' ( '. round($precLeft, 2) . '% )' .$br.$br;
echo "<strong>Estimated End:</strong> ". $endDate;