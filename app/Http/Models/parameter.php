<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;

class parameter extends Model
{
    use SoftDeletes;

    protected $table = 'field_parameter';

    protected $primaryKey = 'Parameter_ID';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'Type',
        'Item',
        'SubItem',
        'Rates',
        'Remarks',
        'created_by'
    ];

    public function scopeFieldParameter_bank($query, $type = null)
    {
        if($type){
            return $query->where('Type', '=', 19)->where('Item', '=', $type);
        }else{
            return $query->where('Type', '=', 19)->where('deleted_at', '=', NULL);
        }
    }

    public function scopeFieldParameter_generalmanager($query)
    {
        return $query->where('Type', 68);
    }

    public function scopeMajorItems($query)
    {
        return $query->where('Type', 80);
    }

    public function parameterType($type, $lookAt = 'name', $lookWhereIn = null)
    {
        $type = collect($type)->map(function ($value){
            $lookupTable = collect([
                'ScopeOfWork'                       => 45,
                'Insurances'                        => 46,
                'MaterialAndWorkmanship'            => 47,
                'GovernmentRequirement'             => 48,
                'SafetyEquipment'                   => 49,
                'PaymentTerm'                       => 50,
                'RetentionSum'                      => 51,
                'DefectLiabilityPeriod'             => 52,
                'LiquidatedandAscertainedDamages'   => 53,
                'VarationOrder'                     => 54,
                'IssueByCompany'                    => 55,
                'Status'                            => 71,
                'Team'                              => 75,
                'MajorItem'                         => 80,
                'WOIO'                              => 81,
                'Project File Upload'               => 105,
                'File Group Upload'                 => 107,
            ]);

            return $lookupTable->get($value, NULL);
        });

        if (! $type[0])
        {
            return 'Not found in Parameter List!';
        }

        $parameter = parameter::where('Type', 'LIKE', $type)
                                ->orderBy('Item', 'ASC');

        if(!empty($lookWhereIn))
        {
            $parameter->whereIn('Parameter_ID', $lookWhereIn);
        }

        if ($lookAt == 'name')
        {
            $parameter = $parameter->pluck('Item', 'Item');
        }

        if ($lookAt == 'id')
        {
            $parameter = $parameter->pluck('Item', 'Parameter_ID');
        }

        return $parameter->all();
    }

    public function parameterIdLookup($parameter_id)
    {
        if ($parameter_id == 'Orphan')
        {
            return 'RE-ASSIGN Needed!';
        }

        try {

            return parameter::where('Parameter_ID', '=', $parameter_id)->withTrashed()->firstOrFail()->Item;

        } catch (ModelNotFoundException $ex) {

            return 'Parameter ID not found!';
            //kindly consult field_parameter
        }

    }
}