<?php
include_once 'class/class.upload.php';
include_once 'class/vt.php';
$vt=new vt();
$ayarlar=$vt->verigetir("ayarlar","WHERE id=?",array(1),"ORDER BY id ASC",1);
if($ayarlar!=false)
{
    $sitebaslik=$ayarlar[0]["baslik"];
    $siteanahtar=$ayarlar[0]["anahtar"];
    $siteaciklama=$ayarlar[0]["aciklama"];
    $sitetelefon=$ayarlar[0]["telefon"];
    $sitemail=$ayarlar[0]["mail"];
    $siteadres=$ayarlar[0]["adres"];
    $sitefaks=$ayarlar[0]["faksno"];
    $siteURL=$ayarlar[0]["url"];
}
?>