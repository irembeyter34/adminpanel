<?php
if(!empty($_GET["tablo"]))
{
    $tablo=$_GET["tablo"];
    $kontrol=$vt->verigetir("moduller","WHERE tablo=? AND durum=?",array($tablo,1),"ORDER BY id ASC",1);
    if($kontrol!=false)
    {
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?=$kontrol[0]["baslik"]?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=SITE?>">Anasayfa</a></li>
              <li class="breadcrumb-item active">><?=$kontrol[0]["baslik"]?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
        <div class="col-md-12">
        <a href="<?=SITE?>liste/<?=$kontrol [0]["tablo"] ?>" class="btn btn-info" style="float:right ; margin-bottom:10px;margin-left:10px "><i class="fa fa-bars"></i>Liste </a>
        <a href="<?=SITE?>ekle/<?=$kontrol [0]["tablo"] ?>" class="btn btn-success" style="float:right ; margin-bottom:10px "><i class="fa fa-plus"></i>Yeni Ekle </a>

         </div>
        </div>
        <?php
          if($_POST)
          {
            if(!empty($_POST["kategori"]) && !empty($_POST["baslik"]) && !empty($_POST["anahtar"]) && !empty($_POST["description"]) && !empty($_POST["sirano"]))
            {
              $kategori=$vt->filter($_POST["kategori"]);
              $baslik=$vt->filter($_POST["baslik"]);
              $anahtar=$vt->filter($_POST["anahtar"]);
              $seflink=$vt->seflink($baslik);
              $description=$vt->filter($_POST["description"]);
              $sirano=$vt->filter($_POST["sirano"]);
              $metin=$vt->filter($_POST["metin"],true);
              if(!empty($_FILES["resim"]["name"]))
              {
                $yukle=$vt->upload("resim","../images/".$kontrol[0]["tablo"]."/");
                if($yukle!=false)
                {
                  $ekle=$VT->SorguCalistir("INSERT INTO ".$kontrol[0]["tablo"],"SET baslik=?, seflink=?, kategori=?, metin=?, resim=?, anahtar=?, description=?, durum=?, sirano=?, tarih=?",array($baslik,$seflink,$kategori,$metin,$yukle,$anahtar,$description,1,$sirano,date("Y-m-d")));
                }
                else
                {
                   ?>
              <div class="alert alert-info">Resim yükleme işleminiz başarısız.</div>
              <?php
                }

              }
              else
              {
                $ekle=$vt->SorguCalistir("INSERT INTO ".$kontrol[0]["tablo"],"SET baslik=?, seflink=?, kategori=?, metin=?, anahtar=?, description=?, durum=?, sirano=?, tarih=?",array($baslik,$seflink,$kategori,$metin,$anahtar,$description,1,$sirano,date("Y-m-d")));

              }

              if($ekle!=false)
              {
                ?>
              <div class="alert alert-success">İşleminiz başarıyla kaydedildi.</div>
              <?php

              }
              else
              {
                ?>
              <div class="alert alert-danger">İşleminiz sırasında bir sorunla karşılaşıldı..</div>
              <?php

              }

            }
            else
            {

              ?>
              <div class="alert alert-danger">Boş bıraktığınız alanları doldurunuz.</div>
              <?php
            }

          }
          ?>
          <form action="#" method="post" enctype="multipart/form-data">
            <div class="col-md-8"   >
          <div class="card-body card card-primary ">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label> KATEGORİLER </label>
                  <select class="form-control select2" style="width: 100%;"name="kategori">
                  <?php
                  $sonuc=$vt->KategoriGetir($kontrol [0]["tablo"],"",-1);
                  if($sonuc!=false)
                  {
                    echo $sonuc;
                  }
                  else
                  {
                    $vt->TekKategori($kontrol [0]["tablo"]);
                  }
                  ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label> BAŞLIK </label>
                  <input type="text" class="form-control" placeholder="Başlık ..." name="baslik">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label> AÇIKLAMA </label>
                  <textarea class="textarea" placeholder="Açıklama Alanıdır." name="metin"
                      style="width: 100%; height: 350px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label> ANAHTAR </label>
                  <input type="text" class="form-control" placeholder="Anahtar ..." name="anahtar">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label> DESCRIPTION </label>
                  <input type="text" class="form-control" placeholder="Description ..." name="description">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label> RESİM </label>
                  <input type="file" class="form-control" placeholder="Resim Seçiniz ..." name="resim">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label> SIRA NO </label>
                  <input type="number" class="form-control" placeholder="Sıra Numarası ..." name="sirano" style="width:100px"  >
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary">KAYDET</button>
                </div>
              </div>
              
            </div>
          </div>
          </div>
          </form>
      </div>
    </section>
    <!-- /.content -->
  </div>
<?php
    }
}
?>