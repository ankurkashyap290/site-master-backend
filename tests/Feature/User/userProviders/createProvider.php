<?php

use Illuminate\Http\JsonResponse;

return function ($roles) {
    return [
        'sa_manages_oa' => [
            'sa@journey.test',
            $roles['Organization Admin'],
            1,
            null,
            JsonResponse::HTTP_CREATED
        ],
        'sa_manages_oa_without_organization_id' => [
            'sa@journey.test',
            $roles['Organization Admin'],
            null,
            null,
            JsonResponse::HTTP_BAD_REQUEST
        ],
        'oa_manages_oa' => [
            'oa@silverpine.test',
            $roles['Organization Admin'],
            1,
            null,
            JsonResponse::HTTP_UNAUTHORIZED
        ],
        'oa_manages_um' => [
            'oa@silverpine.test',
            $roles['Upper Management'],
            1,
            null,
            JsonResponse::HTTP_CREATED
        ],
        'oa_manages_sa' => [
            'oa@silverpine.test',
            $roles['Super Admin'],
            null,
            null,
            JsonResponse::HTTP_BAD_REQUEST
        ],
        'oa_manages_fa' => [
            'oa@silverpine.test',
            $roles['Facility Admin'],
            1,
            1,
            JsonResponse::HTTP_CREATED
        ],
        'oa_manages_fa_in_wrong_organization' => [
            'oa@silverpine.test',
            $roles['Facility Admin'],
            2,
            3,
            JsonResponse::HTTP_UNAUTHORIZED
        ],
        'um_manages_um' => [
            'um@silverpine.test',
            $roles['Upper Management'],
            1,
            null,
            JsonResponse::HTTP_CREATED
        ],
        'um_manages_fa' => [
            'um@silverpine.test',
            $roles['Facility Admin'],
            1,
            1,
            JsonResponse::HTTP_CREATED
        ],
        'fa_manages_sa' => [
            'fa@silverpine.test',
            $roles['Super Admin'],
            null,
            null,
            JsonResponse::HTTP_BAD_REQUEST
        ],
        'fa_manages_oa' => [
            'fa@silverpine.test',
            $roles['Organization Admin'],
            1,
            null,
            JsonResponse::HTTP_UNAUTHORIZED
        ],
        'fa_manages_um' => [
            'fa@silverpine.test',
            $roles['Upper Management'],
            1,
            null,
            JsonResponse::HTTP_UNAUTHORIZED
        ],
        'fa_manages_fa' => [
            'fa@silverpine.test',
            $roles['Facility Admin'],
            1,
            1,
            JsonResponse::HTTP_UNAUTHORIZED
        ],
        'fa_manages_mu' => [
            'fa@silverpine.test',
            $roles['Master User'],
            1,
            1,
            JsonResponse::HTTP_CREATED
        ],
        'fa_manages_mu_in_wrong_facility' => [
            'fa@silverpine.test',
            $roles['Master User'],
            1,
            2,
            JsonResponse::HTTP_UNAUTHORIZED
        ],
        'fa_manages_ad' => [
            'fa@silverpine.test',
            $roles['Administrator'],
            1,
            1,
            JsonResponse::HTTP_CREATED
        ],
        'fa_manages_ad_in_wrong_facility' => [
            'fa@silverpine.test',
            $roles['Administrator'],
            1,
            2,
            JsonResponse::HTTP_UNAUTHORIZED
        ],
        'mu_manages_ad' => [
            'mu@silverpine.test',
            $roles['Administrator'],
            1,
            1,
            JsonResponse::HTTP_UNAUTHORIZED
        ],
        'ad_manages_ad' => [
            'ad@silverpine.test',
            $roles['Administrator'],
            1,
            1,
            JsonResponse::HTTP_UNAUTHORIZED
        ],
    ];
};
