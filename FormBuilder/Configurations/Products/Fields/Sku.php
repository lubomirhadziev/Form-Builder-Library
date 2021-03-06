<?php

namespace libraries\FormBuilder\Configurations\Products\Fields;

class Sku extends \libraries\FormBuilder\Configurations\Field implements \libraries\FormBuilder\Interfaces\IField
{

    protected $belongsToLayout = '1col';


    public function __construct()
    {
        //set validations on field
        $this->validations = [
            'max:100',
        ];

        //set live validations on field
        $this->liveValidations = [
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
        return 'sku';
    }

    public function fieldNameBase()
    {
        return 'sku';
    }


    public function title()
    {
        return 'SKU (продуктов код)';
    }


}
