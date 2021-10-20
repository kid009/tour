<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

//เรียกใช้ไฟล์ css
$this->registerCssFile("@web/css/form.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::class],
]);
//เรียกใช้ไฟล์ js
$this->registerJsFile(
    '@web/js/form.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerJsFile(
    '@web/views/researcher-research/script.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
?>

<div class="stepwizard col-md-offset-3" style="margin-top: 10px;">
    <div class="stepwizard-row setup-panel">

        <div class="stepwizard-step">
            <a href="#step-1" type="button" class="btn btn-primary btn-circle btn-lg">1</a>
            <p>ข้อมูลทั่วไป</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">2</a>
            <p>นักวิจัยร่วม</p>
        </div>

    </div>
</div>

<?php $form = ActiveForm::begin(); ?>

<!-- step-1 -->
<div class="row setup-content" id="step-1">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?php
            // echo $form->field($modelResearchCommunity, 'community_id')->widget(
            //     Select2::className(),
            //     [
            //         'data' => ArrayHelper::map(\app\models\Community::find()->all(), 'community_id', 'community_name'),
            //         'language' => 'th',
            //         'options' => [
            //             'id' => 'ddl-community',
            //             'placeholder' => 'เลือกชุมชน...'
            //         ],
            //         'pluginOptions' => [
            //             'allowClear' => TRUE
            //         ]
            //     ]
            // )->label('ชุมชน');
            ?>

            <?= $form->field($model, 'research_name', ['enableAjaxValidation' => true])->textInput(['required' => true])->label('ชื่องานวิจัย') ?>

            <?= $form->field($model, 'research_code')->textInput(['maxlength' => true])->label('รหัสงานวิจัย') ?>

            <?php echo $form->field($model, 'research_budget')->textInput(['type' => 'number'])->label('งบประมาณ') ?>

            <div class="pull-right">
                <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
            </div>

        </div>
    </div>
</div>

<!-- step-2 -->
<div class="row setup-content" id="step-2">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?php
            //data_bussiness
            // $data_bussiness = ArrayHelper::map(\app\models\User::find()->distinct()
            //     ->innerJoin('bb_user_role', 'bb_user.user_id = bb_user_role.user_id')
            //     ->innerJoin('bb_role', 'bb_role.role_id = bb_user_role.role_id')
            //     ->where(['role_name' => 'bussiness'])
            //     ->all(), 'user_id', 'user_name');
            // print_r($data_bussiness);
            // echo '<hr>';    
            $bussiness = Yii::$app->db->createCommand("
            select bb_user.user_id, CONCAT(user_name, ' (', bussiness_name, ')') as user_name
            from bb_user
            left join bussiness on bb_user.user_login = bussiness.create_by
            inner join bb_user_role on bb_user.user_id = bb_user_role.user_id
            inner join bb_role on bb_role.role_id = bb_user_role.role_id
            where role_name = 'bussiness' and bb_user.is_active = 'Y'
            order by bb_user.user_id asc
            ")->queryAll();
            $data_bussiness = ArrayHelper::map($bussiness, 'user_id', 'user_name');
            // print_r($databb);
            // echo '<hr>';
            if ($model->isNewRecord) {
                echo '<label class="control-label">รายชื่อภาคธุรกิจ</label>';
                echo Select2::widget([
                    'name' => 'research_user_bussiness_id',
                    'data' => $data_bussiness,
                    'options' => [
                        'placeholder' => 'เลือกรายชื่อ...',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'maximumInputLength' => 10
                    ],
                ]);
            } else {
                echo '<label class="control-label">รายชื่อภาคธุรกิจ</label>';
                echo Select2::widget([
                    'name' => 'research_user_bussiness_id',
                    'value' => $research_user_bussiness_id, // initial value
                    'data' => $data_bussiness,
                    'options' => [
                        'placeholder' => 'เลือกรายชื่อ...',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'maximumInputLength' => 10
                    ],
                ]);
            }
            echo '<br>';
            //data_bussiness

            //data_community
            // $data_community = ArrayHelper::map(\app\models\User::find()->distinct()
            //     ->innerJoin('bb_user_role', 'bb_user.user_id = bb_user_role.user_id')
            //     ->innerJoin('bb_role', 'bb_role.role_id = bb_user_role.role_id')
            //     ->where(['role_name' => 'community'])
            //     ->all(), 'user_id', 'user_name');

            $community = Yii::$app->db->createCommand("
            select bb_user.user_id, concat(user_name, ' (', community_name, ')') as user_name
            from bb_user
            left join community on  bb_user.user_login = community.create_by
            inner join bb_user_role on bb_user.user_id = bb_user_role.user_id
            inner join bb_role on bb_role.role_id = bb_user_role.role_id
            where role_name = 'community' and bb_user.is_active = 'Y'
            order by bb_user.user_id asc
            ")->queryAll();
            $data_community = ArrayHelper::map($community, 'user_id', 'user_name');

            if ($model->isNewRecord) {
                echo '<label class="control-label">รายชื่อภาคชุมชน</label>';
                echo Select2::widget([
                    'name' => 'research_user_community_id',
                    'data' => $data_community,
                    'options' => [
                        'placeholder' => 'เลือกรายชื่อ...',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'maximumInputLength' => 10
                    ],
                ]);
            } else {
                echo '<label class="control-label">รายชื่อภาคชุมชน</label>';
                echo Select2::widget([
                    'name' => 'research_user_community_id',
                    'value' => $research_user_community_id, // initial value
                    'data' => $data_community,
                    'options' => [
                        'placeholder' => 'เลือกรายชื่อ...',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'maximumInputLength' => 10
                    ],
                ]);
            }
            echo '<br>';
            //data_community

            //data_tourism
            // $data_tourism = ArrayHelper::map(\app\models\User::find()->distinct()
            //     ->innerJoin('bb_user_role', 'bb_user.user_id = bb_user_role.user_id')
            //     ->innerJoin('bb_role', 'bb_role.role_id = bb_user_role.role_id')
            //     ->where(['role_name' => 'tourism'])
            //     ->all(), 'user_id', 'user_name');

            $data_tourism = ArrayHelper::map(Yii::$app->db->createCommand("
            select bb_user.user_id, concat(user_name, ' (', user_login, ')') as user_name
            from bb_user
            inner join bb_user_role on bb_user.user_id = bb_user_role.user_id
            inner join bb_role on bb_role.role_id = bb_user_role.role_id
            where role_name = 'tourism' and bb_user.is_active = 'Y'
            order by bb_user.user_id asc
            ")->queryAll(), 'user_id', 'user_name');

            if ($model->isNewRecord) {
                echo '<label class="control-label">รายชื่อนักท่องเที่ยว</label>';
                echo Select2::widget([
                    'name' => 'research_user_tourism_id',
                    'data' => $data_tourism,
                    'options' => [
                        'placeholder' => 'เลือกรายชื่อ...',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'maximumInputLength' => 10
                    ],
                ]);
            } else {
                echo '<label class="control-label">รายชื่อนักท่องเที่ยว</label>';
                echo Select2::widget([
                    'name' => 'research_user_tourism_id',
                    'value' => $research_user_tourism_id, // initial value
                    'data' => $data_tourism,
                    'options' => [
                        'placeholder' => 'เลือกรายชื่อ...',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'maximumInputLength' => 10
                    ],
                ]);
            }
            echo '<br>';
            //data_tourism

            // $data_researcher
            // $data_researcher = ArrayHelper::map(\app\models\User::find()->distinct()
            //     ->innerJoin('bb_user_role', 'bb_user.user_id = bb_user_role.user_id')
            //     ->innerJoin('bb_role', 'bb_role.role_id = bb_user_role.role_id')
            //     ->where(['role_name' => 'researcher'])
            //     ->all(), 'user_id', 'user_name');

            $data_researcher = ArrayHelper::map(Yii::$app->db->createCommand("
            select bb_user.user_id, concat(user_name, ' (', user_login, ')') as user_name
            from bb_user
            inner join bb_user_role on bb_user.user_id = bb_user_role.user_id
            inner join bb_role on bb_role.role_id = bb_user_role.role_id
            where role_name = 'researcher' and bb_user.is_active = 'Y'
            order by bb_user.user_id asc
            ")->queryAll(), 'user_id', 'user_name');

            if ($model->isNewRecord) {
                echo '<label class="control-label">รายชื่อนักวิจัย</label>';
                echo Select2::widget([
                    'name' => 'research_user_research_id',
                    'data' => $data_researcher,
                    'options' => [
                        'placeholder' => 'เลือกรายชื่อ...',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'maximumInputLength' => 10
                    ],
                ]);
            } else {
                echo '<label class="control-label">รายชื่อนักวิจัย</label>';
                echo Select2::widget([
                    'name' => 'research_user_research_id',
                    'value' => $research_user_research_id, // initial value
                    'data' => $data_researcher,
                    'options' => [
                        'placeholder' => 'เลือกรายชื่อ...',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'maximumInputLength' => 10
                    ],
                ]);
            }
            echo '<br>';
            // $data_researcher

            ?>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <?php echo Html::submitButton('บันทึก', ['class' => 'btn btn-success', 'id' => 'savebtn']) ?>
                <a href="<?php echo Url::to(['researcher-research/index']); ?>" class="btn btn-danger">
                    ยกเลิก
                </a>
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>