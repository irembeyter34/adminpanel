<?php
class vt {
    var $sunucu ="localhost";
    var $user="root";
    var $password="";
    var $dbname="yonetimpaneli";
    var $baglanti;

    function __construct ()
    {
        try{
      $this->baglanti= new PDO("mysql:host=".$this->sunucu.";dbname=".$this->dbname.";charset=utf8;",$this->user,$this->password);
        }catch(PDOException $error){
            echo $error->getMessage();
            exit();

        }
    }
    /**
     * @param string $wherearraydeger
     */
    public function verigetir ($tablo, $wherealanlar="",$wherearraydeger="",$orderby="ORDER BY id ASC",$limit="")
    {
        $this->baglanti->query("SET CHARACTER SET UTF8");
        $sql="SELECT*FROM ".$tablo; /* SELECT*FROM ayarlar*/
        if(!empty($wherealanlar)  &&  !empty($wherearraydeger))
        {
            $sql.=" ".$wherealanlar;/* SELECT*FROM ayarlar WHERE*/
            if(!empty($orderby)) {$sql.=" ".$orderby;}
            if(!empty($limit)) {$sql.=" LIMIT ".$limit;}
            $calistir=$this->baglanti->prepare($sql); 
            $sonuc=$calistir->execute($wherearraydeger);
            $veri=$calistir->fetchAll(PDO::FETCH_ASSOC);
            //echo "<pre>"; print_r($veri);die();
        }
        else 
        {
            if(!empty($orderby)) {$sql.=" ".$orderby;}
            if(!empty($limit)) {$sql.=" LIMIT".$limit;}
            $calistir=$this->baglanti->prepare($sql);
            $veri=$this->baglanti->query($sql,PDO::FETCH_ASSOC);
        }
        if ($veri!=false && !empty($veri))
        {
            $datalar=array();
            foreach($veri as $bilgiler)
            {
                $datalar[]=$bilgiler;
            }
            return $datalar;
        }
        else
        {
            return false;
        }

    }
    public function SorguCalistir ($tablo, $alanlar="",$degerlerarray="",$limit="")
    {
        $this->baglanti->query("SET CHARACTER SET UTF8");
        if(!empty($alanlar) && !empty($degerlerarray))
        {
            $sql=$tablo." ".$alanlar;
            if(!empty($limit)){$sql.=" LIMIT ".$limit;}
            $calistir=$this->baglanti->prepare($sql);
            $sonuc=$calistir->execute($degerlerarray);
        }
        else
        {
            $sql=$tablo;
            if(!empty($limit)){$sql." LIMIT ".$limit;}
            $sonuc=$this->baglanti->exec($sql);
        }
        if($sonuc!==false)
        {
            return true;
        }
        else
        {
            return false;
        }
        $this->baglanti->query("SET CHARACTER SET UTF8");
    }
    public function seflink($val)
	{
		$find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#','?','*','!','.','(',')');
		$replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp','','','','','','');
		$string = strtolower(str_replace($find, $replace, $val));
		$string = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $string);
		$string = trim(preg_replace('/\s+/', ' ', $string));
		$string = str_replace(' ', '-', $string);
		return $string;
	
	}
    public function ModulEkle ()
    {
        if(!empty($_POST["baslik"]))
        {
            $baslik=$_POST["baslik"];
            if(!empty($_POST["durum"])){$durum=1;} else {$durum=2;}
            $tablo=str_replace("-","",$this->seflink($baslik));
            $kontrol=$this->verigetir("moduller","WHERE tablo=?",array($tablo),"ORDER BY id ASC",1);
            if($kontrol!=false)
            {
                return false;
            }
            else 
            {
            $tabloOlustur=$this->SorguCalistir ('CREATE TABLE `'. $tablo.'` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `baslik` varchar(250) DEFAULT NULL,
                `seflink` varchar(250) DEFAULT NULL,
                `kategori` int(11) DEFAULT NULL,
                `metin` text DEFAULT NULL,
                `resim` varchar(250) DEFAULT NULL,
                `anahtar` varchar(250) DEFAULT NULL,
                `description` varchar(250) DEFAULT NULL,
                `durum` int(5) DEFAULT NULL,
                `sirano` int(11) DEFAULT NULL,
                `tarih` date DEFAULT NULL,
                
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;');

            
            $modulekle=$this->SorguCalistir("INSERT INTO moduller","SET baslik=?,tablo=?,durum=?,tarih=?",array($baslik,$tablo,$durum,date("Y-m-d")));
            $kategoriekle=$this->SorguCalistir("INSERT INTO kategoriler","SET baslik=?,seflink=?,tablo=?,durum=?,tarih=?",array($baslik,$tablo,'modul',1,date("Y-m-d")));
            
            if($modulekle!=false)
            {
                return true;
            }
            else
            {
                return false;
            }
            }
        }
        else
        {
            return false;
        }
    }
    public function filter ($val,$tf=false)
    {
        if($tf==false){$val=strip_tags($val);}
        $val=addslashes(trim($val));
        return $val;
    }
public function uzanti($dosyaadi)   
{
    $parca=explode(".",$dosyaadi);
    $uzanti=end($parca);
    $donustur=strtolower($uzanti);
    return $donustur;
}
public function upload($nesnename,$yuklenecekyer='images/',$tur='img',$w='',$h='',$resimyazisi='')
	{
		if($tur=="img")
		{
			if(!empty($_FILES[$nesnename]["name"]))
			{
				$dosyanizinadi=$_FILES[$nesnename]["name"];
				$tmp_name=$_FILES[$nesnename]["tmp_name"];
				$uzanti=$this->uzanti($dosyanizinadi);
				if($uzanti=="png" || $uzanti=="jpg" || $uzanti=="jpeg" || $uzanti=="gif")
				{
					$classIMG=new upload($_FILES[$nesnename]);
					if($classIMG->uploaded)
					{
						if(!empty($w))
						{
							if(!empty($h))
							{
								$classIMG->image_resize=true;
								$classIMG->image_x=$w;
								$classIMG->image_y=$h;
							}
							else
							{
								if($classIMG->image_src_x>$w)
								{
									$classIMG->image_resize=true;
									$classIMG->image_ratio_y=true;
									$classIMG->image_x=$w;
								}
							}
						}
						else if(!empty($h))
						{
								if($classIMG->image_src_h>$h)
								{
									$classIMG->image_resize=true;
									$classIMG->image_ratio_x=true;
									$classIMG->image_y=$h;
								}
						}
						
						if(!empty($resimyazisi))
						{
							$classIMG->image_text = $resimyazisi;

						$classIMG->image_text_direction = 'v';
						
						$classIMG->image_text_color = '#FFFFFF';
						
						$classIMG->image_text_position = 'BL';
						}
						$rand=uniqid(true);
						$classIMG->file_new_name_body=$rand;
						$classIMG->Process($yuklenecekyer);
						if($classIMG->processed)
						{
							$resimadi=$rand.".".$classIMG->image_src_type;
							return $resimadi;
						}
						else
						{
							return false;
						}
					}
					else
					{
						return false;
					}
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		else if($tur=="ds")
		{
			
			if(!empty($_FILES[$nesnename]["name"]))
			{
				
				$dosyanizinadi=$_FILES[$nesnename]["name"];
				$tmp_name=$_FILES[$nesnename]["tmp_name"];
				$uzanti=$this->uzanti($dosyanizinadi);
				if($uzanti=="doc" || $uzanti=="docx" || $uzanti=="pdf" || $uzanti=="xlsx" || $uzanti=="xls" || $uzanti=="ppt" || $uzanti=="xml" || $uzanti=="mp4" || $uzanti=="avi" || $uzanti=="mov")
				{
					
					$classIMG=new upload($_FILES[$nesnename]);
					if($classIMG->uploaded)
					{
						$rand=uniqid(true);
						$classIMG->file_new_name_body=$rand;
						$classIMG->Process($yuklenecekyer);
						if($classIMG->processed)
						{
							$dokuman=$rand.".".$uzanti;
							return $dokuman;
						}
						else
						{
							return false;
						}
					}
				}
			}
		}
		else
		{
			return false;
		}
	}
    public function KategoriGetir ($tablo,$secid="",$uz=-1)//Çoklu kategori içindi,kategoriler yapısında kullanacağımız fonksyon içindi.
    {
        $uz++;//yukarıda tanımladığımız -1'i sıfırlamak için yaptık bunu
        $kategori=$this->verigetir("kategoriler","WHERE tablo=?",array($tablo),"ORDER BY id ASC");
        if($kategori!=false)
        {
            for($q=0;$q<count($kategori);$q++)
            {
                $kategoriseflink=$kategori[$q]["seflink"];
                $kategoriId=$kategori[$q]["id"];
                if($secid==$kategoriId)
                {
                    echo '<option value="'.$kategoriId.'" selected="selected">'.str_repeat("&nbsp;&nbsp;&nbsp;",$uz).stripslashes($kategori[$q]["baslik"]).'</option>';
                }
                else
                {
                    echo '<option value="'.$kategoriId.'">'.str_repeat("&nbsp;&nbsp;&nbsp;",$uz).stripslashes($kategori[$q]["baslik"]).'</option>';
   
                }
                if ($kategoriseflink==$tablo) {break;}
                $this->KategoriGetir($kategoriseflink,$secid,$uz);
            }
        }
        else
        {
            return false;
        }

    }
    public function TekKategori ($tablo,$secid="",$uz=-1)//Çoklu kategori içindi,kategoriler yapısında kullanacağımız fonksyon içindi.
    {
        $uz++;//yukarıda tanımladığımız -1'i sıfırlamak için yaptık bunu
        $kategori=$this->verigetir("kategoriler","WHERE seflink=? AND tablo=?",array($tablo,"modul"),"ORDER BY id ASC");
        if($kategori!=false)
        {
            for($q=0;$q<count($kategori);$q++)
            {
                $kategoriseflink=$kategori[$q]["seflink"];
                $kategoriId=$kategori[$q]["id"];
                if($secid==$kategoriId)
                {
                    echo '<option value="'.$kategoriId.'" selected="selected">'.str_repeat("&nbsp;&nbsp;&nbsp;",$uz).stripslashes($kategori[$q]["baslik"]).'</option>';
                }
                else
                {
                    echo '<option value="'.$kategoriId.'">'.str_repeat("&nbsp;&nbsp;&nbsp;",$uz).stripslashes($kategori[$q]["baslik"]).'</option> ';
   
                }
                
            }
        }
        else
        {
            return false;
        }

    }

}
?>
