<?php

defined ( '_JEXEC' ) or die ();


//convert hex to rgb
function toRGB($hex){
    $hex = str_replace("#", "", $hex);
    if(strlen($hex) == 3){
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    }else{
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }

    return ($r . "," . $g . "," . $b);
}

function brightenRGB($rgb, $amount){
    $rgb = explode(",", $rgb);
    $r = $rgb[0];
    $g = $rgb[1];
    $b = $rgb[2];

    $r = $r + $amount;
    $g = $g + $amount;
    $b = $b + $amount;

    if($r > 255){
        $r = 255;
    }
    if($g > 255){
        $g = 255;
    }
    if($b > 255){
        $b = 255;
    }

    return ($r . "," . $g . "," . $b);

}


function darkenRGB($rgb, $amount){
    $rgb = explode(",", $rgb);
    $r = $rgb[0];
    $g = $rgb[1];
    $b = $rgb[2];

    $r = $r - $amount;
    $g = $g - $amount;
    $b = $b - $amount;

    if($r < 0){
        $r = 0;
    }
    if($g < 0){
        $g = 0;
    }
    if($b < 0){
        $b = 0;
    }

    return ($r . "," . $g . "," . $b);

}

function mixRGB($firstColor, $secondColor){
    $firstColor = explode(",", $firstColor);
    $secondColor = explode(",", $secondColor);

    $r = ($firstColor[0] + $secondColor[0]) / 2;
    $g = ($firstColor[1] + $secondColor[1]) / 2;
    $b = ($firstColor[2] + $secondColor[2]) / 2;

    return ($r . "," . $g . "," . $b);
}


function renderCustomColors($wa, $params){
        
    $color_primary = $params->get('color_primary', '#003121');
    $color_primary_rgb = toRGB($color_primary);
    $color_primary_dark = darkenRGB($color_primary_rgb, 50);

    $color_secondary = $params->get('color_secondary', '#003121');
    $color_secondary_rgb = toRGB($color_secondary);
    $color_secondary_dark = darkenRGB($color_secondary_rgb, 50);

    $color_link = $params->get('color_link', '#003121');
    $color_link_rgb = toRGB($color_link);



    ?>

    <style>
        :root{
            --bs-primary: <?php echo $color_primary; ?>;
            --jc-primary: rgb(<?php echo $color_primary_rgb; ?>);
            --jc-primary-dark: rgb(<?php echo $color_primary_dark; ?>);
            --jc-primary-light: rgb(<?php echo brightenRGB($color_primary_rgb, 50); ?>);
            --bs-primary-rgb: <?php echo $color_primary_rgb; ?>;
            --bs-btn-bg: <?php echo $color_primary; ?> !default;
            --bs-link-color-rgb: <?php echo brightenRGB($color_link_rgb, 50); ?>;
            --bs-secondary: <?php echo $color_secondary; ?>;
            --jc-secondary: rgb(<?php echo $color_secondary_rgb; ?>);
            --jc-secondary-dark: rgb(<?php echo $color_secondary_dark; ?>);
            --bs-secondary-rgb: <?php echo $color_secondary_rgb; ?>;
        }

        [data-bs-theme="dark"] .text-primary{
            --bs-primary-rgb: <?php echo $color_primary_rgb; ?>;
        }

        [data-bs-theme="dark"] .text-secondary{
            --bs-secondary-rgb: <?php echo $color_secondary_rgb; ?>;
        }


    </style>

    <?php

}