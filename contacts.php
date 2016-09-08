<?php
$page_content = json_decode( file_get_contents("contacts$lang.json") );
?>
<div class="row contact-margin">
    <div class="col-sm-offset-1 col-sm-4  col-xs-offset-3 col-xs-6">
        <div class="relative">
            <div class="avatar-border">
                <img src="img/hex-avatar.png" width="100%" height="100%">
            </div>
            <img src="img/1.jpg" width="100%">
        </div>
    </div>
    <div class="col-sm-6 col-xs-12 contact-header">
        <?php echo $page_content->main_header; ?>
    </div>
    <div class="col-sm-6 col-xs-12">
        <div class="row">
            <div class="col-xs-5 contact-name">
                <?php echo $page_content->header->address; ?> <i class="fa fa-map-marker"></i>:
            </div>
            <div class="col-xs-offset-1 col-xs-6 contact-text">
                <?php echo $page_content->text->address; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-5 contact-name">
                <?php echo $page_content->header->phone; ?> <i class="fa fa-phone"></i>:
            </div>
            <div class="col-xs-offset-1 col-xs-6 contact-text">
                <?php echo $page_content->text->phone; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-5 contact-name">
                <?php echo $page_content->header->email; ?> <i class="fa fa-envelope"></i>:
            </div>
            <div class="col-xs-offset-1 col-xs-6 contact-text">
                <?php echo $page_content->text->email; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-5 contact-name">
                <?php echo $page_content->header->vk; ?> <i class="fa fa-vk"></i>:
            </div>
            <div class="col-xs-offset-1 col-xs-6 contact-text">
                <a href="http://vkontakte.ru/id22702354?49626"><?php echo $page_content->text->vk; ?></a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-5 contact-name">
                <?php echo $page_content->header->linkedin; ?> <i class="fa fa-linkedin"></i>:
            </div>
            <div class="col-xs-offset-1 col-xs-6 contact-text">
                <a href="https://ua.linkedin.com/in/andrey-kurmel-9a83b5112"><?php echo $page_content->text->linkedin; ?></a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-5 contact-name">
                <?php echo $page_content->header->github; ?> <i class="fa fa-github"></i>:
            </div>
            <div class="col-xs-offset-1 col-xs-6 contact-text">
                <a href="https://github.com/Shenyar"><?php echo $page_content->text->github; ?></a>
            </div>
        </div>
    </div>
</div>
