<?php

use yii\helpers\Html;

$this->title = $model->researcher_technology_name;
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มเทคโนโลยี', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

    <p style="text-align:right">
    <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->researcher_technology_id], ['class' => 'btn btn-warning']) ?>
        <?=
        Html::a('ลบข้อมูล', ['delete', 'id' => $model->researcher_technology_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

        <div class="table-responsive">
            <?php foreach ($data as $value) : ?>
            <div class="row">

                <div class="col-md-4">
                    <?php echo Html::img('@web/uploads/research/technology'  . '/researcher_technology/' . $value['researcher_technology_image_cover'], ['style' => 'height:300px;width:300px;']); ?>
                </div>

                <div class="col-md-8">
                    <table class="table table-striped table-bordered">

                  

                        <tr>
                            <th>ชื่อกลุ่มวัฒนธรรม</th>
                            <td><?php echo $value['researcher_technology_group_name']; ?></td>
                        </tr>

                        <tr>
                            <th>ชื่อวัฒนธรรม</th>
                            <td><?php echo $value['researcher_technology_name']; ?></td>
                        </tr>

                        <tr>
                            <th>ชื่อภาษาอังกฤษ</th>
                            <td><?php echo $value['researcher_technology_name_en']; ?></td>
                        </tr>

                        <tr>
                            <th>รายละเอียด</th>
                            <td><?php echo $value['researcher_technology_detail']; ?></td>
                        </tr>

                        <tr>
                            <th>รายละเอียดภาษาอังกฤษ</th>
                            <td><?php echo $value['researcher_technology_detail_en']; ?></td>
                        </tr>

                    </table>
                </div>

            </div>

            <?php endforeach; ?>
        </div>

    </div>
</div>