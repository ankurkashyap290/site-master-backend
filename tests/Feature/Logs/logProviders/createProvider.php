<?php

use Illuminate\Http\JsonResponse;

return function () {
    return [
        [
            'sa@journey.test',
            1,
            JsonResponse::HTTP_UNAUTHORIZED
        ],
        [
            'oa@silverpine.test',
            1,
            JsonResponse::HTTP_CREATED
        ],
        [
            'oa@silverpine.test',
            3,
            JsonResponse::HTTP_UNAUTHORIZED
        ],
        [
            'um@silverpine.test',
            1,
            JsonResponse::HTTP_UNAUTHORIZED
        ],
        [
            'fa@silverpine.test',
            1,
            JsonResponse::HTTP_CREATED
        ],
        [
            'fa@silverpine.test',
            2,
            JsonResponse::HTTP_UNAUTHORIZED
        ],
        [
            'mu@silverpine.test',
            1,
            JsonResponse::HTTP_CREATED
        ],
        [
            'mu@silverpine.test',
            2,
            JsonResponse::HTTP_UNAUTHORIZED
        ],
        [
            'ad@silverpine.test',
            1,
            JsonResponse::HTTP_CREATED
        ],
        [
            'ad@silverpine.test',
            2,
            JsonResponse::HTTP_UNAUTHORIZED
        ],
    ];
};
