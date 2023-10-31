
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">İletişim Ayarları</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=SITE?>">Anasayfa</a></li>
              <li class="breadcrumb-item active">İletişim Ayarları</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        
        <?php
          if($_POST)
          {
            if(!empty($_POST["telefon"]) && !empty($_POST["mail"]) && !empty($_POST["adres"]) && !empty($_POST["faksno"]))
            {
              $telefon=$vt->filter($_POST["telefon"]);
              $mail=$vt->filter($_POST["mail"]);
              $adres=$vt->filter($_POST["adres"]);
              $faks=$vt->filter($_POST["faksno"]);
             
              {
                $guncelle=$vt->SorguCalistir("UPDATE ayarlar".$kontrol[0]["tablo"],"SET telefon=?,mail=?, adres=?, faksno=? WHERE id=? ",array($telefon,$mail,$adres,$faks,1),1);

              }

              if($guncelle!=false)
              {
                ?>
              <div class="alert alert-success">İşleminiz başarıyla kaydedildi.</div>
              <meta http-equiv="refresh" content="2;url=<?=SITE?>iletisim-ayarlar">
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
                  <label>Telefon </label>
                  <input type="text" class="form-control" placeholder="Telefon ..." name="telefon" value="<?=$sitetelefon?>">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label> E-Mail </label>
                  <input type="text" class="form-control" placeholder="Mail ..." name="mail"value="<?=$sitemail?>">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label> Adres </label>
                  <input type="text" class="form-control" placeholder="Adres ..." name="adres" value="<?=$siteadres?>">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label> Faks No </label>
                  <input type="text" class="form-control" placeholder="Faksno ..." name="faksno" value="<?=$sitefaks?>">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary">GÜNCELLE</button>
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
