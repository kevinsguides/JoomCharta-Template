<?php

defined ('_JEXEC') or die;

function renderHeader($header_style, $header_image, $sitename){

    if($header_style == "title"){
        ?>

         <div class="top-branding p-3"><a href="" class="fs-1 text-decoration-none"><?php echo ($sitename); ?></a></div>
        
        <?php

    }

    if($header_style == "fullimg"){
        ?>

        <a href=""><img src="<?php echo ($header_image); ?>" class="img-fluid" alt="Responsive image"></a>

        <?php
    }

    if($header_style == "logo"){
        ?>

        <div class="top-branding p-3">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <a href=""><img src="<?php echo ($header_image); ?>" class="img-fluid" alt="Responsive image"></a>
                </div>
            </div>
        </div>

        <?php
    }
    
}


?>