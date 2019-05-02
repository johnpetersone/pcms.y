<?php

namespace app\models;

use Yii;
use yii\base\Model;

class editForm extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'pages';
    }

    public function rules() {		
        return [
            [ [ 'page', 'title', 'html' ], 'required' ],
            [ [ 'page', 'title', 'html', 'description', 'keywords' ], 'string' ],
        ];
    }

    public function attributeLabels() {
        return [
            'html'         	=> 'HTML',
            'title'        	=> 'Cím',
            'page'         	=> 'Oldal URL',
			'description'	=> 'Meta leírás', 
			'keywords'		=> 'Meta kulcsszavak',
        ];
    }


}
