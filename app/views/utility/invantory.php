<?php
/**
 * Created by PhpStorm.
 * User: TCP85_000
 * Date: 2/24/2016
 * Time: 10:59 PM
 */

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL,"https://workflow.lakedoctors.com/fieldCross.php");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec ($curl);
echo curl_error($curl);
curl_close ($curl);
$test = json_decode($result);
foreach($test as $t){
    $temp = [];
}