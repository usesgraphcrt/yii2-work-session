<?php
namespace pistol88\worksess;

use yii;

class Module extends \yii\base\Module
{
    public $adminRoles = ['superadmin', 'admin'];
    public $userModel = 'common\models\User';
    public $adminModel = 'common\models\User';
    public $workers = null;
    public $hoursCount = 12;
    public $shifts = [
        '07:00' => 'Дневная смена',
        '19:00' => 'Ночная смена',
    ];
    public $stafferProfileUrl = '/staffer/staffer/view';
    
    public function init()
    {        
        return parent::init();
    }
    
    public function getUserModel($userId)
    {
        $userModel = $this->userModel;

        return $userModel::findOne($userId);
    }
    
    public function getAdminModel($userId)
    {
        $userModel = $this->adminModel;
        
        return $userModel::findOne($userId);
    }
    
    public function getWorkersList()
    {
        if(is_callable($this->workers)) {
            $values = $this->workers;
            
            return $values();
        }
        
        return [];
    }
}