<?php

namespace libraries\FormBuilder\Configurations\Products;

use libraries\FormBuilder\Configurations\Products\Fields as Fields;

class Structure extends \libraries\FormBuilder\Configurations\Configuration
{

    /**
     * Define structure name
     */
    public $structureName = 'products';

    /**
     * Namespace of model
     * @var string
     */
    protected $namespaceModel = '\Products\Products';


    /**
     * Define page info
     */
    public function __construct()
    {
        $this->pageInfo = [
            'title'                        => 'Продукти',
            'subTitle'                     => 'добавяне / редактиране на продукт',
            'containerIcon'                => 'fa-pencil-square',
            'containerTitleAddMode'        => 'Добавяне на продукт',
            'containerTitleEditMode'       => 'Редактиране на продукт',
            'containerDesc'                => '',
            'validationSuccessMsgAddMode'  => 'Продуктът беше успешно добавен.',
            'validationSuccessMsgEditMode' => 'Продуктът беше успешно редактиран.',
        ];
    }


    /**
     * Describe all fields
     * @return array
     */
    public function define()
    {
        // define main database & her connection
        $this->setMainDatabase('products');
        $this->setMainDatabaseConnection('main');

        // make map of fields
        $fieldsMap = [
            new Fields\Title(),
            new Fields\Sku(),
            new Fields\OldAmount(),
            new Fields\Amount(),
            new Fields\Category(),
            new Fields\Type(),
            new Fields\TraderId(),
            new Fields\Materials(),
            new Fields\Colors(),
            new Fields\CustomSizes(),
            new Fields\FileUpload(),
            new Fields\Text(),
        ];

        // add all fields
        $this->multipleFieldsAdd($fieldsMap);
    }


}
