<?php

namespace libraries\FormBuilder\Configurations\Products\Fields;

class CustomSizes extends \libraries\FormBuilder\Configurations\Field implements \libraries\FormBuilder\Interfaces\IField
{

    public    $manuallyAdd     = true;
    public    $_sizeData       = [];
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
        $this->setPresentation('custom.sizes');

        //init sizes
        $this->_sizeData = $this->getSizesData();
    }


    public function getSizesData()
    {
        $productId       = (int)\Helpers\Registry::getInstance()->getData('form_id');
        $this->_sizeData = \Cart\Models\ProductSizes::orderBy('product_sizes.title', 'asc')
            ->leftJoin('products_sizes', function ($query) use (&$productId)
            {
                $query->on('size_id', '=', \DB::raw('product_sizes.id'))
                    ->on('product_id', '=', \DB::raw($productId));
            })
            ->select([
                         'product_sizes.id',
                         'product_sizes.title',
                         'products_sizes.amount',
                         'products_sizes.cm',
                     ])
            ->get();

        return $this->_sizeData;
    }


    public function getSizeValue($id)
    {
        $id     = (int)$id;
        $inputs = \Input::all();

        if (isset($inputs[ $this->fieldName() ][0][ $id ]))
        {
            return $inputs[ $this->fieldName() ][0][ $id ];
        }
        else
        {
            foreach ($this->_sizeData as $size)
            {
                if ($size->id == $id)
                {
                    return $size->amount;
                }
            }
        }

        return null;
    }

    public function getCmValue($id)
    {
        $id     = (int)$id;
        $inputs = \Input::all();

        if (isset($inputs[ $this->fieldName() ][1][ $id ]))
        {
            return $inputs[ $this->fieldName() ][1][ $id ];
        }
        else
        {
            foreach ($this->_sizeData as $size)
            {
                if ($size->id == $id)
                {
                    return $size->cm;
                }
            }
        }

        return null;
    }


    public function dbField()
    {
        return '_title';
    }


    public function fieldNameBase()
    {
        return 'size';
    }


    public function title()
    {
        return 'Размери';
    }


    public function attachAfterQuery($allowedFields, $inputs, $productId, $oldInputs)
    {
        if (isset($oldInputs[ $this->fieldName() ][0]))
        {

            //get sizes data
            $sizesData = $oldInputs[ $this->fieldName() ][0];

            //prepare arr to add to db
            $sizes = [];

            foreach ($sizesData as $size_id => $size_amount)
            {
                $amount = (real)$size_amount;

                if ($amount > 0)
                {
                    if (isset($oldInputs[ $this->fieldName() ][1][ $size_id ]))
                    {
                        $cm = (double)$oldInputs[ $this->fieldName() ][1][ $size_id ];
                    }
                    else
                    {
                        $cm = 0;
                    }

                    $sizes[] = [
                        'size_id'    => (int)$size_id,
                        'product_id' => (int)$productId,
                        'amount'     => $amount,
                        'cm'         => $cm,
                    ];
                }
            }
        }

        //delete all old
        \DB::connection('main')
            ->table('products_sizes')
            ->where('product_id', '=', $productId)
            ->delete();

        if (isset($oldInputs[ $this->fieldName() ]) && !empty($sizes))
        {
            //add new one
            \DB::connection('main')
                ->table('products_sizes')
                ->insert($sizes);
        }
    }


}
