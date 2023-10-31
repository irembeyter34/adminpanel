<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Modül Ekle</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
              <li class="breadcrumb-item active">Modül Ekle</li>
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
          $calistir=$vt->ModulEkle();
          if ($calistir!=false)
          {
            echo '<div class="alert alert-success">Modülünüz başarıyla eklenmiştir.</div>';
          }
          else
          {
            echo '<div class="alert alert-danger">Modülünüz eklenemedi. Sorunlar şunlar olabilir: <br>
            -Boş alan olabilir.<br>
            -Aynı isimde kayıtlı bir veri olabilir.<br>
            -Sistemsel bir sorun olabilir.</div>';
          }
        }
        
        ?>
      <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Modül Tanımlama Ekranı</h3>
              </div>
              <form role="form" action="#" method="post">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Başlık</label>
                    <input type="text" class="form-control" name="baslik" placeholder="Modül İsmini Yazınız.">
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="durum" value="1" checked="checked"  >
                    <label class="form-check-label" for="exampleCheck1">Aktif Yap</label>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Modül Ekle</button>
                </div>
              </form>
            </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>