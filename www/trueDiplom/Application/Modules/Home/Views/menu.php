<div class="main-wrapper">
    <div class="home-header">
        <div class="home-header_logo">
            <a style="text-decoration: none;" href="/">🛜️ HIRA 🚹</a>
        </div>
        <div class="home-header_info">
            <div>
                <h2 style="margin-left: 30px; font-size: 30px;"><?= $this->title?></h2>
            </div>
            <div style="display: flex; flex-direction: row; justify-content: center;align-items: center">
                <div style="display: flex;flex-direction: row">
                    <div style="display: flex;justify-content: center;align-items: center">
                        <?php
                        $date = (new DateTime())->format('D, d M');
                        echo $date;
                        ?>
                    </div>
                    <div style="display: flex;justify-content: center;align-items: center">
                        <?php
                        $date2 = (new DateTime())->format('H:i, e');
                        echo $date2;
                        ?>
                    </div>
                </div>
                <div style="display:flex; justify-content: center;flex-direction: column; align-items: center;margin: 10px;">
                    <div class="user-avatar">

                    </div>
                    <div>
                        <span>
                            <?=$_SESSION['name'] ?? ''?>
                        </span>
                        <span>
                            <?=$_SESSION['surname'] ?? ''?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="home-data_row">
        <div class="home-menu">
            <div class="block-header">
                Меню
            </div>
            <div class="menu-body">
                <?php
                foreach ($data['menu'] as $k => $v) {?>
                    <a class="project-link" href="<?= $v['link'] ?>">
                        <div class="menu-item">
                            <div class="menu-item_icon">
                                <?= $v['icon']; ?>
                            </div>
                            <div class="menu-item_name">
                                <?= $v['name']; ?>
                            </div>
                        </div>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="content-window" style="width: 100%;height: 100%">
        </div>
    </div>
</div>
