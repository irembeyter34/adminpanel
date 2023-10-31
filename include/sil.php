<?php
if(!empty($_GET["tablo"]) && !empty($_GET["id"])  )
{
    $tablo=$vt->filter($_GET["tablo"]);
    $ID=$vt->filter($_GET["id"]);
    $kontrol=$vt->verigetir("moduller","WHERE tablo=? AND durum=?",array($tablo,1),"ORDER BY id ASC",1);
    if($kontrol!=false)
    {
      $veri=$vt->verigetir($kontrol[0]["tablo"],"WHERE id=?",array($ID),"ORDER BY id ASC",1);
        if ($veri!=false)
        {
          $sil=$vt->SorguCalistir("DELETE FROM ".$tablo,"WHERE id=?",array($ID),1);
          ?>
          <meta http-equiv="refresh" content="0;url=<?=SITE?>liste/<?=$kontrol[0]["tablo"]?>">
          <?php

        }
        else
        {
          ?>
          <meta http-equiv="refresh" content="0;url=<?=SITE?>liste/<?=$kontrol[0]["tablo"]?>">
          <?php
        }

    }
  else
  {
      ?>
      <meta http-equiv="refresh" content="0;url=<?=SITE?>">
      <?php
  }
}
else
  {
      ?>
      <meta http-equiv="refresh" content="0;url=<?=SITE?>">
      <?php
  }


?>