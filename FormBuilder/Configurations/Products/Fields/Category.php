<?php

namespace libraries\FormBuilder\Configurations\Products\Fields;

class Category extends \libraries\FormBuilder\Configurations\Field implements \libraries\FormBuilder\Interfaces\IField
{

    public    $manuallyAdd     = true;
    protected $belongsToLayout = '1col';

    public function __construct()
    {
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
        $this->setPresentation('select_multiple');
    }


    public function selectConfig()
    {
        return [
            'type' => 'search',
        ];
    }


    public function selectOptions()
    {
        $categories = \Products\Category::orderBy('id', 'desc')
            ->select([
                         'title',
                         'id',
                         \DB::raw('(
                            SELECT 
                                COUNT(id) as cnt 
                            FROM products_categories 
                            WHERE 
                                category_id = product_categories.id 
                            AND 
                                product_id = ' . \Helpers\Registry::getInstance()->getData('form_id') . '
                        ) as checked'),
                     ])
            ->get();
        $arr        = [];

        foreach ($categories as $category)
        {
            $arr[] = [
                'title'   => $category->title,
                'value'   => $category->id,
                'checked' => ($category->checked >= 1 ? true : false),
            ];
        }

        return $arr;
    }


    public function dbField()
    {
        return 'category';
    }


    public function fieldNameBase()
    {
        return 'category_id';
    }


    public function title()
    {
        return 'Категории';
    }


    public function attachAfterQuery($allowedFields, $inputs, $fieldId, $oldInputs)
    {
        $fieldId   = (int)$fieldId;
        $insertArr = [];

        if (isset($oldInputs[ $this->fieldName() ]))
        {
            foreach ($oldInputs[ $this->fieldName() ] as $id)
            {
                $subId = (int)$id;

                if ($subId > 0)
                {
                    $insertArr[] = [
                        'product_id'  => $fieldId,
                        'category_id' => $subId,
                    ];
                }
            }
        }

        //delete all old
        \DB::connection('main')
            ->table('products_categories')
            ->where('product_id', '=', $fieldId)
            ->delete();

        if (isset($oldInputs[ $this->fieldName() ]))
        {
            //add new one
            \DB::connection('main')
                ->table('products_categories')
                ->insert($insertArr);
        }
    }


}
