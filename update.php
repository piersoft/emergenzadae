<?php

function write($file,$string){
$fh = fopen($file, "w");
       if($fh==false)
           die("unable to create file");
       fputs ($fh, $string,strlen($string));
    //   echo $string;
       $success = fclose($fh);

   if ($success) {
      //  echo "File successfully closed!\n";
   } else {
        echo "Error on closing!\n";
   }

}

$url="https://goo.gl/sIisnN"; // sostituire con un CSV di identica struttura 
$csv1 = array_map('str_getcsv', file($url));
//echo $csv1[0][0];
$count1 = 0;
$i=0;
$features = array();
$name="";
$toponimo="";
$indirizzo="";
$civico="";
$descrizione="";
$lunmattina="";
$lunpomeriggio="";
$lat="";
$lon="";


foreach($csv1 as $csv11=>$data1){
  $count1 = $count1+1;


  if ($count1 >1)
  $features[] = array(
          'type' => 'Feature',
          'geometry' => array('type' => 'Point', 'coordinates' => array((float)$data1[2],(float)$data1[1])),
          'properties' => array('toponimo' => $data1[4],'indirizzo' => $data1[5], 'civico' => $data1[6],'name' => $data1[3],'id' =>$data1[0],'descrizione' =>$data1[7],'lunmattina' =>$data1[11],'lunpomeriggio' =>$data1[12],'marmattina' =>$data1[13],'marpomeriggio' =>$data1[14],'mermattina' =>$data1[15],'merpomeriggio' =>$data1[16],'giomattina' =>$data1[17],'giopomeriggio' =>$data1[18],'venmattina' =>$data1[19],'venpomeriggio' =>$data1[20],'sabmattina' =>$data1[21],'sabpomeriggio' =>$data1[22],'dommattina' =>$data1[23],'dompomeriggio' =>$data1[24])
          );
}
if ( ! defined( 'JSON_PRETTY_PRINT' ) ) {
 	    define( 'JSON_PRETTY_PRINT', 128 );
 	}
$allfeatures = array('type' => 'FeatureCollection', 'features' => $features);
$geostring=json_encode($allfeatures, JSON_PRETTY_PRINT);
//echo $stop_id." ".$stop_code." ".$stop_name." ".$stop_desc." ".$lat." ".$lon;
echo "fatto".$geostring;
$file = "/usr/www/dae/mappaf.json";
write($file,$geostring);
 ?>
