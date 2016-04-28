<?php

namespace libraries\FormBuilder\Configurations\Products\Fields;

class Title extends \libraries\FormBuilder\Configurations\Field implements \libraries\FormBuilder\Interfaces\IField
{

    protected $belongsToLayout = '1col';


    public function __construct()
    {
        //set validations on field
        $this->validations = [
            'required',
            'max:100',
        ];

        //set live validations on field
        $this->liveValidations = [
            'required: true',
            'maxlength: 100',
        ];

        //set field info
        $this->fieldInfo = [
            'help' => '',
        ];

        //set presentation view
        $this->setPresentation('text_input');
    }


    public function dbField()
    {
        return 'title';
    }

    public function fieldNameBase()
    {
        return 'name';
    }


    public function title()
    {
        return 'Продукт';
    }


}
