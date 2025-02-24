<?php

namespace App\Transformers\Organization;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;
use App\Transformers\TransformerInterface;

class OrganizationTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param Model $organization
     * @return array
     */
    public function transform($organization): array
    {
        return [
            'id' => $organization ? $organization->id : null,
            'name' => $organization ? $organization->name : '',
            'budget' => $organization ? (int)$organization->budget : 0,
            'facility_limit' => $organization ? (int)$organization->facility_limit : null,
        ];
    }

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'organizations';
    }
}
