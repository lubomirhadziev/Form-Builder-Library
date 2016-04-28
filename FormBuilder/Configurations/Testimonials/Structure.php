<?php

namespace libraries\FormBuilder\Configurations\Testimonials;

use libraries\FormBuilder\Configurations\Testimonials\Fields as Fields;

class Structure extends \libraries\FormBuilder\Configurations\Configuration
{

    /**
     * Define structure name
     */
    public $structureName = 'testimonials';

    /**
     * Namespace of model
     * @var string
     */
    protected $namespaceModel = '\Testimonials\Testimonials';


    /**
     * Define page info
     */
    public function __construct()
    {
        $this->pageInfo = [
            'title'                        => 'Отзиви',
            'subTitle'                     => 'добавяне / редактиране на отзиви',
            'containerIcon'                => 'fa-pencil-square',
            'containerTitleAddMode'        => 'Добавяне на отзив',
            'containerTitleEditMode'       => 'Редактиране на отзив',
            'containerDesc'                => '',
            'validationSuccessMsgAddMode'  => 'Отизивът беше успешно добавен.',
            'validationSuccessMsgEditMode' => 'Отизивът беше успешно редактиран.',
        ];
    }


    /**
     * Describe all fields
     * @return array
     */
    public function define()
    {
        // define main database & her connection
        $this->setMainDatabase('testimonials');
        $this->setMainDatabaseConnection('main');

        // make map of fields
        $fieldsMap = [
            new Fields\Company(),
            new Fields\Text(),
        ];

        // add all fields
        $this->multipleFieldsAdd($fieldsMap);
    }


}
