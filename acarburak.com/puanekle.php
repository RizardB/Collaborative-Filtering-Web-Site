<?php
session_start();
echo '<link rel="shortcut icon" type="image/x-icon" href="css/images/favicon.ico">';

if(!isset($_SESSION["login"])){
    header("Refresh:1;url=giris.html");
    exit();
}
$_SESSION["Geldigi_Yer"] = $_SERVER['HTTP_REFERER'];
    try{
        $dbBaglanti=new PDO("mysql:host=localhost;dbname=film","root","");
        $dbBaglanti->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
    } catch(PDOException $e){
        print $e->getMessage();
    }
    
    $f_id=$_POST["rated"];
    $kad=$_SESSION["uname"];
    $puan=$_POST["star"];


    $query=$dbBaglanti->prepare("INSERT INTO puanuye SET film_id=?, kullanici_adi=?, puan=?");
    $insert=$query->execute(array(
        "$f_id","$kad","$puan"
    ));

    if ( $insert ){
        $last_id = $dbBaglanti->lastInsertId();
        //print "insert işlemi başarılı!";
        //header("Refresh:1;url=index.php");
    }else{
        //print "Bir şeyler ters gitti.";
        //header("Refresh:1;url=index.php");
    }

    $query=$dbBaglanti->prepare("SELECT * FROM movie WHERE film_id=$f_id");
    $query->execute();
    if($query->rowCount()){
        foreach($query as $row){
            $film_id=$row["film_id"];
            $film_adi=$row["film_adi"];
            $film_konu=$row["film_konu"];
            $film_tarih=$row["film_tarih"];
            $film_tur=$row["film_tur"];
            $puanlama_sayisi=$row["puanlama_sayisi"];
            $eskipuan=$row["puan"];
        }
    }

    $eskipuancarpim=$eskipuan*$puanlama_sayisi;
    $yenipuancarpim=$eskipuancarpim+$puan;
    $ypuanlama_sayisi=$puanlama_sayisi+1;
    $setpuan=$yenipuancarpim/$ypuanlama_sayisi;


    $query=$dbBaglanti->prepare("UPDATE movie SET puan = :yenipuan WHERE puan=:eskipuan and film_id=$f_id");
    $update = $query->execute(array(
        "yenipuan"=>$setpuan,
        "eskipuan"=>$eskipuan
    ));
        
    $query=$dbBaglanti->prepare("UPDATE movie SET puanlama_sayisi = :yenipuanlama WHERE puanlama_sayisi=:eskipuanlama and film_id=$f_id");
    $update = $query->execute(array(
        "yenipuanlama"=>$ypuanlama_sayisi,
        "eskipuanlama"=>$puanlama_sayisi
    ));

    if(!empty($_SESSION["Geldigi_Yer"])) {
        $back_url=$_SESSION["Geldigi_Yer"];
    }
    else {
        $back_url="index.php";
    }
    if ( $insert ){
        $last_id = $dbBaglanti->lastInsertId();
        print "Başarılı!";
        header("Refresh:1;url=$back_url");
    }else{
        print "Bir şeyler ters gitti.";
        header("Refresh:1;url=index.php");
    }
    
?>