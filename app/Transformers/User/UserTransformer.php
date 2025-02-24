<?php

namespace App\Transformers\User;

use League\Fractal\TransformerAbstract;
use App\Transformers\TransformerInterface;
use App\Models\User;
use App\Transformers\Organization\OrganizationTransformer;
use App\Transformers\Organization\FacilityTransformer;

class UserTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * Transform object to array.
     *
     * @param User $user
     * @param bool $verbose
     * @return array
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function transform($user, $verbose = true): array
    {
        if (!$verbose) {
            return [
                'id' => $user->id,
                'name' => $user->getFullName(),
                'first_name' => $user->first_name,
                'middle_name' => (string)$user->middle_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'color_id' => $user->color_id,
            ];
        }
        return [
            'id' => $user->id,
            'name' => $user->getFullName(),
            'first_name' => $user->first_name,
            'middle_name' => (string)$user->middle_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone' => (string)$user->phone,
            'role_id' => (int)$user->role_id,
            'color_id' => $user->color_id,
            'organization' => $this->organization($user),
            'facility' => $this->facility($user),
        ];
    }

    /**
     * Transform Organization
     *
     * @param User $user
     * @return array
     */
    public function organization(User $user)
    {
        return (new OrganizationTransformer)->transform($user->organization);
    }

    /**
     * Transform Facility
     *
     * @param User $user
     * @return array
     */
    public function facility(User $user)
    {
        return (new FacilityTransformer)->transform($user->facility);
    }

    /**
     * Define json resource key.
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'users';
    }
}
