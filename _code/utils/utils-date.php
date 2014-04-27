<?php

function datefr2en($mydate){
   @list($jour,$mois,$annee)=explode('/',$mydate);
   return @date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
}

?>
