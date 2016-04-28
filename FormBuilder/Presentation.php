<?php

namespace libraries\FormBuilder;

class Presentation extends \mvc\controllers\BaseController
{

    /**
     * Contain isntance of field object
     * @var \libraries\FormBuilder\Configurations\Field
     */
    private $_field;


    public function buildPresentation(\libraries\FormBuilder\Configurations\Field $field, $dbFields = null)
    {
        $this->_field = $field;

        // register namespace
        $this->_registerViewNamespace();

        // build
        return $this->renderTemplate('elements.' . $this->_field->getPresentationName(), [
            'field'    => $this->_field,
            'dbFields' => $dbFields,
        ], 'presentation_theme::');
    }


    private function _registerViewNamespace()
    {
        // register presentation views
        \View::addNamespace('presentation_theme', app_path('admin/libraries/FormBuilder/Views'));
    }


}
