<?php

namespace libraries\FormBuilder\Configurations\Products\Fields;

class TraderId extends \libraries\FormBuilder\Configurations\Field implements \libraries\FormBuilder\Interfaces\IField
{

    protected $belongsToLayout = '1col';


    public function __construct()
    {
        //set validations on field
        $this->validations = [
            'required',
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
        $traders = \Products\Traders::orderBy('id', 'desc')
            ->select([
                         'title',
                         'id',
                     ])
            ->get();
        $arr     = [];

        foreach ($traders as $trader)
        {
            $arr[] = [
                'title' => $trader->title,
                'value' => $trader->id,
            ];
        }

        return $arr;
    }


    public function dbField()
    {
        return 'trader_id';
    }


    public function fieldNameBase()
    {
        return 'trader_id';
    }


    public function title()
    {
        return 'Търговец';
    }


}
