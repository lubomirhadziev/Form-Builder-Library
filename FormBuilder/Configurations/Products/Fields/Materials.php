<?php

namespace libraries\FormBuilder\Configurations\Products\Fields;

class Materials extends \libraries\FormBuilder\Configurations\Field implements \libraries\FormBuilder\Interfaces\IField
{

    public    $manuallyAdd     = true;
    protected $belongsToLayout = '2col';

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
        $categories = \Products\Materials::orderBy('id', 'desc')
            ->select([
                         'title',
                         'id',
                         \DB::raw('(
                            SELECT
                                COUNT(id) as cnt
                            FROM products_materials
                            WHERE
                                material_id = product_materials.id
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
        return '';
    }


    public function fieldNameBase()
    {
        return 'materials';
    }


    public function title()
    {
        return 'Материали';
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
                        'material_id' => $subId,
                    ];
                }
            }
        }

        //delete all old
        \DB::connection('main')
            ->table('products_materials')
            ->where('product_id', '=', $fieldId)
            ->delete();

        if (isset($oldInputs[ $this->fieldName() ]))
        {
            //add new one
            \DB::connection('main')
                ->table('products_materials')
                ->insert($insertArr);
        }
    }


}
