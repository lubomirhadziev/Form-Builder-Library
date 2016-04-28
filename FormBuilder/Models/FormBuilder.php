<?php

namespace libraries\Form\Models;

class FormBuilder
{

    protected $table;
    protected $connection;
    private   $mode = 'add';

    /**
     * @var \libraries\FormBuilder\FormBuilder
     */
    private $_form;

    /**
     * Contain array of validation rules for any fields
     * @var array
     */
    private $_validationRules = [];

    /**
     * Contain array of friendly input names for any fields
     * @var array
     */
    private $_friendlyInputNames = [];

    /**
     * Describe allowed fields to change
     * @var array
     */
    private $_allowFieldsChanges = [];

    /**
     * If mode of form is edit we need id of db field
     * @var integer
     */
    private $_dbFieldID = 0;

    /**
     * Contain all fields from structure
     * @var array
     */
    private $_allAllowedFields = [];


    public function __construct(&$form, $table, $connection, $mode = 'add', $id = 0)
    {
        $this->_form      = $form;
        $this->table      = $table;
        $this->connection = $connection;
        $this->mode       = ($mode == 'add' ? 'add' : 'edit');
        $this->_dbFieldID = (int)$id;
    }


    public function findResultByID($id)
    {
        $id = (int)$id;

        if ($id <= 0)
        {
            throw new \Exception('ID must be higher than zero');
        }
        else
        {
            return \DB::connection($this->connection)
                ->table($this->table)
                ->where('id', '=', $id)
                ->first();
        }
    }


    public function validate($inputs)
    {
        // throw exception if $inputs it's not array
        if (!is_array($inputs))
        {
            throw new Exception('Invalid inputs type for validation');
        }

        // set default connection
        $langClass   = \Language\Language::getInstance();
        $defaultLang = $langClass->getDefaultLanguage();

        $langClass->changeLanguage(strtolower($defaultLang['short']));
        $langClass->setCurrentDatabaseConnections();

        // init again
        $this->_init();

        //make validation
        $validator = \Validator::make($inputs, $this->_validationRules);
        $validator->setAttributeNames($this->_friendlyInputNames);

        if ($validator->fails())
        {
            // pass validator
            \Helpers\Registry::getInstance()->setData('validator', $validator);

            // throw exception
            throw new \Exception('Validations has failed.', 20);
        }
        else
        {
            $langClass    = \Language\Language::getInstance();
            $allLanguages = $this->_form->getAllowedLanguages();
            $id           = 0;

            foreach ($allLanguages as $language)
            {
                // change current language
                $langClass->changeLanguage(strtolower($language['short']));

                // set database connections
                $langClass->setCurrentDatabaseConnections();

                // init again
                $this->_init();

                // add new row
                if ($this->mode == 'add')
                {
                    $id = $this->_addRow($inputs);
                }

                // edit exists row
                if ($this->mode == 'edit')
                {
                    $id = $this->_editRow($inputs);
                }
            }

            return $id;
        }
    }

    /**
     * Init model with basic info for any fields like
     * validations rules or friendly name.
     */
    private function _init()
    {
        $defaultLanguage = \Language\Language::getInstance()->getCurrentLang();

        $this->_validationRules    = [];
        $this->_friendlyInputNames = [];
        $this->_allowFieldsChanges = [];
        $this->_allAllowedFields   = [];

        foreach ($this->_form->getStructure()->getFields() as $fields)
        {
            foreach ($fields as $field)
            {
                $customField                = $field;
                $customField->languageShort = strtolower($defaultLanguage['short']);

                $validationRules = implode('|', $customField->getValidations());

                // set validations for this field
                if (!empty($validationRules))
                {
                    $this->_validationRules[ $customField->fieldName() ] = $validationRules;

                    // set friendly name
                    $this->_friendlyInputNames[ $customField->fieldName() ] = $customField->title();
                }

                // add to allowed fields
                if ($customField->manuallyAdd == false)
                {
                    $this->_allowFieldsChanges[ $customField->dbField() ] = $customField->fieldName();
                }

                // add for after query changes
                $this->_allAllowedFields[ $customField->dbField() ] = $customField->fieldName();
            }
        }
    }

    private function _addRow($inputs)
    {
        // make reflection class
        $reflectionClass = new \ReflectionClass($this->_form->getStructure()->getNamespaceModel());

        // new instance of object
        $object = $reflectionClass->newInstance();

        //process all inputs before add
        $processedInputs = $this->_processedBeforeAdd($inputs);

        // append all allowed fields
        foreach ($this->_allowFieldsChanges as $dbField => $inputField)
        {
            $object->{$dbField} = (isset($processedInputs[ $inputField ]) && !empty($processedInputs[ $inputField ]) ? $processedInputs[ $inputField ] : null);
        }

        // save new row
        $object->save();

        // call methods after query
        $this->_callAfterQuery($processedInputs, $object->id, $inputs);

        // create files upload connection
        $this->_createFileUploadConnection($object->id, $inputs);

        // return new id of new row
        return $object->id;
    }


    private function _processedBeforeAdd($inputs)
    {
        // get current language
        $currentLanguage = \Language\Language::getInstance()->getCurrentLang();

        // contain new inputs data
        $newInputs = [];

        foreach ($this->_form->getStructure()->getFields() as $fields)
        {
            foreach ($fields as $field)
            {
                // check for regular inputs
                if ($field->manuallyAdd == false)
                {
                    $customField                = $field;
                    $customField->languageShort = strtolower($currentLanguage['short']);

                    $fieldName               = $customField->fieldName();
                    $newInputs[ $fieldName ] = (isset($inputs[ $fieldName ]) ? $inputs[ $fieldName ] : null);

                    // attach method to input
                    $newInputs[ $fieldName ] = $customField->attachToQueryBeforeAdd($newInputs[ $fieldName ]);
                }
            }
        }

        return $newInputs;
    }


    /**
     * Call custom method of any field that has manually add variable when query finish
     * @param array $inputs
     * @param integer $dbFieldId
     */
    private function _callAfterQuery($inputs, $dbFieldId, $oldInputs = null)
    {
        foreach ($this->_form->getStructure()->getFields() as $fields)
        {
            foreach ($fields as $field)
            {
                if ($field->manuallyAdd == true)
                {
                    $field->attachAfterQuery($this->_allAllowedFields, $inputs, $dbFieldId, $oldInputs);
                }
            }
        }
    }

    /**
     * Create connection between uploaded files and created row in db
     * @param integer $id
     * @param array $inputs
     */
    private function _createFileUploadConnection($id, $inputs)
    {
        foreach ($this->_form->getStructure()->getFields() as $fields)
        {
            foreach ($fields as $field)
            {
                //check for file upload inputs
                if ($field->manuallyAdd == true && $field->fieldFileUpload == true)
                {
                    // get images
                    $images = (isset($inputs[ 'fileUpload_' . $field->fieldName() ]) ? $inputs[ 'fileUpload_' . $field->fieldName() ] : null);

                    // create instance of files model
                    $filesModel = new \mvc\models\Files\Files();
                    $filesModel->createConnectionsBetweenImageAndRow(explode('|', $images), $id, $field->dbField());
                }
            }
        }
    }

    private function _editRow($inputs)
    {
        //throw exception
        if ($this->_dbFieldID <= 0)
        {
            throw new \Exception('Invalid db field id!');
        }

        // get class namespace
        $classNamespace = $this->_form->getStructure()->getNamespaceModel();

        // new instance of object
        $object = $classNamespace::find($this->_dbFieldID);

        $manualAdd = false;
        if (empty($object))
        {
            $manualAdd  = true;
            $object     = new $classNamespace();
            $object->id = $this->_dbFieldID;
        }

        // bind db fields
        \Helpers\Registry::getInstance()->setData('form_db_fields', $object);

        // process all inputs before add
        $processedInputs = $this->_processedBeforeAdd($inputs);

        // append all allowed fields
        foreach ($this->_allowFieldsChanges as $dbField => $inputField)
        {
            try
            {
                $object->{$dbField} = (isset($processedInputs[ $inputField ]) && !empty($processedInputs[ $inputField ]) ? $processedInputs[ $inputField ] : null);
            } catch (\Exception $ex)
            {
                continue;
            }
        }

        // save new row
        if (!$manualAdd)
        {
            $object->update();
        }
        else
        {
            $object->save();
        }

        // call methods after query
        $this->_callAfterQuery($processedInputs, $object->id, $inputs);

        // create files upload connection
        $this->_createFileUploadConnection($object->id, $inputs);

        // return id of created row
        return $object->id;
    }


}
