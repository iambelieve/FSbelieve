<?php
require_once 'config/config.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$vid = $_GET['vid'];
$pid = $_GET['pid'];
$data = mysqli_fetch_array(mysqli_query($conn, "SELECT aid FROM ib_fansub_anime WHERE vid = '".$vid."'"));

if($_GET['mod']=='next'){
    $nxt = mysqli_fetch_array(mysqli_query($conn, "SELECT vid FROM ib_fansub_anime WHERE aid > '".$data['aid']."' AND pid = ".$pid." ORDER BY aid ASC LIMIT 1"));
    $link = 'watch.php?vid='.$nxt['vid'];
    if($nxt['vid']!=''){exit($link);} else {exit('null');}
    
}else{
    $pre = mysqli_fetch_array(mysqli_query($conn, "SELECT vid FROM ib_fansub_anime WHERE aid < '".$data['aid']."' AND pid = ".$pid." ORDER BY aid DESC LIMIT 1"));
     $link = 'watch.php?vid='.$pre['vid'];
    if($pre['vid']!=''){exit($link);} else {exit('null');}
}
