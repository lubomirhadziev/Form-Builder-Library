<?php

namespace libraries\FormBuilder\Configurations\Products\Fields;

class FileUpload extends \libraries\FormBuilder\Configurations\Field implements \libraries\FormBuilder\Interfaces\IField
{

    public    $manuallyAdd     = true;
    public    $fieldFileUpload = true;
    public    $onlyForLanguage = '';
    protected $belongsToLayout = '1col';

    public function __construct()
    {
        //get default language
        $defaultLanguage = \Language\Language::getInstance()->getDefaultLanguage();

        //set fiel upload field only for one language
        $this->onlyForLanguage = strtolower($defaultLanguage['short']);

        //set validations on field
        $this->validations = [
        ];

        //set live validations on field
        $this->liveValidations = [
        ];

        //set field info
        $this->fieldInfo = [
            'help' => '',
        ];

        //set presentation view
        $this->setPresentation('file_upload');
    }

    public function fieldNameBase()
    {
        return 'products';
    }

    public function title()
    {
        return 'Прикачете снимка/и';
    }

    public function processBeforeShow($inputOld = null, $dbFieldValue = null)
    {
        //get form id
        $formID = \Helpers\Registry::getInstance()->getData('form_id');

        //only for edit mode
        if ($formID > 0)
        {
            //find all files
            $files = \mvc\models\Files\Files::where('belongs_to_id', '=', $formID)
                ->where('belongs_to_type', '=', $this->dbField())
                ->select(['name'])
                ->get()
                ->toArray();

            //format files
            $filesToReturn = '';

            //array walk
            array_walk($files, function ($item, $key) use (&$filesToReturn)
            {
                $filesToReturn .= (empty($filesToReturn) ? $item['name'] : '|' . $item['name']);
            });

            //return formated files
            return $filesToReturn;
        }

        return '';
    }

    public function dbField()
    {
        return 'products';
    }


}
