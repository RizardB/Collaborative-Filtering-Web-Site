<?php
echo '<link rel="shortcut icon" type="image/x-icon" href="css/images/favicon.ico">';
session_start();
    try{
        $dbBaglanti=new PDO("mysql:host=localhost;dbname=uyelik","root","");
        $dbBaglanti->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
    } catch(PDOException $e){
        print $e->getMessage();
    }

    $kullaniciAdi = $_POST["uname"];
    $sifre = $_POST["psw"];

    $girisDogrula=$dbBaglanti->prepare("SELECT * FROM uyeler");
    $girisDogrula->execute();
    if($girisDogrula->rowCount()){
        foreach($girisDogrula as $row){
            if($row["kullanici_adi"] == $kullaniciAdi && $row["sifre"] == $sifre){
                $_SESSION["login"]=true;
                $_SESSION["uname"]=$kullaniciAdi;
                $_SESSION["psw"]=$sifre;
                Echo("Giriş Başarılı!<br>");
                Echo("Yönlendiriliyorsunuz...");
                Echo '<meta http-equiv="refresh" content="1;URL=index.php" />';
                exit();
            }
        }
    }
    Echo("Giriş Başarısız!<br> Kullanıcı Adı veya şifre yanlış");
    Echo '<meta http-equiv="refresh" content="1;URL=giris.html" />';
    ob.end();
?>