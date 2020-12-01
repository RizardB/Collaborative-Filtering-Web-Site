<?php
echo '<link rel="shortcut icon" type="image/x-icon" href="css/images/favicon.ico">';
    try{
        $dbBaglanti=new PDO("mysql:host=localhost;dbname=uyelik","root","");
        $dbBaglanti->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
    } catch(PDOException $e){
        print $e->getMessage();
    }

    $kullaniciAdi = $_POST["uname"];
    $sifre = $_POST["psw"];
    $dogumTarihi = $_POST["tarih"];
    $cinsiyet = $_POST["cinsiyet"];
    $eposta = $_POST["eposta"];

    $uyeDogrula=$dbBaglanti->prepare("SELECT * FROM uyeler");
    $uyeDogrula->execute();
    if($uyeDogrula->rowCount()){
        foreach($uyeDogrula as $row){
            if($row["kullanici_adi"] == $kullaniciAdi){
                Echo("Kullanıcı Adı Mevcut!<br>");
                Echo("Yönlendiriliyorsunuz...");
                Echo '<meta http-equiv="refresh" content="0;URL=uye_ol.html.php" />';
                exit();
            }
            elseif($row["eposta"] == $eposta){
                Echo("Eposta  Mevcut!<br>");
                Echo("Yönlendiriliyorsunuz...");
                Echo '<meta http-equiv="refresh" content="0;URL=uye_ol.html" />';
                exit();
            }
        }
    }

    $uyeKayıt = $dbBaglanti->prepare("INSERT INTO uyeler SET
    kullanici_adi=?,
    sifre=?,
    dogum_tarihi=?,
    eposta=?,
    cinsiyet=?");

    $uyeKayıt->execute(array(
    "$kullaniciAdi","$sifre","$dogumTarihi","$eposta","$cinsiyet"
    ));

    if ( $uyeKayıt ){
        $last_id = $dbBaglanti->lastInsertId();
        print "Kayıt Başarılı!<br>";
        echo "Yönelendiriliyorsunuz...";
        Echo '<meta http-equiv="refresh" content="0;URL=giris.html" />';
    } else{
        echo("Bir şeyler yanlış gitti. Kayıt oluşturulamadı.<br>Lütfen daha sonra tekrar deneyiniz.");
        Echo '<meta http-equiv="refresh" content="0;URL=uye_ol.html" />';
    }


?>