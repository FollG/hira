<head>
    <title><?=$this->title?></title>
    <?php
    \Core\SViews::getBaseTemplateHead();
    \Core\SViews::getBaseTemplateCss($libs);
    ?>
</head>
<?php require "Application/Modules/Home/Views/menu.php";?>
<div class="content-wrapper">
    <div class="data-block" style="padding: 20px;">
        <?php
        $user = $data['user'][0];
        ?>

        <div style="display:flex;">
            <div style="width: 128px;height: 128px;background-color: black; border-radius: 10px;"></div>
            <div style="padding: 20px;display: flex;flex-direction: column">
                <span style="font-size:47px;"> <?= $user['user_name']?> </span>
                <span style="font-size:36px;"> <?= $user['role_name']?> </span>
            </div>
        </div>
        <div style="padding: 20px;">
            <div style="display: flex;flex-direction: column;width: 500px;">
                <div><span style="font-size:36px;">Способы связи:</span></div>
                <div><span style="width: 300px;font-size:24px;">E-mail:</span><span style="font-size:24px;"> <?= $user['email']?> </span></div>
               <div><span style="width: 300px;font-size:24px;">Телефон:</span><span style="font-size:24px;"> <?= $user['phone_number']?> </span></div>
                <div><span style="width: 300px;font-size:24px;">День рождения:</span><span style="font-size:24px;"> <?= (new DateTime($user['birthday']))->format('d M')?> </span></div>
            </div>
        </div>
    </div>
</div>

<script>
    <?php
    \Core\SViews::getBaseTemplateJS($libs, false);exit;
    ?>
</script>