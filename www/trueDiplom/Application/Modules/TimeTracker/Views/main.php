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
        <div>

        </div>
    </div>
</div>

<div class="modal micromodal-slide" data-micromodal-trigger="modal-1" id="modal-1" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header">
                <h2 class="modal__title" id="modal-1-title">
                    TimeTracker
                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-1-content">
                <div>
                    <label for="time">Выберите задачу:</label>
                    <input id="time" name="time"/>
                </div>
                <div>
                    <label for="time">Выставите потраченное время</label>
                    <input id="time" name="time"/>
                </div>
            </main>
            <footer class="modal__footer">
                <button class="modal__btn modal__btn-primary">Продолжить</button>
                <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Отмена</button>
            </footer>
        </div>
    </div>
</div>

<script>
    <?php
    \Core\SViews::getBaseTemplateJS($libs, false);exit;
    ?>
</script>
<script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>