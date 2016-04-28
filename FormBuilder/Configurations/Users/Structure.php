<?php

namespace libraries\FormBuilder\Configurations\Users;

use libraries\FormBuilder\Configurations\Users\Fields as Fields;

class Structure extends \libraries\FormBuilder\Configurations\Configuration
{

    public $notAllowedLanguages = ['en'];

    /**
     * Define structure name
     */
    public $structureName = 'users';

    /**
     * Namespace of model
     * @var string
     */
    protected $namespaceModel = '\Users';


    /**
     * Define page info
     */
    public function __construct()
    {
        $this->pageInfo = [
            'title'                        => 'Потребители',
            'subTitle'                     => 'добавяне / редактиране на потребител',
            'containerIcon'                => 'fa-pencil-square',
            'containerTitleAddMode'        => 'Добавяне на потребител',
            'containerTitleEditMode'       => 'Редактиране на потребител',
            'containerDesc'                => '',
            'validationSuccessMsgAddMode'  => 'Потребителя беше успешно добавен.',
            'validationSuccessMsgEditMode' => 'Потребителя беше успешно редактиран.',
        ];
    }


    /**
     * Describe all fields
     * @return array
     */
    public function define()
    {
        // define main database & her connection
        $this->setMainDatabase('users');
        $this->setMainDatabaseConnection('global');

        //make map of fields
        $fieldsMap = [
            new Fields\Name(),
            new Fields\Email(),
            new Fields\Password(),
            new Fields\Birthday(),
            new Fields\Admin(),
        ];

        // add all fields
        $this->multipleFieldsAdd($fieldsMap);
    }


}
