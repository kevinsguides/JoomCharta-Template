<?php
/**
 * @package     kevinsguidescom
 * @subpackage  joomcharta.joomlatemplate
 *
 * @copyright   (C) 2024 Kevin Olson
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app = Factory::getApplication();
$wa  = $this->getWebAssetManager();


// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$menu     = $app->getMenu()->getActive();
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';

include_once 'includes/header.php';
$mediaPath = URI::root() . 'media/templates/site/joomcharta/';


//Get params from template styling
$support_layout_ultrawide =  $this->params->get('layout_ultrawide', 0);
$color_scheme = $this->params->get('color_scheme', 'default');
$color_mode = $this->params->get('color_mode', 'light');
$color_mode_toggle = $this->params->get('color_mode_toggle', 1);
$header_style = $this->params->get('header_style', 'title');
$header_image = $this->params->get('header_image', '');
$header_subtext  = $this->params->get('header_subtext', '');
$header_bg_color = $this->params->get('header_bg_color', 'onwhite');
$container_boxed = $this->params->get('container_boxed', 1);



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


$favico = $this->params->get('favicon_image', $mediaPath . 'images/defaultfavicon.png');

//Set viewport
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

// Figure out if we have a module published in the login dialog
$loginModalButtonText = Text::_('TPL_JOOMCHARTA_LOGIN');
if ($this->countModules('logindialog')) {
    HTMLHelper::_('bootstrap.modal');

    //check if user is logged in
    $user = Factory::getApplication()->getIdentity();
    if (!$user->guest) {
        //get their username



        $loginModalButtonText = Text::_('TPL_JOOMCHARTA_USERACCTDIALOG');
        $loginModalButtonText .= ' ' . $user->username;
    }

}

$loginDialogBtn = '';
if($this->countModules('logindialog')){
    $loginDialogBtn = '<button type="button" class="btn btn-primary" data-bs-toggle="modal" href="#jcLoginModal" id="jcModalLoginToggle">
    <span class="icon-user icon-fw" aria-hidden="true"></span>
    '.$loginModalButtonText.'</button>
    ';
}


?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" data-bs-theme="<?php echo $set_color_mode;?>">
<head>
	<jdoc:include type="metas" />
	<jdoc:include type="styles" />
	<jdoc:include type="scripts" />
    <link rel="icon" type="image/png" href="<?php echo $favico; ?>">
    <?php 
if($color_scheme == 'custom'){
    include_once('includes/customcolors.php');
    renderCustomColors($wa, $this->params);
}

?>
    
</head>

<body class="site">

<?php if ($container_boxed == 1):?>
<div class="container p-0 bg-light">
<?php endif;?>

<div class="container-fullsite">

<header class="bg-light position-relative">
<?php if ($container_boxed == 1):?>
        <?php echo $loginDialogBtn; ?>
        <?php endif;?>
       <?php renderHeader($header_style, $header_image, $sitename, $header_subtext, $header_bg_color, $container_boxed, $loginDialogBtn) ?>



        <!-- Generate a Bootstrap Navbar for the top of our website and put the site title on it -->
        <nav class="navbar navbar-dark bg-primary navbar-expand-lg">
            <div class="container">
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
                <div class="breadcrumbs bg-slightly-darker-than-light">
                    <div class="container"><jdoc:include type="modules" name="breadcrumbs" style="none" /></div>
                    
                </div>
            <?php endif; ?>



        
    </header><?php if ($this->countModules('hero')): ?>
        <div class="container p-0">
        <jdoc:include type="modules" name="hero" style="none" />
        </div>
    <?php endif; ?>
    <div class="container">
    <div class="row gx-0">
        <div class="col-12 col-lg-<?php echo $layout_main_cols;?> order-<?php echo $layout_main_order;?> ">
        <div class="p-0 p-md-1 p-lg-2">
            <main class="main-container <?php echo $pageclass; ?>">
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
    </div>

    <!-- Load Footer -->
    <footer class="footer mt-auto py-3">
        <div class="container">
            <?php if ($this->countModules('footer')) : ?>
                <jdoc:include type="modules" name="footer" style="none" />
            <?php endif; ?>
        </div>
    </footer>

    <!-- Include any debugging info -->
	<jdoc:include type="modules" name="debug" style="none" />


    <?php // Load Login Module Modal if Exists ?>
    <?php if ($this->countModules('logindialog')) : ?>
        <div class="modal" tabindex="-1" id="jcLoginModal">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $loginModalButtonText; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        
                        <jdoc:include type="modules" name="logindialog" style="none" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
    <?php endif;?>

</div>

<?php if ($container_boxed == 1):?>
    </div>
<?php endif;?>


<?php
if($color_mode == 'user' && $color_mode_toggle == 1){
    renderColorToggle();
}

?>
</body>
</html>

