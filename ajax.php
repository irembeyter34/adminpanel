<?php
@session_start();
@ob_start();
define("DATA","data/");
define("SAYFA","include/");
define("SINIF","class/");
include_once 'data/baglanti.php';
define("SITE",$siteURL);

if($_POST)
{
    if (!empty($_POST["tablo"]) && !empty($_POST["id"]) && !empty($_POST["durum"]))
    {
        $tablo=$vt->filter($_POST["tablo"]);
        $ID=$vt->filter($_POST["id"]);
        $durum=$vt->filter($_POST["durum"]);
        $guncelle=$vt->verigetir("UPDATE".$tablo,"SET durum=? WHERE id=?",array($durum,$id),1);
        if($guncelle!=false)
        {
            echo "Tamam";

        }
        else
        {
            echo "Başarısız";

        }

    }
    else
    {
        echo "BOŞ";
    }
}


?>

