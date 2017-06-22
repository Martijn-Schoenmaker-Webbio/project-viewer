<?php
  if (empty($_GET)) {
      require 'functions.php';
      $imageNames = array();
      foreach(getFileList(".") as $file) {
        if(!preg_match("/\.jpg|jpeg|gif|png|mp4|mov|webm|ogg$/", $file['name'])) continue;
        $imageName = $file['name'];
        $imageName = str_replace("./", "", $imageName);
        array_push($imageNames, $imageName);
      }
      sort($imageNames);
      header('Location:?screen='. $imageNames[0]);
  } else{
    require 'functions.php';
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $siteTitle ?></title>
    <link rel="stylesheet" type="text/css" href="../config/style.css">
    <link rel="icon" href="../config/favicon.ico" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
</head>

<style >
  <?php require 'style.php' ?>
</style>


<script type="text/javascript">
//Usersnap Functie
usersnap = <?php echo json_encode($userSnapLink, JSON_HEX_TAG); ?>;
if (usersnap !== '') {
  (function() {
    var s = document.createElement("script");
    var userSnapLink = '<?php echo $userSnapLink ?>';
    s.type = "text/javascript";
    s.async = true;
    s.src = '//api.usersnap.com/load/'+ userSnapLink;
    var x = document.getElementsByTagName('script')[0];
    x.parentNode.insertBefore(s, x);
  })();
}

//Functie om het menu in en uit te klappen en dat te onthouden voor de gebruiker
var collapsed;
window.onload = startupToggle;
function startupToggle() {
  menu = <?php echo json_encode($menu, JSON_HEX_TAG); ?>;
  defaultWidth = '1920px';
  if (menu === false) {
    localStorage.clear();
    defaultWidth = '100%';
  }

  if(localStorage.getItem('x') !== null) {
    x = localStorage.getItem('x');
    changeWidth(x);
  } else {
    localStorage.setItem('x', defaultWidth);
    x = localStorage.getItem('x');
    changeWidth(x);
  }

  if(localStorage.getItem('foldActive') !== null) {
    foldActive = localStorage.getItem('foldActive');
    firstToggle();
  } else {
    localStorage.setItem('foldActive', 'true');
    foldActive = localStorage.getItem('foldActive');
    firstToggle();
  }

  if(localStorage.getItem('collapsed') !== null) {
    collapsed = localStorage.getItem('collapsed');
    firstToggle();
  } else {
    localStorage.setItem('collapsed', false);
    collapsed = localStorage.getItem('collapsed');
    firstToggle();
  }
}

function firstToggle() {
  if (menu === true) {
    if(collapsed === 'true'){
      document.querySelector('.menu').className = 'menu menu-stay';
    } else {
      document.querySelector('.menu').className = 'menu';
    }
    if(foldActive === 'true'){
      document.querySelector('.fold').style.display = 'initial';
      document.querySelector('.fold-changer').innerHTML = 'Vouwlijn ingeschakeld';
      document.querySelector('.fold-changer').classList.add('active');
    } else {
      document.querySelector('.fold').style.display = 'none';
      document.querySelector('.fold-changer').innerHTML = 'Vouwlijn uitgeschakeld';
      document.querySelector('.fold-changer').classList.remove('active');
    }
  }
}

function checkLocalStorage() {
  if(localStorage.getItem('collapsed') !== null) {
    collapsed = localStorage.getItem('collapsed');
    toggleMenu();
  } else {
    localStorage.setItem('collapsed', false);
    collapsed = localStorage.getItem('collapsed');
    toggleMenu();
  }
}

function toggleMenu() {
  if(collapsed === 'false'){
    document.querySelector('.menu').className = 'menu menu-out';
    localStorage.setItem('collapsed', true);
    collapsed = localStorage.getItem('collapsed');
  } else {
    document.querySelector('.menu').className = 'menu';
    localStorage.setItem('collapsed', false);
    collapsed = localStorage.getItem('collapsed');
  }
}

function changeWidth(x) {
  if (x === '100%') {
    localStorage.setItem('x', x);
    x = localStorage.getItem('x');
    if (menu === true) {
      document.getElementById('right').classList.remove('active');
      document.getElementById('left').classList.add('active');
    }
  } else {
    localStorage.setItem('x', '1920px');
    x = localStorage.getItem('x');
    if (menu === true) {
      document.getElementById('left').classList.remove('active');
      document.getElementById('right').classList.add('active');
    }
  }
  document.querySelector('.img').style.width = x;
}

function changeFold() {
  if (foldActive === 'true') {
    localStorage.setItem('foldActive', false);
    foldActive = localStorage.getItem('foldActive');
    document.querySelector('.fold').style.display = 'none';
    document.querySelector('.fold-changer').innerHTML = 'Vouwlijn uitgeschakeld';
    document.querySelector('.fold-changer').classList.remove('active');
  } else {
    localStorage.setItem('foldActive', true);
    foldActive = localStorage.getItem('foldActive');
    document.querySelector('.fold').style.display = 'initial';
    document.querySelector('.fold-changer').innerHTML = 'Vouwlijn ingeschakeld';
    document.querySelector('.fold-changer').classList.add('active');
  }
}

</script>
<?php
  $imageNames = array();
  $links = array();
  $div = '';
  $imageUrl = '';

  function getCurrentUri()
     {
         $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
         $final_slash = substr($actual_link, strrpos($actual_link, '/') + 1);
         if ($final_slash === "") {
           var_dump("empty");
         }
         $imageUrl = substr($actual_link, strrpos($actual_link, '=') + 1);
         //var_dump($imageUrl);
         return $imageUrl;

     }

  foreach(getFileList(".") as $file) {
    if(!preg_match("/\.jpg|jpeg|gif|png|mp4|mov|webm|ogg$/", $file['name'])) continue;
    $imageName = $file["name"];
    $imageName = str_replace("./", "", $imageName);
    array_push($imageNames, $imageName);
  }
  sort($imageNames);
  for ($i=0; $i < count($imageNames); $i++) {
    $spacialize = str_replace("./", "", $imageNames[$i]);
    $removepng = str_replace(".png", "", $spacialize);
    if ($imageNames[$i] == getCurrentUri()) {
      $div .= "<li class='activeLink'><a href='?screen=". urlencode($spacialize) ."'>" . $removepng . "</a></li>";
    }else {
      $div .= "<li><a href='?screen=". urlencode($spacialize) ."'>" . $removepng . "</a></li>";
    }
  }
?>

<body style="margin:0px; height:800px;">
  <div class="fold" style="height:900px; width: 100%"></div>
  <div id="fullpage" style="width:100%; text-align:center;">
    <?php if (isset($isVideo)) : ?>
      <?php if ($isVideo === true) : ?>
        <video class="img" autoplay loop>
          <source src="<?= getCurrentUri(); ?>" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      <?php endif; ?>
    <?php else: ?>
    <img id="mainImage" class="img" src="<?= getCurrentUri(); ?>">
  <?php endif; ?>
  </div>

<?php if ($menu === true): ?>
  <div onclick="checkLocalStorage();" class="btn-menu"><p>Menu</p></div>
  <div class="menu menu-in">
    <h2>Sitemap</h2>
    <div class="menu-list">
      <?= $div ?>
    </div>
    <div class="bottom-buttons">
      <div title="De vouwlijn(fold) in- of uitschakelen" class="fold-changer" onclick="changeFold();">
        Vouwlijn ingeschakeld
      </div>
      <div class="width-changer">
        <div id="left" title="De afbeelding op volledig scherm weergeven" class="resize-buttons left" onclick="changeWidth('100%');">
            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.769 133.269">
              <title>icn-volledig-scherm</title>
              <path d="M118.957,30.4H11.813A11.813,11.813,0,0,0,0,42.216v61.952a11.813,11.813,0,0,0,11.813,11.813H44.952v14.288H24.759v3h81.25v-3H85.817V115.981h33.139a11.813,11.813,0,0,0,11.813-11.813V42.216A11.813,11.813,0,0,0,118.957,30.4ZM82.817,129.769H47.952V116.058H82.817Zm44.952-25.6a8.823,8.823,0,0,1-8.813,8.813H11.813A8.823,8.823,0,0,1,3,104.168V42.216A8.823,8.823,0,0,1,11.813,33.4H118.957a8.823,8.823,0,0,1,8.813,8.813Zm-92.534-97H26.621v3h8.614Zm17.229,0H43.849v3h8.614Zm51.685,0H95.534v3h8.614Zm-17.229,0H78.306v3H86.92Zm-17.228,0H61.078v3h8.614Zm-54.186,3h2.5v-3h-2.5V0h-3V17.334h3Zm99.756,7.167h3V0h-3V7.167h-2.5v3h2.5ZM88.573,66.939h2.295v-10.8H88.573Zm1.162-12.4a1.274,1.274,0,0,0,.942-.337,1.247,1.247,0,0,0,.337-.923,1.271,1.271,0,0,0-.337-.947A1.287,1.287,0,0,0,89.736,52a1.316,1.316,0,0,0-.962.332,1.271,1.271,0,0,0-.337.947,1.247,1.247,0,0,0,.337.923A1.3,1.3,0,0,0,89.736,54.537Zm-34-2.793H53.437v15.2h2.295Zm3.281,15.2h2.295v-15.2H59.013Zm26.279-15.2h-2.3v3.936a13.725,13.725,0,0,0,.166,1.836h-.117a3.724,3.724,0,0,0-3.242-1.572,3.8,3.8,0,0,0-3.179,1.479,6.605,6.605,0,0,0-1.147,4.136A6.582,6.582,0,0,0,76.6,65.67a3.762,3.762,0,0,0,3.154,1.465,3.669,3.669,0,0,0,3.232-1.611h.107l.4,1.416h1.8ZM83.095,61.9a4.191,4.191,0,0,1-.664,2.583,2.5,2.5,0,0,1-2.061.8,2.142,2.142,0,0,1-1.9-.942,4.9,4.9,0,0,1-.635-2.739,5.031,5.031,0,0,1,.654-2.8,2.11,2.11,0,0,1,1.865-.981,2.466,2.466,0,0,1,2.08.859,4.841,4.841,0,0,1,.664,2.9ZM79.33,80.509a4.281,4.281,0,0,0-1.4,1.533h-.117l-.3-1.9h-1.8v10.8h2.295V85.295a3.248,3.248,0,0,1,.854-2.334,2.94,2.94,0,0,1,2.231-.9,4.338,4.338,0,0,1,1.016.117l.225-2.139a5.568,5.568,0,0,0-1.143-.1A3.336,3.336,0,0,0,79.33,80.509Zm17.222-.566a4.286,4.286,0,0,0-1.992.449,3.3,3.3,0,0,0-1.348,1.25h-.156q-.811-1.7-3.3-1.7a4.213,4.213,0,0,0-1.88.42,3,3,0,0,0-1.3,1.191h-.117l-.322-1.416h-1.8v10.8H86.63V85.558a5.07,5.07,0,0,1,.62-2.876,2.235,2.235,0,0,1,1.948-.864,1.732,1.732,0,0,1,1.465.61,3.022,3.022,0,0,1,.469,1.851v6.66h2.3V85.216a4.3,4.3,0,0,1,.62-2.563,2.278,2.278,0,0,1,1.958-.835,1.746,1.746,0,0,1,1.47.61,3,3,0,0,1,.474,1.851v6.66h2.295V83.9a4.326,4.326,0,0,0-.884-2.979A3.63,3.63,0,0,0,96.552,79.943Zm-27.666-24a4.554,4.554,0,0,0-3.623,1.514,6.124,6.124,0,0,0-1.318,4.16,5.579,5.579,0,0,0,1.421,4.048,5.222,5.222,0,0,0,3.94,1.47,10.363,10.363,0,0,0,1.963-.166,7.009,7.009,0,0,0,1.7-.566V64.537a9.289,9.289,0,0,1-1.772.6,8.286,8.286,0,0,1-1.782.181,2.958,2.958,0,0,1-2.256-.845,3.547,3.547,0,0,1-.85-2.417h7.2v-1.24a4.965,4.965,0,0,0-1.24-3.574A4.453,4.453,0,0,0,68.886,55.943ZM66.347,60.4a3.307,3.307,0,0,1,.786-2.021,2.307,2.307,0,0,1,1.753-.693,2.2,2.2,0,0,1,1.719.688,2.992,2.992,0,0,1,.645,2.026ZM37.655,84.1a10.619,10.619,0,0,0-2.3-1.221,13,13,0,0,1-1.934-.928,2.4,2.4,0,0,1-.771-.747,1.835,1.835,0,0,1-.234-.952,1.621,1.621,0,0,1,.586-1.3,2.611,2.611,0,0,1,1.719-.493,8.931,8.931,0,0,1,3.4.8l.742-1.9a10.019,10.019,0,0,0-4.082-.9,5.266,5.266,0,0,0-3.408,1.025,3.42,3.42,0,0,0-1.27,2.813,3.822,3.822,0,0,0,.8,2.441,6.605,6.605,0,0,0,2.754,1.807,9.115,9.115,0,0,1,2.5,1.318,1.775,1.775,0,0,1,.605,1.357,1.719,1.719,0,0,1-.659,1.416,3.255,3.255,0,0,1-2.046.527,8.8,8.8,0,0,1-2.046-.264,10.729,10.729,0,0,1-2.075-.723v2.207a9.055,9.055,0,0,0,3.965.752,5.992,5.992,0,0,0,3.8-1.084,3.593,3.593,0,0,0,1.377-2.988,3.847,3.847,0,0,0-.342-1.68A3.6,3.6,0,0,0,37.655,84.1Zm61.118-28.1a7.752,7.752,0,0,0-.962-.063,4.66,4.66,0,0,0-3.159.967,3.423,3.423,0,0,0-1.108,2.725,3.46,3.46,0,0,0,.522,1.909,3,3,0,0,0,1.362,1.177,3.96,3.96,0,0,0-1.016.83,1.63,1.63,0,0,0-.044,1.938,1.72,1.72,0,0,0,.757.63,3.377,3.377,0,0,0-1.763.942,2.371,2.371,0,0,0-.63,1.675A2.524,2.524,0,0,0,93.9,70.963a6.033,6.033,0,0,0,3.369.781,7.97,7.97,0,0,0,4.375-1,3.194,3.194,0,0,0,1.514-2.832,2.679,2.679,0,0,0-.928-2.2,4.191,4.191,0,0,0-2.715-.762H97.626a2.992,2.992,0,0,1-1.274-.186.6.6,0,0,1-.347-.557,1.294,1.294,0,0,1,.742-1.074,5.086,5.086,0,0,0,.938.078,4.818,4.818,0,0,0,3.174-.957,3.231,3.231,0,0,0,1.152-2.627,3.309,3.309,0,0,0-.166-1.055,2.988,2.988,0,0,0-.42-.84l1.846-.342v-1.26H99.53A6.31,6.31,0,0,0,98.774,56.007ZM96.933,66.9h1.738a4.043,4.043,0,0,1,1.87.3,1.07,1.07,0,0,1,.5,1,1.609,1.609,0,0,1-.918,1.426,5.675,5.675,0,0,1-2.793.537,3.67,3.67,0,0,1-1.88-.4,1.262,1.262,0,0,1-.669-1.143,1.522,1.522,0,0,1,.581-1.255A2.446,2.446,0,0,1,96.933,66.9Zm.859-5.156a1.973,1.973,0,0,1-1.5-.547,2.173,2.173,0,0,1-.522-1.562,2.382,2.382,0,0,1,.513-1.65,1.934,1.934,0,0,1,1.509-.566,1.874,1.874,0,0,1,1.5.571,2.416,2.416,0,0,1,.493,1.626Q99.784,61.745,97.792,61.744ZM46.112,81.857a6.967,6.967,0,0,1,2.4.566l.693-1.846a7.226,7.226,0,0,0-3.076-.635,4.945,4.945,0,0,0-3.853,1.465,7.252,7.252,0,0,0-.059,8.3,4.728,4.728,0,0,0,3.726,1.431,7.86,7.86,0,0,0,1.694-.156,4.507,4.507,0,0,0,1.313-.518v-2a5.871,5.871,0,0,1-2.9.762,2.415,2.415,0,0,1-2.046-.913,4.456,4.456,0,0,1-.7-2.729Q43.31,81.857,46.112,81.857ZM34.179,61.5q-.166.469-.43,1.445t-.391,1.719q-.078-.488-.342-1.489t-.5-1.636L29.54,52.662h-2.4l4.98,14.277h2.461l5-14.277H37.157ZM68.486,79.943a4.554,4.554,0,0,0-3.623,1.514,6.124,6.124,0,0,0-1.318,4.16,5.579,5.579,0,0,0,1.421,4.048,5.222,5.222,0,0,0,3.94,1.47,10.363,10.363,0,0,0,1.963-.166,7.009,7.009,0,0,0,1.7-.566V88.537a9.289,9.289,0,0,1-1.772.6,8.286,8.286,0,0,1-1.782.181,2.958,2.958,0,0,1-2.256-.845,3.547,3.547,0,0,1-.85-2.417h7.2v-1.24a4.965,4.965,0,0,0-1.24-3.574A4.453,4.453,0,0,0,68.486,79.943ZM65.946,84.4a3.307,3.307,0,0,1,.786-2.021,2.307,2.307,0,0,1,1.753-.693,2.2,2.2,0,0,1,1.719.688,2.992,2.992,0,0,1,.645,2.026ZM57.07,79.943a4.206,4.206,0,0,0-1.948.43,3.193,3.193,0,0,0-1.3,1.211h-.146a17.993,17.993,0,0,0,.117-1.982V75.744H51.493v15.2h2.295V85.578a4.762,4.762,0,0,1,.679-2.9,2.535,2.535,0,0,1,2.124-.864,1.944,1.944,0,0,1,1.6.615,2.906,2.906,0,0,1,.5,1.865v6.641H61V83.9Q61,79.943,57.07,79.943Zm-11.348-24a4.888,4.888,0,0,0-3.8,1.475,5.856,5.856,0,0,0-1.348,4.1,6.685,6.685,0,0,0,.625,2.969,4.5,4.5,0,0,0,1.787,1.963,5.175,5.175,0,0,0,2.676.684,4.861,4.861,0,0,0,3.779-1.484A5.9,5.9,0,0,0,50.8,61.519a5.828,5.828,0,0,0-1.367-4.067A4.758,4.758,0,0,0,45.722,55.943Zm-.02,9.316q-2.763,0-2.764-3.74a4.87,4.87,0,0,1,.649-2.744,2.349,2.349,0,0,1,2.095-.957q2.754,0,2.754,3.7Q48.437,65.26,45.7,65.259Z"/>
            </svg>
        </div>
        <div id="right" title="De afbeelding op ware grootte weergeven" class="resize-buttons right" onclick="changeWidth('auto');">
            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.769 133.269">
              <title>icn-ware-grootte</title>
              <path d="M118.957,30.4H11.813A11.813,11.813,0,0,0,0,42.216v61.952a11.813,11.813,0,0,0,11.813,11.813H44.952V130.27H24.76v3h81.25v-3H85.817V115.981h33.139a11.813,11.813,0,0,0,11.813-11.813V42.216A11.813,11.813,0,0,0,118.957,30.4ZM82.817,129.769H47.952V116.058H82.817Zm44.952-25.6a8.823,8.823,0,0,1-8.813,8.813H11.813A8.823,8.823,0,0,1,3,104.168V42.216A8.823,8.823,0,0,1,11.813,33.4H118.957a8.823,8.823,0,0,1,8.813,8.813Zm-66.487-97H53.076v3h8.206Zm16.412,0H69.488v3h8.206Zm-35.324,3h2.5v-3h-2.5V0h-3V17.333h3ZM88.4,17.333h3V0h-3V7.167H85.9v3h2.5Zm-2.849,49.8a10.452,10.452,0,0,0,1.963-.166,7.108,7.108,0,0,0,1.7-.566V64.537a9.45,9.45,0,0,1-1.772.6,8.355,8.355,0,0,1-1.782.181,2.96,2.96,0,0,1-2.256-.845,3.546,3.546,0,0,1-.85-2.417h7.2v-1.24a4.964,4.964,0,0,0-1.24-3.574,4.45,4.45,0,0,0-3.379-1.3,4.551,4.551,0,0,0-3.623,1.514,6.12,6.12,0,0,0-1.318,4.16,5.58,5.58,0,0,0,1.421,4.048A5.226,5.226,0,0,0,85.551,67.135Zm-2.173-8.76a2.3,2.3,0,0,1,1.753-.693,2.206,2.206,0,0,1,1.719.688,3,3,0,0,1,.645,2.026h-4.9A3.3,3.3,0,0,1,83.378,58.375ZM35.7,85.2h2.959v3.682a11.337,11.337,0,0,1-2.422.283A4.335,4.335,0,0,1,32.792,87.8a5.86,5.86,0,0,1-1.2-3.979,5.555,5.555,0,0,1,1.328-3.926,4.68,4.68,0,0,1,3.613-1.436,8.246,8.246,0,0,1,3.477.8l.82-1.943a10.629,10.629,0,0,0-4.238-.859,7.45,7.45,0,0,0-5.459,1.948,7.216,7.216,0,0,0-1.982,5.4,7.728,7.728,0,0,0,1.758,5.415,6.438,6.438,0,0,0,5,1.919,17.525,17.525,0,0,0,2.563-.176,15.272,15.272,0,0,0,2.476-.6V83.2H35.7ZM66.83,65.436h.078l.459,1.5h1.641V59.664a3.518,3.518,0,0,0-1.05-2.822,4.67,4.67,0,0,0-3.11-.9,8.809,8.809,0,0,0-1.973.239,7.936,7.936,0,0,0-1.924.7l.742,1.641a11.856,11.856,0,0,1,1.465-.576A5.172,5.172,0,0,1,64.75,57.7a1.972,1.972,0,0,1,1.5.513,2.183,2.183,0,0,1,.483,1.548v.576l-1.865.059a7.145,7.145,0,0,0-3.779.928,2.854,2.854,0,0,0-1.24,2.52,3.217,3.217,0,0,0,.894,2.432,3.44,3.44,0,0,0,2.485.859,4.98,4.98,0,0,0,2.031-.356A4.44,4.44,0,0,0,66.83,65.436Zm-4.17-.454a1.442,1.442,0,0,1-.43-1.118,1.645,1.645,0,0,1,.737-1.479,4.743,4.743,0,0,1,2.358-.542l1.387-.059v.938a2.534,2.534,0,0,1-.757,1.958,2.847,2.847,0,0,1-2.007.7A1.845,1.845,0,0,1,62.66,64.981Zm15.947-6.8.225-2.139a5.506,5.506,0,0,0-1.143-.1,3.328,3.328,0,0,0-1.86.566,4.268,4.268,0,0,0-1.4,1.533h-.117l-.3-1.9h-1.8v10.8h2.295V61.295a3.244,3.244,0,0,1,.854-2.334,2.936,2.936,0,0,1,2.231-.9A4.341,4.341,0,0,1,78.607,58.18Zm9.38,30.7a1.62,1.62,0,0,1-.415-1.226V81.877h3.076V80.139H87.572v-2.4H86.156l-.781,2.285-1.582.84v1.016h1.475V87.7q0,3.437,3.262,3.438a6.819,6.819,0,0,0,1.245-.112,4.672,4.672,0,0,0,.981-.278V89.016a5.586,5.586,0,0,1-1.68.264A1.512,1.512,0,0,1,87.987,88.884Zm-18.511-8.94a4.884,4.884,0,0,0-3.8,1.475,5.853,5.853,0,0,0-1.348,4.1,6.684,6.684,0,0,0,.625,2.969,4.509,4.509,0,0,0,1.787,1.963,5.182,5.182,0,0,0,2.676.684A4.866,4.866,0,0,0,73.2,89.65a5.9,5.9,0,0,0,1.357-4.131,5.829,5.829,0,0,0-1.367-4.067A4.759,4.759,0,0,0,69.477,79.943Zm-.02,9.316q-2.764,0-2.764-3.74a4.864,4.864,0,0,1,.649-2.744,2.346,2.346,0,0,1,2.095-.957q2.754,0,2.754,3.7Q72.191,89.259,69.457,89.26Zm-20.664-30.8q.146-.489.366-1.484t.317-1.621q.048.41.283,1.46t.391,1.606l2.422,8.516h2.539l3.721-14.277H56.469l-2.031,8.3a25.46,25.46,0,0,0-.7,3.555,31.383,31.383,0,0,0-.723-3.477l-2.383-8.379H48.314L45.99,61q-.176.634-.391,1.66t-.322,1.855q-.205-1.534-.684-3.535l-2.041-8.32H40.17l1.875,7.129,1.846,7.148H46.43ZM80.126,88.884a1.62,1.62,0,0,1-.415-1.226V81.877h3.076V80.139H79.711v-2.4H78.295l-.781,2.285-1.582.84v1.016h1.475V87.7q0,3.437,3.262,3.438a6.819,6.819,0,0,0,1.245-.112,4.672,4.672,0,0,0,.981-.278V89.016a5.586,5.586,0,0,1-1.68.264A1.512,1.512,0,0,1,80.126,88.884ZM47.753,80.51a4.268,4.268,0,0,0-1.4,1.533h-.117l-.3-1.9h-1.8v10.8H46.43V85.295a3.244,3.244,0,0,1,.854-2.334,2.936,2.936,0,0,1,2.231-.9,4.341,4.341,0,0,1,1.016.117l.225-2.139a5.506,5.506,0,0,0-1.143-.1A3.328,3.328,0,0,0,47.753,80.51Zm49.458-.566a4.551,4.551,0,0,0-3.623,1.514,6.12,6.12,0,0,0-1.318,4.16,5.58,5.58,0,0,0,1.421,4.048,5.226,5.226,0,0,0,3.94,1.47,10.452,10.452,0,0,0,1.963-.166,7.108,7.108,0,0,0,1.7-.566V88.537a9.45,9.45,0,0,1-1.772.6,8.355,8.355,0,0,1-1.782.181,2.96,2.96,0,0,1-2.256-.845,3.546,3.546,0,0,1-.85-2.417h7.2v-1.24a4.964,4.964,0,0,0-1.24-3.574A4.45,4.45,0,0,0,97.211,79.943ZM94.672,84.4a3.3,3.3,0,0,1,.786-2.021,2.3,2.3,0,0,1,1.753-.693,2.206,2.206,0,0,1,1.719.688,3,3,0,0,1,.645,2.026ZM57.26,79.943a4.884,4.884,0,0,0-3.8,1.475,5.853,5.853,0,0,0-1.348,4.1,6.684,6.684,0,0,0,.625,2.969,4.509,4.509,0,0,0,1.787,1.963,5.182,5.182,0,0,0,2.676.684A4.866,4.866,0,0,0,60.98,89.65a5.9,5.9,0,0,0,1.357-4.131,5.829,5.829,0,0,0-1.367-4.067A4.759,4.759,0,0,0,57.26,79.943Zm-.02,9.316q-2.764,0-2.764-3.74a4.864,4.864,0,0,1,.649-2.744,2.346,2.346,0,0,1,2.095-.957q2.754,0,2.754,3.7Q59.975,89.259,57.24,89.26Z"/>
            </svg>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

</body>
</html>
