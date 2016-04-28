<?php

namespace libraries\FormBuilder\Configurations\Products\Fields;

class Type extends \libraries\FormBuilder\Configurations\Field implements \libraries\FormBuilder\Interfaces\IField
{

    protected $belongsToLayout = '1col';


    //    public $manuallyAdd        = true;


    public function __construct()
    {
        //set validations on field
        $this->validations = [
            '',
        ];

        //set live validations on field
        $this->liveValidations = [
        ];

        //set field info
        $this->fieldInfo = [
            'help' => '',
        ];

        //set presentation view
        $this->setPresentation('select_default');
    }


    public function selectConfig()
    {
        return [
            'type' => 'search',
        ];
    }


    public function selectOptions()
    {
        //get all blog categories
        $categories = \Products\Types::orderBy('id', 'desc')->get();

        //contain all options to return
        $options = [];

        foreach ($categories as $category)
        {
            $options[] = [
                'title' => $category->title,
                'value' => $category->id,
            ];
        }

        return $options;
    }


    public function dbField()
    {
        return 'type_id';
    }


    public function fieldNameBase()
    {
        return 'type_id';
    }


    public function title()
    {
        return 'Тип';
    }


    public function asdery($allowedFields, $inputs, $fieldId, $oldInputs)
    {
        //        $fieldId   = (int) $fieldId;
        //        $insertArr = [];
        //
        //        foreach ($inputs[$this->fieldNameBase()] as $id)
        //        {
        //            $subId = (int) $id;
        //
        //            if ($subId > 0)
        //            {
        //                $insertArr[] = [
        //                    'main_id' => $fieldId,
        //                    'sub_id'  => $subId
        //                ];
        //            }
        //        }
        //
        //        //delete all old
        //        \DB::connection('public')
        //                ->table('test')
        //                ->where('main_id', '=', $fieldId)
        //                ->delete();
        //
        //        //add new one
        //        \DB::connection('public')
        //                ->table('test')
        //                ->insert($insertArr);
    }


}
