<?php

namespace libraries\FormBuilder\Configurations\Users\Fields;

class Email extends \libraries\FormBuilder\Configurations\Field implements \libraries\FormBuilder\Interfaces\IField
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
            'required: true',
        ];

        // set field info
        $this->fieldInfo = [
            'help' => '',
        ];

        // set presentation view
        $this->setPresentation('text_input');
    }


    public function dbField()
    {
        return 'email';
    }


    public function fieldName()
    {
        return 'email';
    }


    public function title()
    {
        return 'E-Mail адрес';
    }


}
