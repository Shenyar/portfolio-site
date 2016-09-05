<?php
$page_content = json_decode( file_get_contents("portfolio$lang.json") );
?>
<img src="img/massaindex.jpg" width="80%" class="main-min-height">
<div class="main">
    <div class="main-height">
        <div class="my-carousel">
            <img src="img/massaindex.jpg" width="80%" class="for-carousel-height">
            <div class="my-carousel-item my-carousel-hide">
                <img src="img/massaindex.jpg" width="100%">
                <div class="description">
                    <h2><?php echo $page_content->description->text[0]; ?></h2>
                    <h3><?php echo $page_content->used_tech; ?>:</h3>
                    <h4> - JavaScript;</h4>
                    <h4> - HTML;</h4>
                    <h4> - CSS.</h4>
                    <h3><?php echo $page_content->time_work; ?>:</h3>
                    <h4> - <?php echo $page_content->description->work_date[0]; ?>;</h4>
                    <h4> - <?php echo $page_content->description->work_time[0]; ?>.</h4>
                    <h3><a href="massaindex/"><?php echo $page_content->to_site; ?></a></h3>
                </div>
            </div>
            <div class="my-carousel-item my-carousel-left">
                <img src="img/insta-collage.jpg" width="100%">
                <div class="description">
                    <h2><?php echo $page_content->description->text[1]; ?></h2>
                    <h3><?php echo $page_content->used_tech; ?>:</h3>
                    <h4> - PHP;</h4>
                    <h4> - JavaScript (jQuery);</h4>
                    <h4> - HTML + CSS;</h4>
                    <h4> - API Instagram.</h4>
                    <h3><?php echo $page_content->time_work; ?>:</h3>
                    <h4> - <?php echo $page_content->description->work_date[1]; ?>;</h4>
                    <h4> - <?php echo $page_content->description->work_time[1]; ?>.</h4>
                    <h3><a href="insta-collage/"><?php echo $page_content->to_site; ?></a></h3>
                </div>
            </div>
            <div class="my-carousel-item my-carousel-active">
                <img src="img/kitchenwall.jpg" width="100%">
                <div class="description">
                    <h2><?php echo $page_content->description->text[2]; ?></h2>
                    <h3><?php echo $page_content->used_tech; ?>:</h3>
                    <h4> - AngularJS (SPA);</h4>
                    <h4> - JavaScript (jQuery, jQuery-UI);</h4>
                    <h4> - HTML + CSS (Bootstrap);</h4>
                    <h4> - PHP;</h4>
                    <h4> - MySQL.</h4>
                    <h3><?php echo $page_content->time_work; ?>:</h3>
                    <h4> - <?php echo $page_content->description->work_date[2]; ?>;</h4>
                    <h4> - <?php echo $page_content->description->work_time[2]; ?>.</h4>
                    <h3><a href="kitchen/"><?php echo $page_content->to_site; ?></a></h3>
                </div>
            </div>
            <div class="my-carousel-item my-carousel-right">
                <img src="img/ishop.jpg" width="100%">
                <div class="description">
                    <h2><?php echo $page_content->description->text[3]; ?></h2>
                    <h3><?php echo $page_content->used_tech; ?>:</h3>
                    <h4> - HTML;</h4>
                    <h4> - CSS;</h4>
                    <h4> - JavaScript (jQuery);</h4>
                    <h4> - PHP;</h4>
                    <h4> - MySQL.</h4>
                    <h3><?php echo $page_content->time_work; ?>:</h3>
                    <h4> - <?php echo $page_content->description->work_date[3]; ?>;</h4>
                    <h4> - <?php echo $page_content->description->work_time[3]; ?>.</h4>
                    <h3><a href="ishop/"><?php echo $page_content->to_site; ?></a></h3>
                </div>
            </div>
            <div class="my-carousel-item my-carousel-hide">
                <img src="img/urlaubsgluck.jpg" width="100%">
                <div class="description">
                    <h2><?php echo $page_content->description->text[4]; ?></h2>
                    <h3><?php echo $page_content->used_tech; ?>:</h3>
                    <h4> - HTML + CSS ( Адаптивная верстка, Perfect Pixel );</h4>
                    <h4> - JavaScript (jQuery);</h4>
                    <h3><?php echo $page_content->time_work; ?>:</h3>
                    <h4> - <?php echo $page_content->description->work_date[4]; ?>;</h4>
                    <h4> - <?php echo $page_content->description->work_time[4]; ?>.</h4>
                    <h3><a href="urlaubsgluck/"><?php echo $page_content->to_site; ?></a></h3>
                </div>
            </div>
        </div>
    </div>
</div>