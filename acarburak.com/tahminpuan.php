<?php

$tahmin_ust=0;
$tahmin_alt=0;


try{
    $dbBaglanti_film=new PDO("mysql:localhost;dbname=film","root","");
    $dbBaglanti_film->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
} catch(PDOException $e){
    print $e->getMessage();
}

if($_SESSION["login"]==true){
    $user=$_SESSION["uname"];

    $sim_cek=$dbBaglanti_film->prepare("SELECT * FROM benzerlik WHERE kullanici_adi1=? AND NOT similarity=? ORDER BY similarity DESC");
    $sim_cek->execute(array($user,0));

    $kac_kisi=0;
    foreach($sim_cek as $row){
        $benzer_kullanici=$row["kullanici_adi2"];
        $benzerlik=$row["similarity"];
        $kac_kisi++;
        if($kac_kisi>5){
        break;
        }
        $puancek=$dbBaglanti_film->prepare("SELECT * FROM puanuye WHERE kullanici_adi=? AND film_id=?");
        $puancek->execute(array($benzer_kullanici,$film_id));
        foreach($puancek as $row){
            $benzer_kullanici_oylamis=$row["puan"];
            $sorgu2=$dbBaglanti_film->prepare("SELECT AVG(a.puan) AS current_ortak_ort , AVG(b.puan) AS other_ortak_ort
            FROM puanuye AS a INNER JOIN puanuye AS b ON a.film_id = b.film_id WHERE a.kullanici_adi=? AND b.kullanici_adi=?");
            $sorgu2->execute(array($user,$benzer_kullanici));
            foreach($sorgu2 as $row){
                $current_ortak_ort=$row["current_ortak_ort"];
                $other_ortak_ort=$row["other_ortak_ort"];
                $tahmin_ust=$tahmin_ust+($benzer_kullanici_oylamis-$other_ortak_ort)*$benzerlik;
                $tahmin_alt=$tahmin_alt+abs($benzerlik);
            }
            if($tahmin_alt!=0){
                $tahmin=$current_ortak_ort+$tahmin_ust/$tahmin_alt;
                $tahmin=round($tahmin,2);
            }else{
                $tahmin=0;
            }
            if($tahmin>5){
                $tahmin=5;
            }else if($tahmin<1){
                $tahmin=1;
            }
        }
    }
}
?>