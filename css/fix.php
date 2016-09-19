<?php


if(!isset($_GET['color'])){
    die;
}
header("Content-type: text/css; charset: UTF-8");

function hex_to_hue($hexcode)
{
    $redhex  = substr($hexcode,0,2);
    $greenhex = substr($hexcode,2,2);
    $bluehex = substr($hexcode,4,2);

    // $var_r, $var_g and $var_b are the three decimal fractions to be input to our RGB-to-HSL conversion routine
    $var_r = (hexdec($redhex)) / 255;
    $var_g = (hexdec($greenhex)) / 255;
    $var_b = (hexdec($bluehex)) / 255;

    // Input is $var_r, $var_g and $var_b from above
    // Output is HSL equivalent as $h, $s and $l — these are again expressed as fractions of 1, like the input values

    $var_min = min($var_r,$var_g,$var_b);
    $var_max = max($var_r,$var_g,$var_b);
    $del_max = $var_max - $var_min;

    $l = ($var_max + $var_min) / 2;

    if ($del_max == 0) {
        $h = 0;
        $s = 0;
    } else {
        if ($l < 0.5) {
            $s = $del_max / ($var_max + $var_min);
        } else {
            $s = $del_max / (2 - $var_max - $var_min);
        }
        ;

        $del_r = ((($var_max - $var_r) / 6) + ($del_max / 2)) / $del_max;
        $del_g = ((($var_max - $var_g) / 6) + ($del_max / 2)) / $del_max;
        $del_b = ((($var_max - $var_b) / 6) + ($del_max / 2)) / $del_max;

        if ($var_r == $var_max) {
            $h = $del_b - $del_g;
        } else if ($var_g == $var_max) {
            $h = (1 / 3) + $del_r - $del_b;
        } else if ($var_b == $var_max) {
            $h = (2 / 3) + $del_g - $del_r;
        }
        ;

        if ($h < 0) {
            $h += 1;
        }
        ;

        if ($h > 1) {
            $h -= 1;
        }
        ;
    }
    ;

    return array($h, $s, $l);

    /*
// Calculate the opposite hue, $h2
$h2 = $h + 0.5;
if ($h2 > 1)
{
$h2 -= 1;
};

return array($h2, $s, $l);
*/

}


function hue_2_rgb($v1,$v2,$vh)
    {
        if ($vh < 0) {
            $vh += 1;
        }
        ;

        if ($vh > 1) {
            $vh -= 1;
        }
        ;

        if ((6 * $vh) < 1) {
            return($v1 + ($v2 - $v1) * 6 * $vh);
        }
        ;

        if ((2 * $vh) < 1) {
            return($v2);
        }
        ;

        if ((3 * $vh) < 2) {
            return($v1 + ($v2 - $v1) * ((2 / 3 - $vh) * 6));
        }
        ;

        return($v1);
    }
    ;

function hue_to_hex($hue = array())
{
    


    list($h2, $s, $l) = $hue;

    // Input is HSL value of complementary colour, held in $h2, $s, $l as fractions of 1
    // Output is RGB in normal 255 255 255 format, held in $r, $g, $b
    // Hue is converted using function hue_2_rgb, shown at the end of this code

    if ($s == 0) {
        $r = $l * 255;
        $g = $l * 255;
        $b = $l * 255;
    } else {
        if ($l < 0.5) {
            $var_2 = $l * (1 + $s);
        } else {
            $var_2 = ($l + $s) - ($s * $l);
        }
        ;

        $var_1 = 2 * $l - $var_2;
        $r = 255 * hue_2_rgb($var_1,$var_2,$h2 + (1 / 3));
        $g = 255 * hue_2_rgb($var_1,$var_2,$h2);
        $b = 255 * hue_2_rgb($var_1,$var_2,$h2 - (1 / 3));
    }
    ;


    $rhex = sprintf("%02X",round($r));
    $ghex = sprintf("%02X",round($g));
    $bhex = sprintf("%02X",round($b));

    return $rhex.$ghex.$bhex;
}

function hex_2_rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

$hexcode = $_GET['color'];

$huecode = hex_to_hue($hexcode);

$rgbcode = hex_2_rgb($hexcode);

$a = 1 - ( 0.299 * $rgbcode[0] + 0.587 * $rgbcode[1] + 0.114 * $rgbcode[2])/255;


$huemod[0] = $huecode[0];
$huemod[1] = $huecode[1];
$huemod[2] = $huecode[2] - .07;


//text .6

//active .07

$sidemod[0] = $huecode[0] + 0.01;
$sidemod[1] = $huecode[1] - 0.34;
$sidemod[2] = $huecode[2] + 0.06;

$sidetab = hue_to_hex($sidemod);

$finalhex = hue_to_hex($huemod);

if ($a < 0.5){
    $finalhex1 = "000";
}else{
    $finalhex1 = "fff";
}

?>
.navbar-inverse{
    background-color: #<?= $hexcode; ?>;
}
.navbar-inverse .navbar-nav>.active>a, .navbar-inverse .navbar-nav>.active>a:hover, .navbar-inverse .navbar-nav>.active>a:focus{
    color: #<?= $finalhex1; ?>;
    background-color: #<?= $finalhex; ?>;
}
.navbar-inverse .navbar-brand{
    color: #<?= $finalhex1; ?>;
}
.navbar-inverse .navbar-nav>li>a{
    color: #<?= $finalhex1; ?>;
}
.btn-primary{
    color: #<?= $finalhex1; ?>;
    background-color: #<?= $hexcode; ?>;
}
.nav-sidebar > .active > a, .nav-sidebar > .active > a:hover, .nav-sidebar > .active > a:focus{
    color: #<?= $finalhex1 ?>;
    background-color: #<?= $finalhex; ?>;
}
a{
color: #<?= $hexcode ?>;
}