<?php

namespace libraries\FormBuilder\Configurations\Products\Fields;

class Amount extends \libraries\FormBuilder\Configurations\Field implements \libraries\FormBuilder\Interfaces\IField
{

    protected $belongsToLayout = '1col';


    public function __construct()
    {
        //set validations on field
        $this->validations = [
            'required',
            'numeric',
        ];

        //set live validations on field
        $this->liveValidations = [
            'required: true',
        ];

        //set field info
        $this->fieldInfo = [
            'help' => 'Въведете само сумата (цифрите) на избраната от Вас сума (без допълнителни символи)!',
        ];

        //set presentation view
        $this->setPresentation('text_input');
    }


    public function dbField()
    {
        return 'amount';
    }


    public function fieldNameBase()
    {
        return 'amount';
    }


    public function title()
    {
        return 'Цена';
    }


}
