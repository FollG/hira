<head>
    <title><?=$this->title?></title>
    <?php
    \Core\SViews::getBaseTemplateHead();
    \Core\SViews::getBaseTemplateCss($libs);
    ?>
</head>

<?php
$task = $data['tasks'][0];
//var_dump($task);exit();
require "Application/Modules/Home/Views/menu.php";?>

<div class="content-wrapper">
    <div class="data-block">
        <div style="display: flex;flex-direction: column;padding: 20px;">
            <div style="display: inherit; flex-direction:row;">
                <div style="background-color: black; width: 48px;height:48px; border-radius: 6px;"></div>
                <div style="display: flex;flex-direction: column">
                    <div>
                        <a class="project-name" data-id="<?=$task['project_id']?>"><?=$task['project_name']?></a>---><a style="margin:15px;" class="task_name" data-id="<?= $task['id']?>">   <?=$task['task_name']?></a>
                    </div>
                    <div>
                        <h3 style="margin: 0; margin-left: 15px;font-size: 25px;">
                            <?= $task['task_name']?>
                        </h3>
                    </div>
                </div>
            </div>
            <div style="display:flex;flex-direction: row;margin-top:20px;">
                <button data-id="<?= $task['id']?>" id="add-task-comment" style="margin-right:10px;">Добавить комментарий</button>
                <button data-id="<?= $task['id']?>" id="check-on-user" style="margin-right:10px;">Назначить</button>
                <button data-id="<?= $task['id']?>" id="change-surgency" style="margin-right:10px;">Изменить приоритет</button>
                <button data-id="<?= $task['id']?>" id="change-status" style="margin-right:10px;">Изменить статус</button>
                <button data-id="<?= $task['id']?>" id="set-timetracker" style="margin-right:10px;">Вести журнал работы</button>
            </div>
            <div style="display: flex;flex-direction: row;justify-content: space-between">
                <div style="padding: 20px;">
                    <span>
                        Детали задачи
                    </span>
                    <div style="display: flex;">
                        <div style="display: flex;flex-direction: column; padding:20px;width: 100%">
                            <div style="display: flex;margin: 5px;"><span style="width: 100px;">Приоритет: </span><span><?= '  '.$task['urgency_name']?></span></div>
                            <div style="display: flex;margin: 5px;"><span style="width: 100px;">Статус: </span> <span><?= '  '.$task['status_name']?> </span></div>
                            <div style="display: flex;margin: 5px;"><span style="width: 100px;">Обновлено: </span> <span><?= '  '.(!empty($task['opdate']) ? ((new DateTime($task['opdate']))->format('d M H:i')) : '-')?> </span></div>
                        </div>
                        <div style="display: flex;margin: 5px;flex-direction: column; padding:20px; width: 100%">
                            <div style="display: flex;margin: 5px;"><span style="width: 100px;">Решение: </span> <span><?= '  '.(!empty($task['solution_name']) ? $task['solution_name'] : 'Нет решения')?> </span></div>
                            <div style="display: flex;margin: 5px;"><span style="width: 100px;">Создано: </span> <span><?= '  '.(!empty($task['create_date']) ? ((new DateTime($task['create_date']))->format('d M H:i')) : '-')?> </span></div>

                        </div>
                    </div>
                </div>
                <div style="padding: 20px;">
                    <span>
                        Пользователи
                    </span>
                    <div style="display: flex;flex-direction: column; padding:20px;width: 100%%">
                        <div style="display: flex;margin: 5px;"><span style="width: 150px;">Исполнитель: </span><a style="width: 150px;" class="user-name" data-id="<?= $task['user_id']?>"><?=$task['user_name']?></a></div>
                        <div style="display: flex;margin: 5px;"><span style="width: 150px;">Автор: </span> <a style="width: 150px;" class="user-name" data-id="<?= $task['creator_id']?>"><?=$task['creator_name']?> </a></div>
                    </div>
                </div>
            </div>
            <div style="padding: 20px;display:flex;flex-direction: column">
                <span>Описание: </span>
                <span style="padding:20px;width: 100%;height: fit-content;text-wrap: normal">
                    <?= $task['task_description'] ?>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="modal micromodal-slide" data-micromodal-trigger="modal-1" id="modal-1" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header">
                <h2 class="modal__title" id="modal-1-title">
                    Добавить комментарий
                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-1-content">
                <div>
                    <label for="comment">Введите комментарий:</label>
                    <input id="comment" name="comment"/>
                </div>
            </main>
            <footer class="modal__footer">
                <button class="modal__btn modal__btn-primary">Продолжить</button>
                <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Отмена</button>
            </footer>
        </div>
    </div>
</div>

<div class="modal micromodal-slide" data-micromodal-trigger="modal-2" id="modal-2" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-2-title">
            <header class="modal__header">
                <h2 class="modal__title" id="modal-2-title">
                    Назначить задачу
                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-2-content">
                <div>
                    <label for="user">Выберите пользователя:</label>
                    <select id="user" name="user">
                        <?php
                            foreach ($data['users'] as $k => $v) {
                                echo '<option user-id="'.$v['user_id'].'">'.$v['user_name'].'</option>';
                            }
                        ?>
                    </select>
                </div>
            </main>
            <footer class="modal__footer">
                <button class="modal__btn modal__btn-primary2">Продолжить</button>
                <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Отмена</button>
            </footer>
        </div>
    </div>
</div>

<div class="modal micromodal-slide" data-micromodal-trigger="modal-3" id="modal-3" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-3-title">
            <header class="modal__header">
                <h2 class="modal__title" id="modal-3-title">
                    Изменить приоритет
                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-3-content">
                <div>
                    <label for="surgency">Выберите приоритет:</label>
                    <select id="surgency" name="surgency">
                        <?php

                        foreach ($data['urgency'] as $k => $v) {
                            echo '<option urgency-name="'.$v['id'].'">'.$v['name'].'</option>';
                        }
                        ?>
                    </select>
                </div>
            </main>
            <footer class="modal__footer">
                <button class="modal__btn modal__btn-primary3">Продолжить</button>
                <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Отмена</button>
            </footer>
        </div>
    </div>
</div>

<div class="modal micromodal-slide" data-micromodal-trigger="modal-4" id="modal-4" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-4-title">
            <header class="modal__header">
                <h2 class="modal__title" id="modal-4-title">
                    Изменить статус
                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-4-content">
                <div>
                    <label for="status">Выберите статус:</label>
                    <select id="status" name="status">
                        <?php
                        foreach ($data['statuses'] as $k => $v) {
                            echo '<option status-id="'.$v['id'].'">'.$v['name'].'</option>';
                        }
                        ?>
                    </select>
                </div>
            </main>
            <footer class="modal__footer">
                <button class="modal__btn modal__btn-primary4">Продолжить</button>
                <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Отмена</button>
            </footer>
        </div>
    </div>
</div>

<div class="modal micromodal-slide" data-micromodal-trigger="modal-5" id="modal-5" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-5-title">
            <header class="modal__header">
                <h2 class="modal__title" id="modal-5-title">
                    Вести журнал работы
                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-5-content">
                <div>
                    <label for="time">Введите количество часов:</label>
                    <input id="time" name="time" type="number"/>
                </div>
            </main>
            <footer class="modal__footer">
                <button class="modal__btn modal__btn-primary5">Продолжить</button>
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