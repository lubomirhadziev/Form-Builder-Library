<?php

namespace libraries\FormBuilder;

class FormBuilder extends \mvc\controllers\BaseController
{

    /**
     * Contain instance of structure
     */
    protected $structure;

    /**
     * Declare location of form views
     * @var string
     */
    private $_formViewsPath = 'admin/libraries/FormBuilder/Views';

    /**
     * Contain all fields of form
     * @var array
     */
    private $_fields = [];

    /**
     * Contain prepared fields processed before show
     * @var array
     */
    private $_preparedFields = [];

    /**
     * Define current mode of form
     * @var string
     */
    private $_mode = 'add';


    public function __construct($structure, $mode = 'add')
    {
        // run default construct
        parent::__construct();

        // add current mode
        $this->_mode = ($mode == 'add' ? 'add' : 'edit');

        // set structure instance of data table
        $this->structure = $structure;

        // define fields
        $this->structure->define($this->_mode);
    }

    public function getStructure()
    {
        return $this->structure;
    }

    /**
     * Generate form
     */
    public function buildForm($dbFields = null, $dbFieldID = 0)
    {
        //cast to int
        $dbFieldID = (int)$dbFieldID;

        // bind in view
        $this->setViewData('dbFieldID', $dbFieldID);

        // register view namespaces
        $this->_registerViewNamespace();

        // process all fields
        $this->_processFieldsBeforeBuild($dbFields, $dbFieldID);

        // get allowed languages
        $allowedLanguages = $this->getAllowedLanguages();

        // return the view
        return $this->renderTemplate('form', [
            'languages' => $allowedLanguages,
            'mode'      => $this->_mode,
            'structure' => $this->structure,
            'fields'    => $this->_preparedFields,
        ], 'form_views::');
    }


    public function getAllowedLanguages()
    {
        $allLanguages     = \Language\Language::getInstance()->getAllLanguages();
        $allowedLanguages = [];

        foreach ($allLanguages as $lang)
        {
            if (!in_array(strtolower($lang['short']), $this->getStructure()->notAllowedLanguages))
            {
                $allowedLanguages[] = $lang;
            }
        }

        return $allowedLanguages;
    }


    private function _registerViewNamespace()
    {
        // register data table views namespace
        \View::addNamespace('form_views', app_path($this->_formViewsPath));

        // register admin layout views
        \View::addNamespace('admin_theme', app_path('admin/mvc/views'));
    }


    private function _processFieldsBeforeBuild($dbFields = null, $dbFieldId = 0)
    {
        $dbFieldId        = (int)$dbFieldId;
        $allowedLanguages = $this->getAllowedLanguages();

        // foreach all languages
        foreach ($allowedLanguages as $lang)
        {
            $langShortName = strtolower($lang['short']);

            // set lang db connection
            $langClass = \Language\Language::getInstance();
            $langClass->changeLanguage($langShortName);
            $langClass->setCurrentDatabaseConnections();

            // get db fields
            if (!empty($dbFields) && is_object($dbFields) && $dbFieldId > 0)
            {
                $dbInputFields = $dbFields->findResultByID($dbFieldId);
            }

            // foreach all fields and sort by their layout
            foreach ($this->structure->getFields() as $layout => $fields)
            {
                // foreach all fields
                foreach ($fields as $field)
                {
                    $fieldToBinding = $field;

                    // check is current language is disabled for this input
                    if (isset($field->onlyForLanguage) && !empty($field->onlyForLanguage))
                    {
                        if ($field->onlyForLanguage != $langShortName)
                        {
                            continue;
                        }
                    }

                    $fieldToBinding->languageShort = $langShortName;

                    // make instance of presentation
                    $presentation = new \libraries\Form\Presentation;

                    // start buffer
                    ob_start();

                    echo $presentation->buildPresentation($fieldToBinding, (isset($dbInputFields) ? $dbInputFields : []));

                    // get buffer html
                    $buffer = ob_get_clean();

                    // build and save form element
                    $this->_preparedFields[ $langShortName ][ $layout ][] = $buffer;
                }
            }
        }
    }


}
