<?php
use yii\helpers\Url;
$user_login = $session['user_login'];
$mainMenu = Yii::$app->db->createCommand("
    WITH CTE_USER AS (
        SELECT USER_ID FROM BB_USER WHERE USER_LOGIN = '$user_login'
    )
    , CTE_ROLE AS (
    SELECT 
    BB_USER_ROLE.USER_ID
    , BB_USER_ROLE.ROLE_ID
    FROM BB_USER_ROLE
    INNER JOIN CTE_USER ON BB_USER_ROLE.USER_ID = CTE_USER.USER_ID
    where BB_USER_ROLE.USER_ID = CTE_USER.USER_ID
    )
    , CTE_BB_ROLE_OPERATION AS (
    SELECT OPERATION_ID, BB_ROLE_OPERATION.ROLE_ID
    FROM BB_ROLE_OPERATION
    INNER JOIN CTE_ROLE ON BB_ROLE_OPERATION.ROLE_ID = CTE_ROLE.ROLE_ID
    WHERE BB_ROLE_OPERATION.ROLE_ID = CTE_ROLE.ROLE_ID
    )
    , CTE_OPERATION AS (
    SELECT BB_OPERATION.OPERATION_ID, OPERATION_NAME_TH, OPERATION_URL, OPERATION_NO, display_order, CTE_BB_ROLE_OPERATION.ROLE_ID
    FROM BB_OPERATION
    INNER JOIN CTE_BB_ROLE_OPERATION ON BB_OPERATION.OPERATION_ID = CTE_BB_ROLE_OPERATION.OPERATION_ID
    where IS_ACTIVE = 'Y' AND PARENT_ID = 0 AND BB_OPERATION.OPERATION_ID = CTE_BB_ROLE_OPERATION.OPERATION_ID
    )
    
    SELECT * FROM CTE_OPERATION
    order by  display_order asc
")->queryAll();

$request = Yii::$app->request->queryString;
$request_substr = substr($request, 2);
$request_explode = explode("/", $request_substr);
$request_explode2 = explode("%2F", $request_substr);
//echo 'request /: '.$request_explode[0].'<hr>';
//echo 'request %2F: '.$request_explode2[0].'<hr>';
$request_replace = str_replace("/", "-group/", $request_substr);
// echo 'request_replace: '.$request_replace."<hr>";
//  if(strstr($request, $request_explode[0])){
//     echo 'Success';
// }
// else{
//     echo 'Error';
// }
//echo 'URL::to() => '.Url::to();
?>

<ul class="nav menu">

    <?php foreach ($mainMenu as $mainMenus) : ?>

        <li class="parent">
            <a data-toggle="collapse" href="#sub-item-<?php echo $mainMenus['operation_id']; ?>">
                <em class="fa fa-bars">&nbsp;</em> <?php echo $mainMenus['operation_name_th']; ?>
                <span data-toggle="collapse" href="#sub-item-10" class="icon pull-right">
                    <em class="fa fa-plus"></em>
                </span>
            </a>

            <?php
            $operation_no = $mainMenus['operation_no'];
            $role_id = $mainMenus['role_id'];
            $subMenu = Yii::$app->db->createCommand("
                SELECT operation_name_th, operation_url, parent_id, display_order
                FROM bb_operation
                inner join bb_role_operation on bb_operation.operation_id = bb_role_operation.operation_id
                where is_active = 'Y' and parent_id = $operation_no and operation_no is null and role_id = $role_id
                order by  display_order asc
            ")->queryAll();
            //print_r($mainMenus['operation_url']);
            //print_r($subMenu[0]['operation_url']);
            $subMenuexplode = explode("/", $subMenu[0]['operation_url']);
            $subMenuexplode2 = explode("%2F", $subMenu[0]['operation_url']);
            //echo 'subMenuexplode /: '.$subMenuexplode[0].'<hr>';
            //echo 'subMenuexplode %2F: '.$subMenuexplode2[0].'<hr>';
            // if($request_explode2[0] == $subMenuexplode[0])
            // {
            //     echo 'in';
            // }
            // else{
            //     echo 'Error';
            // }
            ?>

            <ul class="children collapse <?php if($request_explode2[0] == $subMenuexplode[0] || $request_explode[0] == $subMenuexplode[0]){echo 'in';} ?>" id="sub-item-<?php echo $mainMenus['operation_id']; ?>">
                <?php foreach ($subMenu as $subMenus) : ?>
                    <li>
                        <a class="<?php //if($request_substr == $subMenus['operation_url']){echo 'active';} ?>" href="index.php?r=<?php echo $subMenus['operation_url'] ?>">
                            <em class="fa fa-arrow-right">&nbsp;</em> <?php echo $subMenus['operation_name_th'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

        </li>

    <?php endforeach; ?>
    <li>
        <a href="index.php?r=account/logout">
            <em class="fa fa-sign-out">&nbsp;</em> ออกจากระบบ
        </a>
    </li>

</ul>