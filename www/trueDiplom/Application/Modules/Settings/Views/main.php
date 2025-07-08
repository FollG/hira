<head>
    <title><?=$this->title?></title>
    <?php
    \Core\SViews::getBaseTemplateHead();
    \Core\SViews::getBaseTemplateCss($libs);
    ?>
</head>
<?php require "Application/Modules/Home/Views/menu.php";?>

<div class="content-wrapper">
    <div class="data-block main-settings-block" style="width: 100%">
        <div class="submain-settings-block">
            <div class="default-block add-project" >
                <div class="block-header">
                    Проекты
                </div>
                <div class="inform-block">
                    <div style="display: flex;flex-direction: column;padding: 20px;">
                        <label for="" >Добавить проект:</label>
                        <button class="modal__btn" name="add-project-button" id="add-project-button">Добавить</button>
                    </div>
                    <hr style="color: #00008B !important;"/>
                    <div style="display: flex;flex-direction: column;padding: 20px;">

                        <label for="delete-project">Удалить проект:</label>
                        <select style="margin: 5px;height: 30px;">
                            <?php
                                foreach ($data['projects'] as $k => $v) {
                                    echo "<option value=".$v['id'].">".$v['project_name']."</option>";
                                }
                            ?>
                        </select>
                        <button class="modal__btn" name="delete-project" id="delete-project">Удалить</button>
                    </div>
                </div>
            </div>
            <div class="default-block add-task">
                <div class="block-header">
                    Задачи
                </div>
                <div style="display: flex;flex-direction: column;padding: 20px;">
                    <label for="" >Добавить задачу:</label>
                    <button class="modal__btn add-button" name="add-task-button" id="add-task-button">Добавить</button>
                </div>
                <hr style="color: #00008B !important;"/>
                <div style="display: flex;flex-direction: column;padding: 20px;">

                    <label for="delete-project">Удалить задачу:</label>
                    <select size="5" style="margin: 5px;height: 65px;">
                        <?php
                            foreach ($data['tasks'] as $k => $v) {
                                echo "<option value=".$v['id'].">".'#'.$v['id'].':'.$v['task_name']."</option>";
                            }
                        ?>
                    </select>
                    <button class="modal__btn" name="delete-project" id="delete-project">Удалить</button>
                </div>
            </div>
            <div class="default-block add-status">
                <div class="block-header">
                    Статусы
                </div>
                <div style="display: flex;flex-direction: column;padding: 20px;">
                    <label for="" >Добавить статус:</label>
                    <button class="modal__btn add-button" name="add-status-button" id="add-status-button">Добавить</button>
                </div>
                <hr style="color: #00008B !important;"/>
                <div style="display: flex;flex-direction: column;padding: 20px;">

                    <label for="delete-status">Удалить статус:</label>
                    <select style="margin: 5px;height: 30px;">
                        <?php
                        foreach ($data['statuses'] as $k => $v) {
                            echo "<option value=".$v['id'].">".$v['name']."</option>";
                        }
                        ?>
                    </select>
                    <button class="modal__btn" name="delete-status" id="delete-status">Удалить</button>
                </div>
            </div>
            <div class="default-block add-urgency">
                <div class="block-header">
                    Приоритеты
                </div>
                <div style="display: flex;flex-direction: column;padding: 20px;">
                    <label for="" >Добавить приоритет:</label>
                    <button class="modal__btn add-button" name="add-urgency-button" id="add-urgency-button">Добавить</button>
                </div>
                <hr style="color: #00008B !important;"/>
                <div style="display: flex;flex-direction: column;padding: 20px;">

                    <label for="delete-urgency">Удалить приоритет:</label>
                    <select style="margin: 5px;height: 30px;">
                        <?php
                        foreach ($data['urgency'] as $k => $v) {
                            echo "<option value=".$v['id'].">".$v['name']."</option>";
                        }
                        ?>
                    </select>
                    <button class="modal__btn" name="delete-urgency" id="delete-urgency">Удалить</button>
                </div>
            </div>
            <div class="default-block add-user">
                <div class="block-header">
                    Пользователи
                </div>
                <div style="display: flex;flex-direction: column;padding: 20px;">
                    <label for="" >Добавить пользователя:</label>
                    <button class="modal__btn add-button" name="add-user-button" id="add-user-button">Добавить</button>
                </div>
                <hr style="color: #00008B !important;"/>
                <div style="display: flex;flex-direction: column;padding: 20px;">

                    <label for="delete-user">Удалить пользователя:</label>
                    <select style="margin: 5px;height: 30px;">
                        <?php
                        foreach ($data['users'] as $k => $v) {
                            echo "<option value=".$v['id'].">".$v['user_name'].' '.$v['user_surname']."</option>";
                        }
                        ?>
                    </select>
                    <button class="modal__btn" name="delete-user" id="delete-user">Удалить</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal micromodal-slide" data-micromodal-trigger="modal-project" id="modal-project" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-project-title">
            <header class="modal__header">
                <h2 class="modal__title" id="modal-project-title">
                    Добавить проект
                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-project-content">
                <div>
                    <label for="project-name">Введите название:</label>
                    <input id="project-name" name="project-name"/>
                </div>
            </main>
            <footer class="modal__footer">
                <button class="modal__btn modal__btn-primary-project">Продолжить</button>
                <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Отмена</button>
            </footer>
        </div>
    </div>
</div>

<div class="modal micromodal-slide" data-micromodal-trigger="modal-task" id="modal-task" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-task-title">
            <header class="modal__header">
                <h2 class="modal__title" id="modal-task-title">
                    Добавить задачу
                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-task-content">
                <div>
                    <label for="task-name">Введите название:</label>
                    <input id="task-name" name="task-name"/>
                </div>
            </main>
            <footer class="modal__footer">
                <button class="modal__btn modal__btn-primary-task">Продолжить</button>
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