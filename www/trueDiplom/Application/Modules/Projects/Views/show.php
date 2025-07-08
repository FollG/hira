<head>
    <title><?=$this->title?></title>
    <?php
    \Core\SViews::getBaseTemplateHead();
    \Core\SViews::getBaseTemplateCss($libs);
    ?>
</head>
<?php require "Application/Modules/Home/Views/menu.php";?>

<div class="content-wrapper">
    <div class="data-block">

    </div>
</div>

<script>
    <?php
    \Core\SViews::getBaseTemplateJS($libs, false);exit;
    ?>
</script>