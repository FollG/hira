<div style="width: 100%;height: 100%">
    <div class="block-header">
        TimeTracker
    </div>
    <div class="timetracker-container">
        <div style="display: flex; flex-direction: row;height: 87%;justify-content: space-around; padding-top:20px;">
            <?php
            $days = array_map(function ($day) {
                return strtolower(date_create('Sunday')->modify("+$day day")->format('l'));},
                range(1, 5)
            );
//            var_dump($data);exit();
            foreach ($days as $v) {
                ?>
                <div style="width: 18%; height: 95%;display: flex;justify-content: center;align-items: flex-start;flex-direction: column">
                    <div class="block-header">
                        <?= $v ?>
                    </div>
                    <?php
                        $json_data = json_decode($data['timetracker'][0][$v] ?? '[]', true);
                    ?>
                    <div style="width:100%;height: 100%; background-color:#F4F5F7;overflow: scroll">
                        <?php
                            $task_over = 0;
                            foreach ($json_data as $k => $v) {
                                $task_id = $v['task_id'];
                                $task_time = $v['time'];
                                $task_over += $task_time;
                                echo "<div style='background-color:#fff;border-radius:6px;display: flex;flex-direction: column;border: 2px solid #00008B; padding: 5px;margin:5px;'>
                                        <div style='display: flex;'>
                                            <a class='task-name' data-id='$task_id'>Задача №$task_id</a> 
                                        </div>
                                        <div style='display: flex;'>
                                            Время: $task_time
                                        </div>
                                        </div>";
                            }
                        ?>

                    </div>
                    <div>Всего времени: <?= $task_over?></div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>