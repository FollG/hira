
<div style="width: 100%;height: 100%">
    <div class="block-header">
        Проекты
    </div>
    <div class="projects-body">
        <?php
        foreach ($data['projects'] as $k => $v) {?>
            <div class="project-item">
                <div class="project-avatar">
<!--                    --><?php //= $v['icon']?>
                </div>
                <div class="project-name">
                    <a data-id="<?= $v['id'] ?>"><?= $v['project_name']?></a>
                </div>
                /
                <div class="project-stakeholder">
                    <div class="project-stakeholder-avatar">

                    </div>
                    <div class="project-stakeholder-name">
                         <span>
                            <a class="user-name" data-id="<?= $v['id'] ?>"><?= $v['user'] ?></a>
                        </span>
                    </div>
                    <div class="project-stakeholder-position">
                        <?= $v['role_name']?>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>