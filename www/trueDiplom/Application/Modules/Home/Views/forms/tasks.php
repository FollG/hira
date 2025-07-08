
<div style="width: 100%;height: 100%">
    <div class="block-header">
        Задачи
    </div>
    <div class="tasks-body">
        <?php
        foreach ($data['tasks'] as $k => $v) {
            ?>
            <div class="task-item">
                <div class="task-avatar task-point">
                </div>

                <div class="task-name task-point">
                    <a class="task-name" data-id="<?= $v['id']?>"><?= $v['task_name']; ?></a>
                </div>
                /
                <div class="task-project task-point">
                    <a class="project-name" data-id="<?= $v['project_id']?>"><?= $v['project_name']; ?></a>
                </div>
                /
                <div class="user-name task-point">
                    <a class="user-name" data-id="<?= $v['user_id'] ?>"><?= $v['user_name']?></a>
                </div>
                /
                <div class="task-urgency task-point">
                    <?= $v['urgency_name']?>
                </div>
                /
                <div class="task-opdate task-point">
                    <?= (new DateTime($v['opdate']))->format('H:i d M'); ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>