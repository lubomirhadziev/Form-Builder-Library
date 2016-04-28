<?php

namespace libraries\FormBuilder\Configurations;

class Configuration
{

    /**
     * List of all disabled languages for this form
     * @var array
     */
    public $notAllowedLanguages = [];

    /**
     * Contain all information about rendering the page
     * @var array
     */
    public $pageInfo = [
        'title'                        => '',
        'subTitle'                     => '',
        'containerTitle'               => '',
        'validationErrorMsg'           => '',
        'validationSuccessMsg'         => '',
        'containerTitleAddMode'        => '',
        'containerTitleEditMode'       => '',
        'validationSuccessMsgAddMode'  => '',
        'validationSuccessMsgEditMode' => '',
        'closeSidebar'                 => false,
    ];

    /**
     * Namespace of model
     * @var string
     */
    protected $namespaceModel;

    /**
     * Contain all fields
     * @var array
     */
    private $fields = [];

    /**
     * Contain name or \DB::raw of main database
     * @var string
     */
    private $mainDatabase;

    /**
     * Define main db connection to use
     * @var string
     */
    private $mainDatabaseConnection;


    public function getNamespaceModel()
    {
        return $this->namespaceModel;
    }


    public function getMainDatabaseConnection()
    {
        return $this->mainDatabaseConnection;
    }


    public function setMainDatabaseConnection($mainDatabaseConnection)
    {
        $this->mainDatabaseConnection = $mainDatabaseConnection;
    }


    public function getMainDatabase()
    {
        return $this->mainDatabase;
    }


    public function setMainDatabase($mainDatabase)
    {
        $this->mainDatabase = $mainDatabase;
    }


    public function multipleFieldsAdd($fields)
    {
        if (is_array($fields))
        {
            foreach ($fields as $field)
            {
                $this->_addField($field);
            }
        }
        else
        {
            throw new \Exception('Method multipleFieldsAdd require $fields to be array');
        }
    }


    public function getFieldByPosition($position)
    {
        $fieldFounded = null;
        $position     = (int)$position;
        $passedFields = 0;

        foreach ($this->getFields() as $field)
        {
            if ($field->getTakeOnlyLikeData() == false)
            {
                if ($position == $passedFields)
                {
                    $fieldFounded = $field;

                    break;
                }
                else
                {
                    $passedFields++;
                }
            }
        }

        //return founded field
        if ($fieldFounded !== null)
        {
            return $fieldFounded;
        }
        else
        {
            //throw new exception if come to this line
            throw new \Exception('Invalid field position "' . $position . '"');
        }
    }


    public function getFields($layout = null, $fieldNameBase = null)
    {
        if (isset($this->fields[ $layout ][ $fieldNameBase ]))
        {
            return $this->fields[ $layout ][ $fieldNameBase ];
        }
        elseif ($fieldNameBase === null)
        {
            ksort($this->fields);

            return $this->fields;
        }
        else
        {
            throw new \Exception('Field with name "' . $fieldNameBase . '" or layout name "' . $layout . '"
                does not exists');
        }
    }


    private function _addField($structure)
    {
        if ($structure instanceof \libraries\FormBuilder\Configurations\Field)
        {
            $this->fields[ $structure->getLayout() ][ $structure->dbField() ] = $structure;
        }
        else
        {
            throw new \Exception('Cannot add structure from different interface');
        }
    }


}
