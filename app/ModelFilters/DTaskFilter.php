<?php

namespace App\ModelFilters;
use Illuminate\Database\Eloquent\Builder;
use EloquentFilter\ModelFilter;


class DTaskFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     *
     */
    public function search($value)
    {
        $query = $this;
        $fillableColumns = $query->getModel()->getFillable();
        return $query->where(function (Builder $query) use ($fillableColumns, $value) {
            foreach ($fillableColumns as $column) {
                $query->orWhere($column, 'LIKE', '%' . $value . '%');
            }
        });
    }

    public function status($value){
        return $this->where('status',$value);
    }
}
