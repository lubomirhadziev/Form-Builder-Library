<?php

namespace libraries\FormBuilder\Configurations\Users\Fields;

class Admin extends \libraries\FormBuilder\Configurations\Field implements \libraries\FormBuilder\Interfaces\IField
{

    protected $belongsToLayout = '1col';


    public function __construct()
    {
        // set validations on field
        $this->validations = [
            'required',
        ];

        // set live validations on field
        $this->liveValidations = [
        ];

        // set field info
        $this->fieldInfo = [
            'help' => '',
        ];

        // set presentation view
        $this->setPresentation('select_default');
    }


    public function selectConfig()
    {
        return [
            'type' => 'search',
        ];
    }


    public function selectOptions()
    {
        return [
            [
                'title' => 'Да',
                'value' => 1,
            ],
            [
                'title' => 'Не',
                'value' => 0,
            ],
        ];
    }


    public function dbField()
    {
        return 'admin';
    }


    public function fieldNameBase()
    {
        return 'admin';
    }


    public function title()
    {
        return 'Администратор';
    }

}