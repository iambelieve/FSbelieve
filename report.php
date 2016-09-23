<?php
    require_once 'config/config.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    $vid = $_GET['vid'];
    $vchk = mysqli_fetch_array(mysqli_query($conn, "SELECT gdrive FROM ib_fansub_anime WHERE vid = '".$vid."'"));
    $data = file_get_contents('http://api.iam-believe.xyz/drive/'.$vchk['gdrive']);
    $datajson = json_decode($data,TRUE);

    if ($datajson['link360']=='') {
    	$result = mysqli_query($conn, "UPDATE ib_fansub_anime SET report = 0 WHERE vid = '".$vid."'");
         exit('ok');
    }else{
        exit('not');
    }

?>