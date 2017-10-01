<?php
$lat=$_GET['lat'];
$lon=$_GET['lon'];

?>
 <!DOCTYPE html>
<html lang="it">
  <head>
  <title>Mappa Defribillatori LECCE</title>
  <link rel="shortcut icon" href="favicon.ico" />
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="http://necolas.github.io/normalize.css/2.1.3/normalize.css" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.css" />
        <link rel="stylesheet" href="MarkerCluster.css" />
        <link rel="stylesheet" href="MarkerCluster.Default.css" />
        <meta property="og:image" content="http://dati.comune.lecce.it/blog/dae/dae.png"/>
  <script src="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.js"></script>
   <script src="leaflet.markercluster.js"></script>
   <script src="http://joker-x.github.io/Leaflet.geoCSV/lib/jquery.js"></script>

<script type="text/javascript">

function microAjax(B,A){this.bindFunction=function(E,D){return function(){return E.apply(D,[D])}};this.stateChange=function(D){if(this.request.readyState==4 ){this.callbackFunction(this.request.responseText)}};this.getRequest=function(){if(window.ActiveXObject){return new ActiveXObject("Microsoft.XMLHTTP")}else { if(window.XMLHttpRequest){return new XMLHttpRequest()}}return false};this.postBody=(arguments[2]||"");this.callbackFunction=A;this.url=B;this.request=this.getRequest();if(this.request){var C=this.request;C.onreadystatechange=this.bindFunction(this.stateChange,this);if(this.postBody!==""){C.open("POST",B,true);C.setRequestHeader("X-Requested-With","XMLHttpRequest");C.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");C.setRequestHeader("Connection","close")}else{C.open("GET",B,true)}C.send(this.postBody)}};

</script>
  <style>
  #mapdiv{
        position:fixed;
        top:0;
        right:0;
        left:0;
        bottom:0;
}
#infodiv{
background-color: rgba(255, 255, 255, 0.70);

font-family: Titillium Web, Arial, Sans-Serif;
padding: 1px;
font-size: 12px;
bottom: 12px;
left:0px;


max-height: 60px;

position: fixed;

overflow-y: auto;
overflow-x: hidden;
}
#loader {
    position:absolute; top:0; bottom:0; width:100%;
    background:rgba(255, 255, 255, 1);
    transition:background 1s ease-out;
    -webkit-transition:background 1s ease-out;
}
#loader.done {
    background:rgba(255, 255, 255, 0);
}
#loader.hide {
    display:none;
}
#loader .message {
    position:absolute;
    left:50%;
    top:50%;
    font-family: Titillium Web, Arial, Sans-Serif;
    font-size: 15px;
}
</style>
  </head>

<body>

  <div data-tap-disabled="true">

  <div id="mapdiv"></div>
<div id="infodiv" style="leaflet-popup-content-wrapper">
  <p>Mappa con ubicazione Defibrillatori di Lecce installati all'interno del progetto Comune Cardio Protetto. Fonte dati Lic. CC-BY <a href="http://dati.comune.lecce.it/dataset/defibrillatori-dae">openData Lecce</a></br><font color='green'><b>VERDE</b></font> -> disponibili ora (orari comunicati) | <font color='gray'></font><font color='red'><b>ROSSO</b></font> -> non disponibili ora (o orari non comunicati). Powered by <a href="https://t.me/piersoft">@piersoft</a></p>
</div>
<div id='loader'><span class='message'>loading</span></div>
</div>
  <script type="text/javascript">
  var lat=parseFloat('<?php printf($_GET['lat']); ?>'),
      lon=parseFloat('<?php printf($_GET['lon']); ?>'),
      zoom=14;
  var string = '<?php printf($_GET['lat']); ?>';
      if (string.indexOf('.') === -1){
        lat=parseFloat('40.35313');
        lon=parseFloat('18.17257');
      }



        var osm = new L.TileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {maxZoom: 20, attribution: 'Map Data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'});
		var mapquest = new L.TileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png', {subdomains: '1234', maxZoom: 18, attribution: 'Map Data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'});

        var map = new L.Map('mapdiv', {
                    editInOSMControl: true,
            editInOSMControlOptions: {
                position: "topright"
            },
            center: new L.LatLng(lat, lon),
            zoom: zoom,
            layers: [osm]
        });

        var baseMaps = {
    "Mapnik": osm
        };
        L.control.layers(baseMaps).addTo(map);
        var markeryou = L.marker([lat,lon]).addTo(map);
        markeryou.bindPopup("<b>Richiesta soccorso</b>");
       var ico=L.icon({iconUrl:'dae.png', iconSize:[40,50],iconAnchor:[20,0]});
       var icor=L.icon({iconUrl:'daerosso.png', iconSize:[40,50],iconAnchor:[20,0]});

    //   var markers = L.markerClusterGroup({spiderfyOnMaxZoom: false, showCoverageOnHover: true,zoomToBoundsOnClick: true});

     function loadLayer(url)
        {
                var myLayer = L.geoJson(url,{
                  filter: function(feature, layer) {
                    var year = new Date().getFullYear();
                    var month = new Date().getMonth();
                    var hours = new Date().getHours();
                    var mins = new Date().getMinutes();
                    var day =new Date().getDay();
                    var date =new Date().getDate();
var aperturamattina="";
var chiusuramattina="";
                    var newtime=new Date(year,month,date,hours,mins);
console.log(day+','+newtime);
            if (day==0 && hours <=14.00){
                    var str = feature.properties.dommattina;
                    aperturamattina = new Date(year,month,date,str.substring(0, 2),str.substring(3,5));
                    chiusuramattina = new Date(year,month,date,str.substring(6, 8),str.substring(9,11));

                    if (feature.properties.dommattina.indexOf("-") !=-1 )    console.log(aperturamattina+"-"+chiusuramattina);
                      if (newtime >= aperturamattina && newtime <= chiusuramattina) return feature.properties.dommattina;
              }
            if (day==0 && hours >14.00){
                          var str = feature.properties.dompomeriggio;
                          aperturapom = new Date(year,month,date,str.substring(0, 2),str.substring(3,5));
                          chiusurapom = new Date(year,month,date,str.substring(6, 8),str.substring(9,11));

                          if (feature.properties.dompomeriggio.indexOf("-") !=-1 )  console.log(aperturamattina+"-"+chiusuramattina);
                            if (newtime >= aperturapom && newtime <= chiusurapom) return feature.properties.dompomeriggio;
              }

                  if (day==1 && hours <=14.00){
                          var str = feature.properties.lunmattina;
                          aperturamattina = new Date(year,month,date,str.substring(0, 2),str.substring(3,5));
                          chiusuramattina = new Date(year,month,date,str.substring(6, 8),str.substring(9,11));

                          if (feature.properties.lunmattina.indexOf("-") !=-1 )  console.log(aperturamattina+"-"+chiusuramattina);
                            if (newtime >= aperturamattina && newtime <= chiusuramattina) return feature.properties.lunmattina;
                      }
                  if (day==1 && hours >14.00){
                                var str = feature.properties.lunpomeriggio;
                                aperturapom = new Date(year,month,date,str.substring(0, 2),str.substring(3,5));
                                chiusurapom = new Date(year,month,date,str.substring(6, 8),str.substring(9,11));

                                if (feature.properties.lunpomeriggio.indexOf("-") !=-1 )  console.log(aperturamattina+"-"+chiusuramattina);
                                  if (newtime >= aperturapom && newtime <= chiusurapom) return feature.properties.lunpomeriggio;
                      }
                        if (day==2 && hours <=14.00){
                                var str = feature.properties.marmattina;
                                aperturamattina = new Date(year,month,date,str.substring(0, 2),str.substring(3,5));
                                chiusuramattina = new Date(year,month,date,str.substring(6, 8),str.substring(9,11));

                                if (feature.properties.marmattina.indexOf("-") !=-1 )    console.log(aperturamattina+"-"+chiusuramattina);
                                    if (newtime >= aperturamattina && newtime <= chiusuramattina) return feature.properties.marmattina;
                                  }
                        if (day==2 && hours >14.00){
                                      var str = feature.properties.marpomeriggio;
                                      aperturapom = new Date(year,month,date,str.substring(0, 2),str.substring(3,5));
                                      chiusurapom = new Date(year,month,date,str.substring(6, 8),str.substring(9,11));

                                      if (feature.properties.marpomeriggio.indexOf("-") !=-1 )  console.log(aperturamattina+"-"+chiusuramattina);
                                        if (newtime >= aperturapom && newtime <= chiusurapom) return feature.properties.marpomeriggio;
                                }
                              if (day==3 && hours <=14.00){
                                      var str = feature.properties.mermattina;
                                      aperturamattina = new Date(year,month,date,str.substring(0, 2),str.substring(3,5));
                                      chiusuramattina = new Date(year,month,date,str.substring(6, 8),str.substring(9,11));
                                      console.log('prova '+str.substring(6, 8)+','+str.substring(9,11));
                                      if (feature.properties.mermattina.indexOf("-") !=-1 )      console.log(aperturamattina+"-"+chiusuramattina);
                                            if (newtime >= aperturamattina && newtime <= chiusuramattina) return feature.properties.mermattina;
                                        }
                              if (day==3 && hours >14.00){
                                var str = feature.properties.merpomeriggio;

                                aperturapom = new Date(year,month,date,str.substring(0, 2),str.substring(3,5));
                                chiusurapom = new Date(year,month,date,str.substring(6, 8),str.substring(9,11));

                                            if (feature.properties.merpomeriggio.indexOf("-") !=-1 )      console.log(aperturamattina+"-"+chiusuramattina);
                                                  if (newtime >= aperturapom && newtime <= chiusurapom) return feature.properties.merpomeriggio;
                                        }
                              if (day==4 && hours <=14.00){
                                var str = feature.properties.giomattina;

                                aperturamattina = new Date(year,month,date,str.substring(0, 2),str.substring(3,5));
                                chiusuramattina = new Date(year,month,date,str.substring(6, 8),str.substring(9,11));

                              if (feature.properties.giomattina.indexOf("-") !=-1 )        console.log(aperturamattina+"-"+chiusuramattina);
                                                    if (newtime >= aperturamattina && newtime <= chiusuramattina) return feature.properties.giomattina;
                                                }
                              if (day==4 && hours >14.00){
                                                  var str = feature.properties.giopomeriggio;
                                                  aperturapom = new Date(year,month,date,str.substring(0, 2),str.substring(3,5));
                                                  chiusurapom = new Date(year,month,date,str.substring(6, 8),str.substring(9,11));

                                                  if (feature.properties.giopomeriggio.indexOf("-") !=-1 )    console.log(aperturamattina+"-"+chiusuramattina);
                                                      if (newtime >= aperturapom && newtime <= chiusurapom) return feature.properties.giopomeriggio;
                                                }
                              if (day==5 && hours <=14.00){
                                                  var str = feature.properties.venmattina;
                                                  aperturamattina = new Date(year,month,date,str.substring(0, 2),str.substring(3,5));
                                                  chiusuramattina = new Date(year,month,date,str.substring(6, 8),str.substring(9,11));

                                                  if (feature.properties.venmattina.indexOf("-") !=-1 )    console.log(aperturamattina+"-"+chiusuramattina);
                                                      if (newtime >= aperturamattina && newtime <= chiusuramattina) return feature.properties.venmattina;
                                                        }
                              if (day==5 && hours >14.00){
                                                        var str = feature.properties.venpomeriggio;
                                                        aperturapom = new Date(year,month,date,str.substring(0, 2),str.substring(3,5));
                                                        chiusurapom = new Date(year,month,date,str.substring(6, 8),str.substring(9,11));

                                                        if (feature.properties.venpomeriggio.indexOf("-") !=-1 )    console.log(aperturamattina+"-"+chiusuramattina);
                                                            if (newtime >= aperturapom && newtime <= chiusurapom) return feature.properties.venpomeriggio;
                                                }
                              if (day==6 && hours <=14.00){
                                                        var str = feature.properties.sabmattina;
                                                        aperturamattina = new Date(year,month,date,str.substring(0, 2),str.substring(3,5));
                                                        chiusuramattina = new Date(year,month,date,str.substring(6, 8),str.substring(9,11));

                                                        if (feature.properties.sabmattina.indexOf("-") !=-1 )    console.log(aperturamattina+"-"+chiusuramattina);
                                                            if (newtime >= aperturamattina && newtime <= chiusuramattina) return feature.properties.sabmattina;
                                                      }
                                                if (day==6 && hours >14.00){
                                                              var str = feature.properties.sabpomeriggio;
                                                              aperturapom = new Date(year,month,date,str.substring(0, 2),str.substring(3,5));
                                                              chiusurapom = new Date(year,month,date,str.substring(6, 8),str.substring(9,11));

                                                              if (feature.properties.sabpomeriggio.indexOf("-") !=-1 )  console.log(aperturamattina+"-"+chiusuramattina);
                                                                if (newtime >= aperturapom && newtime <= chiusurapom) return feature.properties.sabpomeriggio;
                                                      }

    },
    onEachFeature:function onEachFeature(feature, layer) {
                          var popup = '';
                          var str = ".jpg";


                          //var title = bankias.getPropertyTitle(clave);
                    //      popup += 'Dista: '+feature.properties.distanza+'</b><br />';
                          popup += '<b>'+feature.properties.name+'</b><br />';
                          popup += feature.properties.toponimo+' '+feature.properties.indirizzo+' '+feature.properties.civico+'</b><br />';;
                          popup += feature.properties.descrizione+'</b><br />Disponibile :</br>';
                    //      popup += '<a href="http://map.project-osrm.org/?z=14&center=40.351025%2C18.184133&loc='+lat+'%2C'+lon+'&loc='+feature.geometry.coordinates[1]+'%2C'+feature.geometry.coordinates[0]+'&hl=en&ly=&alt=&df=&srv=" target="_blank">Percorso fin qui</a>';
                  //        popup += '<a href="https://www.openstreetmap.org/directions?engine=mapzen_foot&route='+lat+'%2C'+lon+'%3B'+feature.geometry.coordinates[1]+'%2C'+feature.geometry.coordinates[0]+'#map=15/40.3535/18.1773" target="_blank">Percorso fin qui</a>';
                  if (feature.properties.lunmattina.indexOf("-") !=-1 )popup +='Lunedi mattina: '+feature.properties.lunmattina+"</br>";
                  if (feature.properties.lunpomeriggio.indexOf("-") !=-1)popup +='Lunedi pomeriggio: '+feature.properties.lunpomeriggio+"</br>";
                  if (feature.properties.marmattina.indexOf("-") !=-1 )popup +='Martedi mattina: '+feature.properties.marmattina+"</br>";
                  if (feature.properties.marpomeriggio.indexOf("-") !=-1)popup +='Martedi pomeriggio: '+feature.properties.marpomeriggio+"</br>";
                  if (feature.properties.mermattina.indexOf("-") !=-1 )popup +='Mercoledi mattina: '+feature.properties.mermattina+"</br>";
                  if (feature.properties.merpomeriggio.indexOf("-") !=-1)popup +='Mercoledi pomeriggio: '+feature.properties.merpomeriggio+"</br>";
                  if (feature.properties.giomattina.indexOf("-") !=-1 )popup +='Giovedi mattina: '+feature.properties.giomattina+"</br>";
                  if (feature.properties.giopomeriggio.indexOf("-") !=-1)popup +='Giovedi pomeriggio: '+feature.properties.giopomeriggio+"</br>";
                  if (feature.properties.venmattina.indexOf("-") !=-1 )popup +='Venerdi mattina: '+feature.properties.venmattina+"</br>";
                  if (feature.properties.venpomeriggio.indexOf("-") !=-1)popup +='Venerdi pomeriggio: '+feature.properties.venpomeriggio+"</br>";
                  if (feature.properties.sabmattina.indexOf("-") !=-1 )popup +='Sabato mattina: '+feature.properties.sabmattina+"</br>";
                  if (feature.properties.sabpomeriggio.indexOf("-") !=-1)popup +='Sabato pomeriggio: '+feature.properties.sabpomeriggio+"</br>";
                  if (feature.properties.dommattina.indexOf("-") !=-1 )popup +='Domenica mattina: '+feature.properties.dommattina+"</br>";
                  if (feature.properties.dompomeriggio.indexOf("-") !=-1)popup +='Domenica pomeriggio: '+feature.properties.dompomeriggio+"</br>";

                  if (feature.properties && feature.properties.id) {
                                }
                                layer.bindPopup(popup);
                        },
                        pointToLayer: function (feature, latlng) {
                        var marker = new L.Marker(latlng, { icon: ico });

                    //    markers[feature.properties.id] = marker;
                        return marker;
                        }
                }).addTo(map);

        }
        function loadLayerall(url)
           {
                   var myLayer = L.geoJson(url,{
                           onEachFeature:function onEachFeature(feature, layer) {
                             var popup = '';
                             var str = ".jpg";


                             //var title = bankias.getPropertyTitle(clave);
                       //      popup += 'Dista: '+feature.properties.distanza+'</b><br />';
            popup += '<b>'+feature.properties.name+'</b><br />';
            popup += feature.properties.toponimo+' '+feature.properties.indirizzo+' '+feature.properties.civico+'</b><br />';;
            popup += feature.properties.descrizione+"</br>";
                       //      popup += '<a href="http://map.project-osrm.org/?z=14&center=40.351025%2C18.184133&loc='+lat+'%2C'+lon+'&loc='+feature.geometry.coordinates[1]+'%2C'+feature.geometry.coordinates[0]+'&hl=en&ly=&alt=&df=&srv=" target="_blank">Percorso fin qui</a>';
                     //        popup += '<a href="https://www.openstreetmap.org/directions?engine=mapzen_foot&route='+lat+'%2C'+lon+'%3B'+feature.geometry.coordinates[1]+'%2C'+feature.geometry.coordinates[0]+'#map=15/40.3535/18.1773" target="_blank">Percorso fin qui</a>';
        if (feature.properties.lunmattina.indexOf("-") !=-1 )popup +='Lunedi mattina: '+feature.properties.lunmattina+"</br>";
        if (feature.properties.lunpomeriggio.indexOf("-") !=-1)popup +='Lunedi pomeriggio: '+feature.properties.lunpomeriggio+"</br>";
        if (feature.properties.marmattina.indexOf("-") !=-1 )popup +='Martedi mattina: '+feature.properties.marmattina+"</br>";
        if (feature.properties.marpomeriggio.indexOf("-") !=-1)popup +='Martedi pomeriggio: '+feature.properties.marpomeriggio+"</br>";
        if (feature.properties.mermattina.indexOf("-") !=-1 )popup +='Mercoledi mattina: '+feature.properties.mermattina+"</br>";
        if (feature.properties.merpomeriggio.indexOf("-") !=-1)popup +='Mercoledi pomeriggio: '+feature.properties.merpomeriggio+"</br>";
        if (feature.properties.giomattina.indexOf("-") !=-1 )popup +='Giovedi mattina: '+feature.properties.giomattina+"</br>";
        if (feature.properties.giopomeriggio.indexOf("-") !=-1)popup +='Giovedi pomeriggio: '+feature.properties.giopomeriggio+"</br>";
        if (feature.properties.venmattina.indexOf("-") !=-1 )popup +='Venerdi mattina: '+feature.properties.venmattina+"</br>";
        if (feature.properties.venpomeriggio.indexOf("-") !=-1)popup +='Venerdi pomeriggio: '+feature.properties.venpomeriggio+"</br>";
        if (feature.properties.sabmattina.indexOf("-") !=-1 )popup +='Sabato mattina: '+feature.properties.sabmattina+"</br>";
        if (feature.properties.sabpomeriggio.indexOf("-") !=-1)popup +='Sabato pomeriggio: '+feature.properties.sabpomeriggio+"</br>";
        if (feature.properties.dommattina.indexOf("-") !=-1 )popup +='Domenica mattina: '+feature.properties.dommattina+"</br>";
        if (feature.properties.dompomeriggio.indexOf("-") !=-1)popup +='Domenica pomeriggio: '+feature.properties.dompomeriggio+"</br>";
if (popup.indexOf("mattina") ==-1 && popup.indexOf("pomeriggio") ==-1 ){
  popup +='</br>Non ci sono comunicazioni sugli orari di disponibilita\'';
//icor=L.icon({iconUrl:'daerosso.png', iconSize:[40,50],iconAnchor:[20,0]});
}//else icor=L.icon({iconUrl:'daer.png', iconSize:[40,50],iconAnchor:[20,0]});
//if (feature.properties.name =="DEFIBRILLATORE PUBBLICO") icor=ico;
if (feature.properties.h24 =="1") icor=ico;

                                   if (feature.properties && feature.properties.id) {
                                   }
                                   layer.bindPopup(popup);
                           },
                           pointToLayer: function (feature, latlng) {
                           var marker = new L.Marker(latlng, { icon: icor });

                          // markers[feature.properties.id] = marker;
                           return marker;
                           }
                   }).addTo(map);

           }
           $.getJSON("mappaf.json", function(data) { loadLayerall(data, map); });

microAjax('mappaf.json',function (res) {
var feat=JSON.parse(res);
loadLayer(feat);
  finishedLoading();
} );
function startLoading() {
    loader.className = '';
}

function finishedLoading() {
    // first, toggle the class 'done', which makes the loading screen
    // fade out
    loader.className = 'done';
    setTimeout(function() {
        // then, after a half-second, add the class 'hide', which hides
        // it completely and ensures that the user can interact with the
        // map again.
        loader.className = 'hide';
    }, 500);
}
</script>

</body>
</html>
