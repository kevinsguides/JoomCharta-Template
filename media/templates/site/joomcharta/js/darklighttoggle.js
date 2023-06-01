document.addEventListener('DOMContentLoaded', function() {


    console.log('darklighttoggle.js loaded');

    const toggler = document.getElementById('dark-light-toggle');


    // Check for dark mode preference at the OS level
    const preferColorMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';

    // check if colorMode cookie is set
    const colorModeCookie = document.cookie.split(';').filter((item) => item.trim().startsWith('colorMode='));
    const colorMode = colorModeCookie.length ? colorModeCookie[0].split('=')[1] : null;

    //if it's not set, set it to the OS preference
    if (!colorMode) {
        setColorMode(preferColorMode);
    }


    // the img element is a child of toggler
    let toggleImgSrc = toggler.children[0].src;
    //remove filename from the path
    toggleImgSrc = toggleImgSrc.substring(0, toggleImgSrc.lastIndexOf('/') + 1);

    console.log('toggleImgSrc: ' + toggleImgSrc);

    function setColorMode(color) {
        //set colorMode cookie
        let date = new Date();
        date.setTime(date.getTime() + 365 * 24 * 60 * 60 * 1000);
        document.cookie =
          "colorMode=" + color + "; expires=" + date.toUTCString() + "; path=/";
        //update colorMode attribute
        document.documentElement.setAttribute('data-bs-theme', color);
    }



    function updateIcon() {
        // if dark, replace "moon" with "sun" in toggleImgSrc
        // if light, replace "sun" with "moon" in toggleImgSrc
        if (document.documentElement.getAttribute('data-bs-theme') === 'dark') {
            toggler.children[0].src = toggleImgSrc + 'sun.svg';
        }
        else{
            toggler.children[0].src = toggleImgSrc + 'moon.svg';
        }
    }

    toggler.addEventListener('click', function() {
        // Switch to the opposite theme
        const currentTheme = document.documentElement.getAttribute('data-bs-theme');
        const switchToTheme = currentTheme === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-bs-theme', switchToTheme);
        localStorage.setItem('colorMode', switchToTheme);
        updateIcon();
        setColorMode(switchToTheme);
    }
    );

    updateIcon();

});