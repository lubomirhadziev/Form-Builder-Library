<?php

namespace libraries\FormBuilder\Configurations\Users\Fields;

class Password extends \libraries\FormBuilder\Configurations\Field implements \libraries\FormBuilder\Interfaces\IField
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
            'help' => '',
        ];

        // set presentation view
        $this->setPresentation('pass_input');
    }

    public function title()
    {
        return 'Нова парола';
    }


    public function dbField()
    {
        return 'password';
    }


    public function fieldName()
    {
        return 'password';
    }


    public function processBeforeShow($inputOld = null, $dbFieldValue = null)
    {
        return '';
    }


    public function attachToQueryBeforeAdd($value)
    {
        $oldData = \Helpers\Registry::getInstance()->getData('form_db_fields');
        $value   = trim($value);

        if (!empty($value))
        {
            return \Hash::make($value);
        }
        else
        {
            return $oldData->password;
        }
    }


}
