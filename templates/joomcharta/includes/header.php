<?php

defined ('_JEXEC') or die;

function renderHeader($header_style, $header_image, $sitename, $header_subtext, $header_bg_color){

    if($header_bg_color == 'onprimary'){
        $header_bg_color = 'header-color-onprimary';
    }
    else{
        $header_bg_color = '';
    }

    if($header_style == "title"){
        ?>

         <div class="top-branding p-3 <?php echo $header_bg_color; ?>">
            <a href="" class="fs-1 text-decoration-none"><?php echo ($sitename); ?></a>
            <?php if($header_subtext != ""): ?>
                <p class="fs-6 text-jc-linkcolor"><?php echo ($header_subtext); ?></p>
            <?php endif; ?>
        </div>

         
        
        <?php

    }

    if($header_style == "fullimg"){
        ?>

        <a href=""><img src="<?php echo ($header_image); ?>" class="img-fluid" alt="Responsive image"></a>

        <?php
    }

    if($header_style == "logo"){
        ?>

        <div class="top-branding p-3  <?php echo $header_bg_color; ?>">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <a href=""><img src="<?php echo ($header_image); ?>" class="img-fluid" alt="Responsive image"></a>
                </div>
            </div>
        </div>

        <?php
    }

    if($header_style == "headerMod"){
        ?>
        <jdoc:include type="modules" name="header" style="none" />
        <?php
    }
    
}


?>