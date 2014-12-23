<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\mongodb\Collection;
use Yii;
use yii\mongodb\Query;

/**
 * This command can create or remove users.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class UserController extends Controller
{
    public function actionCreate($username, $password)
    {
        //check for existence
        $data = (new Query)->from('users')->where(['username' => $username])->one();
        if ($data && $data['_id']){
            echo "Error: User with name $username exists. \nID: ".$data['_id'];
        }else{
            //create new user
            $collection = Yii::$app->mongodb->getCollection('users');
            $pass = crypt($password, 'rl');
            $userId = $collection->insert([
                'username' => $username,
                'create_date'=>time(),
                'password'=>$pass
            ]);

            echo "User created. ID:".$userId;
        }
    }
    public function actionRemove($username){
        $collection = Yii::$app->mongodb->getCollection('users');
        if ($collection->remove(['username' => $username], ["justOne" => true])){
            echo "User removed";
        }else{
            echo "Error: User with name $username doesn`t exist.";
        }
    }
}
