<?php

namespace libraries\FormBuilder\Configurations\Users\Fields;

class Birthday extends \libraries\FormBuilder\Configurations\Field implements \libraries\FormBuilder\Interfaces\IField
{

    protected $belongsToLayout = '1col';


    public function __construct()
    {
        // set validations on field
        $this->validations = [
        ];

        // set live validations on field
        $this->liveValidations = [
        ];

        // set field info
        $this->fieldInfo = [
            'help' => 'Формат на датата YYYY-mm-dd',
        ];

        // set presentation view
        $this->setPresentation('text_input');
    }


    public function dbField()
    {
        return 'birthday';
    }


    public function fieldName()
    {
        return 'Дата на раждане';
    }


    public function title()
    {
        return 'birthday';
    }

}