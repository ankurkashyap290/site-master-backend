<?php

namespace Tests\Traits;

use App\Models\Organization\Facility;
use App\Models\Organization\Organization;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Hash;

/**
 * Create users for test.
 */
trait UserTrait
{
    /**
     * @var Organization
     */
    protected $organization;

    /**
     * @var Facility
     */
    protected $facility;

    /**
     * @var User
     */
    protected $user;

    /**
     * Create Administrator user.
     *
     * @param integer $roleId
     *
     * @return User
     * @throws AuthorizationException
     */
    protected function createTestFacilityAndUser($roleId = 5)
    {
        $this->organization = factory(Organization::class)->make();
        $this->organization->save(['unprotected' => true]);
        $this->facility = factory(Facility::class)->make([
            'name' => 'Test Facility',
            'organization_id' => $this->organization->id,
        ]);
        $this->facility->save(['unprotected' => true]);
        $this->user = factory(User::class)->make([
            'role_id' => $roleId,
            'organization_id' => $this->organization->id,
            'facility_id' => $this->facility->id,
            'password' => Hash::make($this->password),
        ]);
        $this->user->save(['unprotected' => true]);
        return $this->user;
    }

    /**
     * Create User
     *
     * @param integer $roleId
     * @param integer $organizationId
     * @param integer $facilityId
     *
     * @return User
     */
    protected function createTestUser($roleId, $organizationId = null, $facilityId = null)
    {
        $user = factory(User::class)->make([
            'role_id' => $roleId,
            'organization_id' => $organizationId,
            'facility_id' => $facilityId,
            'password' => Hash::make($this->password),
        ]);
        $user->save(['unprotected' => true]);
        return $user;
    }

    /**
     * Create Organizatin Tree.
     *
     * @return array
     */
    protected function createOrganizationTree(): array
    {
        // First Organization
        $organizationOne = factory(Organization::class)->make();
        $organizationOne->save(['unprotected' => true]);

        // Second Organization
        $organizationTwo = factory(Organization::class)->make();
        $organizationTwo->save(['unprotected' => true]);

        // Facilities of the first organization
        $firstFacilityOrgOne = factory(Facility::class)->make([
            'organization_id' => $organizationOne->id,
        ]);
        $firstFacilityOrgOne->save(['unprotected' => true]);

        $secondFacilityOrgOne = factory(Facility::class)->make([
            'organization_id' => $organizationOne->id,
        ]);
        $secondFacilityOrgOne->save(['unprotected' => true]);

        // Facilities of the second organization
        $firstFacilityOrgTwo = factory(Facility::class)->make([
            'organization_id' => $organizationTwo->id,
        ]);
        $firstFacilityOrgTwo->save(['unprotected' => true]);

        $secondFacilityOrgTwo = factory(Facility::class)->make([
            'organization_id' => $organizationTwo->id,
        ]);
        $secondFacilityOrgTwo->save(['unprotected' => true]);

        return [
            'organizationOne' => [
                'organization' => $organizationOne,
                'users' => [
                    $this->createTestUser(2, $organizationOne->id), // Org Admin
                    $this->createTestUser(3, $organizationOne->id), // Upper Management
                ],
                'facilities' => [
                    [
                        'facility' => $firstFacilityOrgOne,
                        'users' => [
                            $this->createTestUser(4, $organizationOne->id, $firstFacilityOrgOne->id), // Facility Admin
                            $this->createTestUser(5, $organizationOne->id, $firstFacilityOrgOne->id), // Master User
                            $this->createTestUser(6, $organizationOne->id, $firstFacilityOrgOne->id), // Administrator
                        ],
                    ],
                    [
                        'facility' => $secondFacilityOrgOne,
                        'users' => [
                            $this->createTestUser(4, $organizationOne->id, $secondFacilityOrgOne->id), // Facility Admin
                            $this->createTestUser(5, $organizationOne->id, $secondFacilityOrgOne->id), // Master User
                            $this->createTestUser(6, $organizationOne->id, $secondFacilityOrgOne->id), // Administrator
                        ],
                    ],
                ],
            ],
            'organizationTwo' => [
                'organization' => $organizationTwo,
                'users' => [
                    $this->createTestUser(2, $organizationTwo->id), // Org Admin
                    $this->createTestUser(3, $organizationTwo->id), // Upper Management
                ],
                'facilities' => [
                    [
                        'facility' => $firstFacilityOrgTwo,
                        'users' => [
                            $this->createTestUser(4, $organizationTwo->id, $firstFacilityOrgTwo->id), // Facility Admin
                            $this->createTestUser(5, $organizationTwo->id, $firstFacilityOrgTwo->id), // Master User
                            $this->createTestUser(6, $organizationTwo->id, $firstFacilityOrgTwo->id), // Administrator
                        ],
                    ],
                    [
                        'facility' => $secondFacilityOrgTwo,
                        'users' => [
                            $this->createTestUser(4, $organizationTwo->id, $secondFacilityOrgTwo->id), // Facility Admin
                            $this->createTestUser(5, $organizationTwo->id, $secondFacilityOrgTwo->id), // Master User
                            $this->createTestUser(6, $organizationTwo->id, $secondFacilityOrgTwo->id), // Administrator
                        ],
                    ],
                ],
            ],
        ];
    }
}
