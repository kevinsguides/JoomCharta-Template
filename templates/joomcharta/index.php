<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.j4starter
 *
 * @copyright   (C) YEAR Your Name
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * This is a heavily stripped down/modified version of the default Cassiopeia template, designed to build new templates off of.
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app = Factory::getApplication();
$wa  = $this->getWebAssetManager();

// Add Favicon from images folder
$this->addHeadLink(HTMLHelper::_('image', 'favicon.ico', '', [], true, 1), 'icon', 'rel', ['type' => 'image/x-icon']);


// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$menu     = $app->getMenu()->getActive();
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';




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


//Get params from template styling
$support_layout_ultrawide =  $this->params->get('layout_ultrawide', 0);
$color_scheme = $this->params->get('color_scheme', 'default');
$color_mode = $this->params->get('color_mode', 'light');
$color_mode_toggle = $this->params->get('color_mode_toggle', 1);


$set_color_mode = $color_mode;

if($color_mode == 'user'){
    //if user color mode, we'll start with dark then make it light later if needed
    $set_color_mode = 'dark';
    require_once 'includes/darklighttoggle.php';
    $wa->useScript('template.joomcharta.darklighttoggle');

    if (getColorMode() == 'light'){
        $set_color_mode = 'light';
    }
}



if($color_scheme == 'custom'){
    $color_primary = $this->params->get('color_primary', '#003121');
    $color_primary_rgb = toRGB($color_primary);
    $wa->addInlineStyle(':root{--bs-primary: '. $color_primary .';}');
    $wa->addInlineStyle(':root{--bs-primary-rgb: '. $color_primary_rgb .';}');
    $color_secondary = $this->params->get('color_secondary', '#3a424d');
    $color_secondary_rgb = toRGB($color_secondary);
    $wa->addInlineStyle(':root{--bs-secondary: '. $color_secondary .';}');
    $wa->addInlineStyle(':root{--bs-secondary-rgb: '. $color_secondary_rgb .';}');
    $color_link = $this->params->get('color_link', '#0d6efd');
    $color_link_rgb = toRGB($color_link);
    $wa->addInlineStyle(':root{--bs-link: '. $color_link .';}');
    $wa->addInlineStyle(':root{--bs-link-rgb: '. $color_link_rgb .';}');

    //calculate link-hover color as link-color + 20% brightness
    $color_link_hover = brightenRGB($color_link_rgb, 51);
    $wa->addInlineStyle(':root{--bs-link-hover: '. $color_link_hover .';}');
}





// Get this template's path
$templatePath = 'templates/' . $this->template;

//load bootstrap collapse js (required for mobile menu to work)
HTMLHelper::_('bootstrap.collapse');
HTMLHelper::_('bootstrap.dropdown');


//Register our web assets (Css/JS)
$wa->useStyle('template.joomcharta.mainstyles');
$wa->useStyle('template.joomcharta.user');
$wa->useScript('template.joomcharta.scripts');

if($support_layout_ultrawide == 0){
    $wa->addInlineStyle('.container{max-width: 1320px;}');
}



//figure out sidebar / overall layout stuff
$showsidebar = false;
$layout_main_cols = 12;
$layout_main_order = 1;
$layout_sidebar_order = 2;

$sidebar = $this->countModules('sidebar');
$sidebar_position = $this->params->get('sidebar_position', 'right');
if($this->countModules('sidebar')){
    $showsidebar = true;
    $layout_main_cols = 9;
    if(($sidebar_position) == 'left'){
        $layout_sidebar_order = 1;
        $layout_main_order = 2;
    }
}


//Set viewport
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" data-bs-theme="<?php echo $set_color_mode;?>">
<head>
	<jdoc:include type="metas" />
	<jdoc:include type="styles" />
	<jdoc:include type="scripts" />
    
</head>

<body class="site">
<div class="container p-0 container-fullsite">
	<header class="bg-light pt-3">
        <div class="top-branding p-3"><a href="" class="fs-1 text-decoration-none"><?php echo ($sitename); ?></a></div>
        <!-- Generate a Bootstrap Navbar for the top of our website and put the site title on it -->
        <nav class="navbar navbar-dark bg-primary navbar-expand-lg">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Put menu links in the navbar - main menu must be in the "menu" position!!! Only supports top level and 1 down, so no more than 1 level of child items-->
                <?php if ($this->countModules('menu')): ?>
                <div class="collapse navbar-collapse" id="mainmenu">
                    <jdoc:include type="modules" name="menu" style="none" />
                    <?php if ($this->countModules('search')): ?>
                        
                        <jdoc:include type="modules" name="search" style="search" />
                    <?php endif; ?>
                </div>

                <?php endif; ?>
            </div>
        </nav>
                    <!-- Load Breadcrumbs Module if Module Exists -->
                    <?php if ($this->countModules('breadcrumbs')) : ?>
                <div class="breadcrumbs bg-light">
                    <jdoc:include type="modules" name="breadcrumbs" style="none" />
                </div>
            <?php endif; ?>

        <!-- Load Header Module if Module Exists -->
        <?php if ($this->countModules('header')) : ?>
            <div class="headerClasses">
                <jdoc:include type="modules" name="header" style="none" />
            </div>
        <?php endif; ?>
        
    </header>

    <div class="row gx-0">
        <div class="col-12 col-lg-<?php echo $layout_main_cols;?> order-<?php echo $layout_main_order;?> ">
        <div class="p-0 p-md-1 p-lg-2">
            <main class="<?php echo $pageclass; ?>">
                <jdoc:include type="message" />
                <jdoc:include type="component" />
            </main>
        </div>
        </div>
        <?php if ($showsidebar) : ?>
            <div class="col-12 col-lg-3 order-<?php echo $layout_sidebar_order;?>">
            <div class="p-0 p-md-1 p-lg-2">
            <aside>
                <jdoc:include type="modules" name="sidebar" style="block" />
            </aside>
            </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- Load Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <?php if ($this->countModules('footer')) : ?>
                <jdoc:include type="modules" name="footer" style="none" />
            <?php endif; ?>
        </div>
    </footer>

    <!-- Include any debugging info -->
	<jdoc:include type="modules" name="debug" style="none" />
</div>
<?php
if($color_mode == 'user' && $color_mode_toggle == 1){
    renderColorToggle();
}

?>
</body>
</html>

