<?php

namespace App\Transformers\Auth;

use App\Models\Policy;
use App\Transformers\TransformerInterface;
use App\Transformers\User\UserTransformer;
use App\Transformers\User\PolicyTransformer;
use App\Transformers\Organization\FacilityTransformer;

class AuthUserTransformer extends UserTransformer implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param App\Models\User $user
     * @return array
     */
    public function transform($user): array
    {
        $data = parent::transform($user);

        $data['access_token'] = auth()->tokenById($user->id);
        $data['token_type'] = 'bearer';
        $data['expires_in'] = auth()->factory()->getTTL() * 60;
        $data['policies'] = $this->policies($user);
        $data['facilities'] = $this->facilities($user);

        return $data;
    }

    public function facilities($user)
    {
        $facilities = $user->getRelatedFacilities();
        $facilitiesData = [];
        foreach ($facilities as $facility) {
            $facilitiesData[] = (new FacilityTransformer)->transform($facility);
        }

        return $facilitiesData;
    }

    public function policies($user)
    {
        $roles = config()->get('roles');
        if (!in_array($user->role_id, [$roles['Master User'], $roles['Administrator']])) {
            return [];
        }

        $policies = Policy::withoutGlobalScopes()
            ->where('facility_id', $user->facility_id)
            ->where('role_id', $user->role_id)
            ->get();

        $policiesData = [];
        foreach ($policies as $policy) {
            $policiesData[] = (new PolicyTransformer)->transform($policy);
        }

        return $policiesData;
    }
}
