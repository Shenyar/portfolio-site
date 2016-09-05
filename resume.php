<?php
$page_content = json_decode( file_get_contents("resume$lang.json") );
?>
<div class="resume">
    <div id="accordion">
        <h3>
            <a href="#">
                <span class="resume-bold"><?php echo $page_content->summary->header; ?></span>
            </a>
        </h3>
        <div>
            <p><?php echo $page_content->summary->text->p1; ?></p>
            <p><?php echo $page_content->summary->text->p2; ?></p>
            <p><?php echo $page_content->summary->text->p3; ?></p>
        </div>
        <h3>
            <a href="#">
                <span class="resume-bold"><?php echo $page_content->skills->header; ?></span>
            </a>
        </h3>
        <div>
            <ul>
                <span class="resume-bold"><?php echo $page_content->skills->text->languages; ?></span>
                <li>
                    <span class="resume-lined">JavaScript</span> (jQuery, jQuery-UI);
                </li>
                <li>
                    <span class="resume-lined">AngularJS</span> (SPA);
                </li>
                <li>
                    <span class="resume-lined">PHP</span> (<?php echo $page_content->skills->text->php; ?>);
                </li>
                <li>
                    <span class="resume-lined">SQL</span> (<?php echo $page_content->skills->text->sql; ?>);
                </li>
                <li>
                    <span class="resume-lined">HTML5/CSS3</span> (Bootstrap, Perfect Pixel);
                </li>
                <li>
                    <span class="resume-lined">C++</span> (<?php echo $page_content->skills->text->cpp; ?>);
                </li>
                <li>
                    <?php echo $page_content->skills->text->experience; ?>
                </li>
            </ul>
            <ul>
                <span class="resume-bold"><?php echo $page_content->skills->text->other; ?></span>
                <li>
                    <span class="resume-lined">Adobe Photoshop</span> (<?php echo $page_content->skills->text->photoshop; ?>);
                </li>
                <li>
                    <span class="resume-lined"><?php echo $page_content->skills->text->lang_hdr; ?></span>
                    : <?php echo $page_content->skills->text->lang_txt; ?>
                </li>
            </ul>
        </div>
        <h3>
            <a href="#">
                <span class="resume-bold"><?php echo $page_content->employment->header; ?></span>
            </a>
        </h3>
        <div>
            <ul>
                <span class="resume-bold"><?php echo $page_content->employment->text->place; ?></span>
                <li>
                    <?php echo $page_content->employment->text->info1; ?>
                </li>
                <li>
                    <?php echo $page_content->employment->text->info2; ?>
                </li>
                <li>
                    <?php echo $page_content->employment->text->info3; ?>
                </li>
            </ul>
        </div>
        <h3>
            <a href="#">
                <span class="resume-bold"><?php echo $page_content->education->header; ?></span>
            </a>
        </h3>
        <div>
            <ul>
                <span class="resume-bold"><?php echo $page_content->education->text->place; ?></span>
                <li>
                    <?php echo $page_content->education->text->info1; ?>
                </li>
                <li>
                    <?php echo $page_content->education->text->info2; ?>
                </li>
                <li>
                    <?php echo $page_content->education->text->info3; ?>
                </li>
            </ul>
        </div>
    </div>
</div>