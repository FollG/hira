<head>
    <title><?=$this->title?></title>
    <?php
    \Core\SViews::getBaseTemplateHead();
    \Core\SViews::getBaseTemplateCss($libs);
    ?>
</head>
<?php require "Application/Modules/Home/Views/menu.php";?>

<div class="content-wrapper">
    <div class="data-block" style="align-items: flex-start;justify-content: space-around;padding: 20px;width: 100%;height: fit-content;display: flex;flex-direction: row;flex-wrap: wrap;">
        <?php
//                var_dump($data);exit();
        foreach ($data['projects'] as $k => $v) {?>
            <div style="border-radius:10px; width: 200px; height: 200px;border: 2px solid #00008B; margin:10px;display:flex;flex-direction: column;">
                <div style="height: 25%;width: 100%; background-color: #00008B;border-radius:3px; display: flex;align-items:center;justify-content: center;">
                    <a style="color: #fff" class="project-name" data-id="<?= $v['id']?>"><?=$v['project_name']?> </a>
                </div>
                <div style="height: 75%;width:100%;background-color: #fff;border-radius:10px;display: flex;flex-direction: column;">
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<script>
    <?php
    \Core\SViews::getBaseTemplateJS($libs, false);exit;
    ?>
</script>