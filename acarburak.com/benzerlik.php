<?php
try{
    $dbBaglanti_film=new PDO("mysql:host=localhost;dbname=film","root","");
    $dbBaglanti_film->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
} catch(PDOException $e){
    print $e->getMessage();
}



if($_SESSION["login"]==true){
    $user=$_SESSION["uname"];

    function gonder($user,$others,$kullanici_sayisi){
        try{
            $dbBaglanti_film=new PDO("mysql:host=localhost;dbname=film","root","");
            $dbBaglanti_film->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
        } catch(PDOException $e){
            print $e->getMessage();
        }

        $query=$dbBaglanti_film->prepare("SELECT AVG(puan) as ortalama_current FROM puanuye WHERE kullanici_adi=?");
        $query->execute(array($user));
        foreach($query as $row){
            $current_user_ortalama=$row["ortalama_current"];
        }


        $other_ortalama=$dbBaglanti_film->prepare("SELECT AVG(puan) AS other_ortalama FROM puanuye WHERE kullanici_adi=?");
        $other_ortalama->execute(array($others));
        foreach($other_ortalama as $row){
            $other_user_ortalama=$row["other_ortalama"];
        }


        $sorgu2=$dbBaglanti_film->prepare("SELECT a.puan AS current_puan, b.puan AS other_puan FROM puanuye AS a INNER JOIN puanuye AS b ON a.film_id = b.film_id 
        WHERE a.kullanici_adi=? AND b.kullanici_adi=?");
        $sorgu2->execute(array($user,$others));
        $dongu=0;
        foreach($sorgu2 as $row){
            $current_ortak_puan[]=$row["current_puan"];
            $other_ortak_puan[]=$row["other_puan"];
            $dongu++;
        }
        


        $benzerlik_ust=0;
        $benzerlik_alt_ilk=0;
        $benzerlik_alt_ikinci=0;
        for ($i=0; $i < $dongu-1 ; $i++) {
            $benzerlik_ust=$benzerlik_ust+($current_ortak_puan[$i]-$current_user_ortalama)*($other_ortak_puan[$i]-$other_user_ortalama);

            $benzerlik_alt_ilk=$benzerlik_alt_ilk+pow(($current_ortak_puan[$i]-$current_user_ortalama),2);
            $benzerlik_alt_ikinci=$benzerlik_alt_ikinci+pow(($other_ortak_puan[$i]-$other_user_ortalama),2);
        }

        $benzerlik_alt=sqrt($benzerlik_alt_ilk)*sqrt($benzerlik_alt_ikinci);
        if($benzerlik_alt==0){
            $benzerlik_sonuc=0;
        }else{
            $benzerlik_sonuc=$benzerlik_ust/$benzerlik_alt;
        }

        $giris_sayisi=0;
        $kullanici=$dbBaglanti_film->prepare("SELECT Count(*) AS giris_sayisi FROM benzerlik WHERE kullanici_adi1=? AND kullanici_adi2=?");
        $kullanici->execute(array($user,$others));
        foreach ($kullanici as $row) {
            $giris_sayisi=$row["giris_sayisi"];
        }

        if($giris_sayisi<1){
            $insert_benzerlik=$dbBaglanti_film->prepare("INSERT INTO benzerlik SET kullanici_adi1=?, kullanici_adi2=?, similarity=?");
            $insert_benzerlik->execute(array($user,$others,$benzerlik_sonuc));
            $insert_benzerlik=$dbBaglanti_film->prepare("INSERT INTO benzerlik SET kullanici_adi1=?, kullanici_adi2=?, similarity=?");
            $insert_benzerlik->execute(array($others,$user,$benzerlik_sonuc));
        }else{
            $update_benzerlik=$dbBaglanti_film->prepare("UPDATE benzerlik SET similarity=? WHERE kullanici_adi1=? AND kullanici_adi2=?");
            $update_benzerlik->execute(array($benzerlik_sonuc,$user,$others));
            $update_benzerlik=$dbBaglanti_film->prepare("UPDATE benzerlik SET similarity=? WHERE kullanici_adi1=? AND kullanici_adi2=?");
            $update_benzerlik->execute(array($benzerlik_sonuc,$others,$user));
        }
    }

    try{
        $dbBaglanti_uyelik=new PDO("mysql:host=localhost;dbname=uyelik","root","");
        $dbBaglanti_uyelik->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
    } catch(PDOException $e){
        print $e->getMessage();
    }
    
    $kullanici_sayisi=0;
    $sorgu1=$dbBaglanti_uyelik->prepare("SELECT kullanici_adi FROM uyeler WHERE NOT kullanici_adi=?");
    $sorgu1->execute(array($user));
    foreach($sorgu1 as $row){
        $other_users_kullanici_adi=$row["kullanici_adi"];
        $kullanici_sayisi++;
        gonder($user,$other_users_kullanici_adi,$kullanici_sayisi);
        
    }
}

?>