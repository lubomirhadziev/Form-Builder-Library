<?php

namespace libraries\FormBuilder\Configurations;

class Field
{

    /**
     * If we do not want to add this field by default from query
     * @var boolean
     */
    public $manuallyAdd = false;
    /**
     * If our field is for upload files set this to true
     * @var boolean
     */
    public $fieldFileUpload = false;
    /**
     * Set field only for one language
     * @var string
     */
    public $onlyForLanguage = '';
    /**
     * Define lanauge of field
     * @var string
     */
    public $languageShort = '';
    /**
     * Contain name of presentation view
     * @var string
     */
    protected $presentationName = null;
    /**
     * Set default layout
     * @var string
     */
    protected $belongsToLayout = '1col';
    /**
     * Describe all validations to run on this field
     * @var array
     */
    protected $validations = [];
    /**
     * Describe all live validations to run on this field
     * @var array
     */
    protected $liveValidations = [];
    /**
     * Contain all field info
     * @var array
     */
    protected $fieldInfo = [
        'help' => '',
    ];

    public function __call($name, $arguments)
    {
        if ($name == 'fieldName')
        {
            return $this->fieldNameBase() . '_' . $this->languageShort;
        }
    }

    /**
     * Contain name of field
     * @return string
     */
    public function fieldNameBase()
    {
        return '';
    }

    /**
     * Get field info
     * @return array
     */
    public function getFieldInfo()
    {
        return $this->fieldInfo;
    }

    /**
     * type - default, search
     * @return array
     */
    public function selectConfig()
    {
        return [
            'type' => 'default',
        ];
    }

    /**
     * Return all options from field
     * @return array
     */
    public function selectOptions()
    {
        return [];
    }

    /**
     * Set custom radio buttons config
     * type   - inline, newline
     * color  - red, green, teal, orange, purple, yellow, square-(-||-), flat-(-||-)
     * @return array
     */
    public function radioConfig()
    {
        return [
            'type'  => 'inline',
            'color' => '',
            'style' => '',
        ];
    }

    /**
     * Declare all radio buttons
     * @return array
     */
    public function radioButtons()
    {
        return [];
    }

    /**
     * Return all validations on field
     * @return array
     */
    public function getValidations()
    {
        return $this->validations;
    }

    /**
     * Get all live validations (perfom with js)
     * @return array
     */
    public function getLiveValidations()
    {
        return $this->liveValidations;
    }

    /**
     * Determine whether or not exists exact validation on field
     * @param string $validation
     * @return boolean
     */
    public function hasValidation($validation)
    {
        if (in_array($validation, $this->validations))
        {
            return true;
        }

        return false;
    }

    /**
     * Get name of layout
     * @return string
     */
    public function getLayout()
    {
        return $this->belongsToLayout;
    }

    /**
     * Set presentation name
     * @param string $presentationName
     */
    public function setPresentation($presentationName)
    {
        $this->presentationName = $presentationName;
    }

    /**
     * Get name of presentation view
     * @return string
     */
    public function getPresentationName()
    {
        return $this->presentationName;
    }

    /**
     * Contain name of db field
     * @return string
     */
    public function dbField()
    {
        return '';
    }


    /**
     * Contain title of input
     * @return string
     */
    public function title()
    {
        return '';
    }


    /**
     * If we wanna have placeholder
     * @return string
     */
    public function placeholder()
    {
        return '';
    }


    /**
     * Custom css
     * @return string
     */
    public function style()
    {
        return '';
    }


    /**
     * Before showed we need perfom some actions on field
     * @param string $inputOld
     * @param string $dbFieldValue
     * @return string
     */
    public function processBeforeShow($inputOld = null, $dbFieldValue = null)
    {
        return (empty($inputOld) ? $dbFieldValue : $inputOld);
    }


    /**
     * Before added if we need to perfom some actions on field
     * @param string $value
     * @return string
     */
    public function attachToQueryBeforeAdd($value)
    {
        return $value;
    }


    /**
     * Attach after query
     * @param array $allowedFields
     * @param array $inputs
     * @param integer $fieldId
     */
    public function attachAfterQuery($allowedFields, $inputs, $fieldId, $oldInputs)
    {
        
    }


    /**
     * Perfom some actions on data
     * @param object $data
     * @return object
     */
    public function processDataBeforeUse($data = null)
    {
        return $data;
    }


}
