<?php
//地点データ
$locate_ary = array(
    0 => array("lat" => 33.907220,"lng" => 134.617568,"name" => "津乃峰酒造株式会社"),
    1 => array("lat" => 34.159051,"lng" => 134.537661,"name" => "松浦酒造"),
    2 => array("lat" => 34.078547,"lng" => 134.523913,"name" => "斎藤酒造"),
    3 => array("lat" => 35.0118086,"lng" => 135.7681182,"name" => "京都市役所"),
    4 => array("lat" => 35.016672,"lng" => 135.7824254,"name" => "平安神宮"),
    5 => array("lat" => 35.024113,"lng" => 135.7621629,"name" => "京都御所紫宸殿"),
    6 => array("lat" => 35.0103281,"lng" => 135.7682849,"name" => "本能寺"),
    7 => array("lat" => 35.0076534,"lng" => 135.7602523,"name" => "六角堂"),
    8 => array("lat" => 35.027739,"lng" => 135.75097,"name" => "晴明神社"),
    9 => array("lat" => 35.0388033,"lng" => 135.7733869,"name" => "下鴨神社境内"),
    10 => array("lat" => 35.0004818,"lng" => 135.7608191,"name" => "ホテル日航プリンセス京都"),
    11 => array("lat" => 34.9906133,"lng" => 135.7593859,"name" => "東本願寺"),
    12 => array("lat" => 35.0093254,"lng" => 135.7623216,"name" => "京都府京都文化博物館"),
    13 => array("lat" => 35.3747023,"lng" => 135.3429022,"name" => "京都府綾部市於与岐町田和"),
);
 
//範囲データ取得
$ne_lat = $_GET["ne_lat"];
$sw_lat = $_GET["sw_lat"];
$ne_lng = $_GET["ne_lng"];
$sw_lng = $_GET["sw_lng"];
 
//出力
header('Content-type: text/xml; charset=utf-8');
echo '<?xml version="1.0" standalone="yes"?>';
echo "<Locations>";
foreach($locate_ary as $val){
    if(
        $val["lat"] < $ne_lat && 
        $val["lat"] > $sw_lat && 
        $val["lng"] < $ne_lng && 
        $val["lng"] > $sw_lng){
        echo "<Locate>";
        echo "<lat>".$val["lat"]."</lat>";
        echo "<lng>".$val["lng"]."</lng>";
        echo "<name>".$val["name"]."</name>";
        echo "</Locate>";
    }
}
echo "</Locations>\n";
?>