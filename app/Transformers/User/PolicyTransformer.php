<?php

namespace App\Transformers\User;

use League\Fractal\TransformerAbstract;
use App\Transformers\TransformerInterface;
use App\Models\Policy;
use App\Transformers\Organization\OrganizationTransformer;
use App\Transformers\Organization\FacilityTransformer;

class PolicyTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param \App\Models\Policy $policy
     * @return array
     */
    public function transform($policy): array
    {
        return [
            'id' => $policy->id,
            'facility_id' => (int)$policy->facility_id,
            'role_id' => (int)$policy->role_id,
            'entity' => preg_replace('/.*\\\\/', '', $policy->class_name),
            'view' => (int)$policy->view,
            'create' => (int)$policy->create,
            'update' => (int)$policy->update,
            'delete' => (int)$policy->delete,
        ];
    }

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'policies';
    }
}
