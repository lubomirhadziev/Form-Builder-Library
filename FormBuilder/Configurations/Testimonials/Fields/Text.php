<?php

namespace libraries\FormBuilder\Configurations\Testimonials\Fields;

class Text extends \libraries\FormBuilder\Configurations\Field implements \libraries\FormBuilder\Interfaces\IField
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
        $this->setPresentation('textarea_summernote');
    }


    public function dbField()
    {
        return 'text';
    }


    public function fieldNameBase()
    {
        return 'text';
    }


    public function title()
    {
        return 'Текст';
    }


    public function processDataBeforeUse($data = null)
    {
        if (!empty($data))
        {
            return strip_tags(htmlspecialchars_decode($data));
        }

        return null;
    }


    public function attachToQueryBeforeAdd($value)
    {
        return htmlspecialchars(($value));
    }


}
