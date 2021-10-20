<?php
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-md-8">
        <div id="map" style="width: 100%; height: 480px;"></div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <h4 style="color: white">สัญลักษณ์(Symbols)</h4>
            </div>
            <div class="panel-body">
                <?php $url = Url::to('@web/uploads/icon/'); ?>    
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <tr>
                                <td><img src="<?= $url.'home.png'; ?>"></td>
                                <td>ชุมชน(Community)</td>
                            </tr>
                            <tr>
                                <td><img src="<?= $url.'tambonheadman.png'; ?>"></td>
                                <td>กำนัน(Tambon Headman)</td>
                            </tr>
                            <tr>
                                <td><img src="<?= $url.'villageheadman.png'; ?>"></td>
                                <td>ผู้ใหญ่บ้าน(Village Headman)</td>
                            </tr>
                            <tr>
                                <td><img src="<?= $url.'localwisdom.png'; ?>"></td>
                                <td>ปราชญ์ชาวบ้าน(Local Wisdom)</td>
                            </tr>
                            <tr>
                                <td><img src="<?= $url.'nature.png'; ?>"></td>
                                <td>สถานที่ธรรมชาติ(Nature Place)</td>
                            </tr>
                            <tr>
                                <td><img src="<?= $url.'career.png'; ?>"></td>
                                <td>กลุ่มอาชีพ(Career)</td>
                            </tr>
                            <tr>
                                <td><img src="<?= $url.'tower.png'; ?>"></td>
                                <td>ปราสาท(Historic Place)</td>
                            </tr>
                            <tr>
                                <td><img src="<?= $url.'museum.png'; ?>"></td>
                                <td>พิพิธภัณฑ์(Museum)</td>
                            </tr>
                            <tr>
                                <td><img src="<?= $url.'building.png'; ?>"></td>
                                <td>ศาสนสถาน(Religious Place)</td>
                            </tr>
                            <tr>
                                <td><img src="<?= $url.'hospital.png'; ?>"></td>
                                <td>โรงพยาบาล(Hospital)</td>
                            </tr>
                            <tr>
                                <td><img src="<?= $url.'police.png'; ?>"></td>
                                <td>สถานีตำรวจ(Police Station)</td>
                            </tr>
                            <tr>
                                <td><img src="<?= $url.'tour.png'; ?>"></td>
                                <td>จุดบริการนักท่องเที่ยว(Tourist service center)</td>
                            </tr>
                            <tr>
                                <td><img src="<?= $url.'restaurant.png'; ?>"></td>
                                <td>ร้านอาหาร(Restaurant)</td>
                            </tr>
                            <tr>
                                <td><img src="<?= $url.'hotel.png'; ?>"></td>
                                <td>โรงแรม(Hotel)</td>
                            </tr>
                            <tr>
                                <td><img src="<?= $url.'homestay.png'; ?>"></td>
                                <td>โฮมสเตย์(Homestay)</td>
                            </tr>
                            <tr>
                                <td><img src="<?= $url.'gas.png'; ?>"></td>
                                <td>ปั๊มน้ำมัน(Gas Station)</td>
                            </tr>
                            <!--<tr>
                                <td><img src="<?php //echo $url.'tourist.png'; ?>"></td>
                                <td>สถานที่ไม่อยู่ในชุมชน(Place is not near Community)</td>
                            </tr>-->
                        </table>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>  