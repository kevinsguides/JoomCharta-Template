<?php

defined ('_JEXEC') or die;


function getColorMode(){
    
    //check if user has cookie set for colorMode
    if (isset($_COOKIE['colorMode'])) {
        $colorMode = $_COOKIE['colorMode'];
    } else {
        $colorMode = 'dark';
    }

    if($colorMode == 'light'){
        return 'light';
    } else {
        return 'dark';
    }


}



function renderColorToggle(){

    $mediaPath = JURI::root() . 'media/templates/site/joomcharta/';

    $colorToggle = '';

    if (getColorMode() == 'dark'){
        $colorToggle = '<a id="dark-light-toggle" title="Toggle Light Mode"><img src="'.$mediaPath.'images/sun.svg" alt="Dark/light toggler icon" width="32" height="32"/></a>';
    } else {
        $colorToggle = '<a id="dark-light-toggle" title="Toggle Dark Mode"><img src="'.$mediaPath.'images/moon.svg" alt="Dark/light toggler icon" width="32" height="32"/></a>';
    }

    echo($colorToggle);

}



?>