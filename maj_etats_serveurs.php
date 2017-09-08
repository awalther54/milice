<?php
$etatSites = [];
for ($i=1;$i<20;$i++) {
$site = [];
$site['url'] = "s".$i.".sfgame.fr";
if(test_site_access($site['url'])) $site['dispo'] = "Disponible";
else $site['dispo'] = "Indisponible";
$etatSites[] = $site;
}
echo "<table id=\"etat_serveurs\" class=\"etat_serveurs\"><tr><th>Adresse du serveur</th><th>Etat du serveur</th></tr>";
foreach ($etatSites as $site) {
echo "<tr><td><a href=\"http://".$site['url']."\">".$site['url']."</a></td><td class=\"".$site['dispo']."\">".$site['dispo']."</td></tr>";
}
echo "</table>";

function test_site_access($url){
     
 
    $timeout = 20;
    $ch = curl_init($url);
     
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
 
    if (preg_match('`^https://`i', $url))
    {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    }
     
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; PPC Mac OS X 10_5_8) AppleWebKit/534.50.2 (KHTML, like Gecko) Version/5.0.6 Safari/533.22.3" );
    curl_exec($ch);
 
    $response = curl_exec($handle);
     
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
 
    if($http_code >= 200 && $http_code < 400)
    {
        return true;
         
    }elseif($response){
         
        return true;
         
    }else{
         
        return false;
    }
 
}
?>