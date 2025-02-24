<?php

namespace App\Scopes;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Organization\Facility;
use App\Models\User;

class FacilityScope extends BaseScope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function apply(Builder $builder, Model $model)
    {
        if (!$this->isEnabled()) {
            return;
        }

        $user = auth()->user();
        if (!$user) {
            $builder->whereRaw(0);
            return;
        }

        $key = get_class($model) === Facility::class ? 'id' : 'facility_id';
        if ($user->facility_id) {
            $builder->where($key, $user->facility_id);
            return;
        }
        if ($user->organization_id && !Schema::hasColumn($model->getTable(), 'organization_id')) {
            $facilityIds = Facility::withoutGlobalScopes()
                ->where('organization_id', $user->organization_id)
                ->pluck('id');
            $builder->whereIn($key, $facilityIds->toArray());
            return;
        }
        if ($user->organization_id && Schema::hasColumn($model->getTable(), 'organization_id')) {
            $builder->where('organization_id', $user->organization_id);
            return;
        }
        if (get_class($model) === User::class) {
            return;
        }
        $builder->whereRaw(0);
    }
}
