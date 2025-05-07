<?php

  GLOBAL $persons;
  GLOBAL $fldPER;
  GLOBAL $fldMAPB;

  // Константы и типы для постороения древа
  $Bougth = -1;//номер ветви

  $maps = "";

  // TMens = record
  $aX1 = array();;
  $aY1 = array();;
  $aM1 = array();;
  //end;
  $middleX = 0;
  $middleY = 0;
  $cnt = 0;

  $iCount = array();
  $iIndex = array();
  $iChildr = array();
  $iBougth = array();

  $avgY = 0;
  $avgX = 0;
  $avgI = 0;

  //заполняю элементы списка
  for ($i = 0; $i < count($persons); $i++)
  {
      $maps = $persons[$i][$fldMAPB];
//echo $maps.'<br>';

      if (!empty($maps))
      {
        $p1 = strpos($maps, "[");
        $p2 = strpos($maps, "|");
        $p3 = strpos($maps, "]");
        if ($p1 < $p2 && $p2 < $p3)
        {
          $x = substr($maps, $p1 + 1, $p2 - $p1 - 1);
          $y = substr($maps, $p2 + 1, $p3 - $p2 - 1);
//echo $maps.'='.$x.':'.$y.'<br>';
          $aX1[] = $x;
          $aY1[] = $y;
          $aM1[] = $persons[$i][$fldPER];
          $cnt++;
          $middleX = $middleX + $x;
          $middleY = $middleY + $y;
        }
        else
        {
          $aX1[] = 0;
          $aY1[] = 0;
          $aM1[] = '';
        }
      }

  }
  if($cnt > 0)
  {
      $middleX = $middleX / $cnt;
      $middleY = $middleY / $cnt;
  }


?>

    <style type="text/css">
      /* Set the size of the div element that contains the map */
      #map {
        height: 600px;
        /* The height is 400 pixels */
        width: 100%;
        /* The width is the width of the web page */
      }
    </style>
    <script>
      // Initialize and add the map
      function initMap() {
        // The location of Uluru
        const uluru = { lat: <?php echo $middleX; ?>, lng: <?php echo $middleY; ?> };
        //const uluru = { lat: 0.0, lng: 0.0 };
        // The map, centered at Uluru
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 3,
          center: uluru,
        });
        // The marker, positioned at Uluru
        //const marker = new google.maps.Marker({
        //  position: uluru,
        //  map: map,
        //});
<?
  for ($i = 0; $i < count($aX1); $i++)
  {
        echo 'const uluru'.$i.' = { lat: '.$aX1[$i].', lng: '.$aY1[$i].' };';
        echo 'const marker'.$i.' = new google.maps.Marker({';
        echo 'position: uluru'.$i.',';
        echo 'title: "'.$aM1[$i].'",';
        echo 'map: map,';
        echo '});';
  }
?>

      }
    </script>
    <!--The div element for the map -->
    <div id="map"></div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDomBjNGPZdTG1JHMo-8rIjS49yBoRho0w&callback=initMap&libraries=&v=weekly"
      async
    ></script>
