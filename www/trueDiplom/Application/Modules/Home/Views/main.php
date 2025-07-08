<head>
    <title><?=$this->title?></title>
    <?php
    \Core\SViews::getBaseTemplateHead();
    \Core\SViews::getBaseTemplateCss($libs);
    ?>
</head>
<?php require "Application/Modules/Home/Views/menu.php";?>
<div class="content-wrapper">
    <div class="home-projects_container">
        <?php include 'forms/projects.php'?>
    </div>
    <div class="home-task-tracker_row">
        <div class="home-tasks_container">
            <?php include "forms/tasks.php";?>
        </div>
        <div class="home-timetracker_container">
            <?php include "forms/timetracker.php"?>
        </div>
    </div>
</div>

<script>
    <?php
    \Core\SViews::getBaseTemplateJS($libs, false);exit;
    ?>
</script>