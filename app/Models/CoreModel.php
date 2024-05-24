<?php

namespace App\Models;
;
use Illuminate\Database\Eloquent\Model;

abstract class CoreModel extends Model
{
    /**
     * This will set the fillable fields
     *
     * @param array $data
     * @return void
     */
    protected function setFillableFields($modelInstance, array $data)
    {
        if (empty($data)) {
            return;
        }

        foreach ($data as $field => $value) {
            if (in_array($field, $this->fillable)) {
                $modelInstance->$field = $value;
            }
        }
    }
}
