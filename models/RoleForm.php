<?php

namespace app\models;

use Override;
use yii\base\Model;

class RoleForm extends Model
{
    public ?string $name = '';
    public ?string $description = '';

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 64],
            [['description'], 'string']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Role Name',
            'description' => 'Description'
        ];
    }
}
