<?php

namespace libraries\FormBuilder\Configurations\Products\Fields;

class OldAmount extends \libraries\FormBuilder\Configurations\Field implements \libraries\FormBuilder\Interfaces\IField
{

    protected $belongsToLayout = '1col';


    public function __construct()
    {
        //set validations on field
        $this->validations = [
            'numeric',
        ];

        //set live validations on field
        $this->liveValidations = [
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
        return 'old_amount';
    }


    public function fieldNameBase()
    {
        return 'old_amount';
    }


    public function title()
    {
        return 'Стара цена';
    }


}
