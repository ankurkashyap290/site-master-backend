<?php

namespace App\Transformers\Organization;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;
use App\Transformers\TransformerInterface;

class FacilityTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param Model $facility
     * @return array
     */
    public function transform($facility): array
    {
        return [
            'id' => $facility ? $facility->id : null,
            'name' => $facility ? $facility->name : '',
            'budget' => $facility ? (int)$facility->budget : 0,
            'organization_id' => $facility ? (int)$facility->organization_id : null,
            'timezone' => $facility ? $facility->timezone : '',
            'location_id' => ($facility && $facility->location_id) ? $facility->location_id : null,
        ];
    }

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'facilities';
    }
}
