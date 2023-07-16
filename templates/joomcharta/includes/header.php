<?php

defined ('_JEXEC') or die;

function renderHeader($header_style, $header_image, $sitename, $header_subtext, $header_bg_color, $container_boxed, $loginDialogBtn){
 

    if($header_bg_color == 'onprimary'){
        $header_bg_colorclass = 'header-color-onprimary';
        $header_bg_color = 'text-white link-white';
    }
    else{
        $header_bg_colorclass = '';
        $header_bg_color = 'text-jc-linkcolor';
    }

    if($header_style == "title"){
        ?>

        <div class="top-branding <?php echo $header_bg_colorclass; ?>">
            <?php if ($container_boxed == 0):?>
            <div class="container position-relative"><?php echo $loginDialogBtn; ?>
            <?php endif;?>
            <div class="p-3">
            <a href="" class="fs-1 text-decoration-none <?php echo $header_bg_color;?>"><?php echo ($sitename); ?></a>
            <?php if($header_subtext != ""): ?>
                <p class="fs-6 <?php echo $header_bg_color;?>"><?php echo ($header_subtext); ?></p>
            <?php endif; ?>
            </div>
            <?php if ($container_boxed == 1):?>
            </div>
            <?php endif;?>



        </div>

         
        
        <?php

    }

    if($header_style == "fullimg"){
        ?>

        <div class="container p-0 position-relative">
        <a href=""><img src="<?php echo ($header_image); ?>" class="img-fluid" alt="Responsive image"></a>
        <?php echo $loginDialogBtn; ?>
        </div>
        <?php
    }

    if($header_style == "logo"){
        ?>

        <div class="top-branding  <?php echo $header_bg_color; ?>">
        
        <div class="p-3">
        
        <?php if ($container_boxed == 0):?>
           <div class="container p-0 position-relative">
           <?php echo $loginDialogBtn; ?>
            <?php endif;?>
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <a href=""><img src="<?php echo ($header_image); ?>" class="img-fluid" alt="Responsive image"></a>
                    
                </div>
                
            </div>
            <?php if ($container_boxed == 1):?>
                </div>
            <?php endif;?>
        </div>
        </div>

        <?php
    }

    if($header_style == "headerMod"){
        ?>
        <div class="container p-0 position-relative">
        <?php echo $loginDialogBtn; ?>
        <jdoc:include type="modules" name="header" style="none" />
        </div>
        <?php
    }
    
}


?>