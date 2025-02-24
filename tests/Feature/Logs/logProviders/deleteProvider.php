<?php

use Illuminate\Http\JsonResponse;

return function () {
    return [
        [
            'sa@journey.test',
            1,
            JsonResponse::HTTP_NOT_FOUND
        ],
        [
            'oa@silverpine.test',
            1,
            JsonResponse::HTTP_OK
        ],
        [
            'oa@silverpine.test',
            3,
            JsonResponse::HTTP_NOT_FOUND
        ],
        [
            'um@silverpine.test',
            1,
            JsonResponse::HTTP_UNAUTHORIZED
        ],
        [
            'fa@silverpine.test',
            1,
            JsonResponse::HTTP_OK
        ],
        [
            'fa@silverpine.test',
            2,
            JsonResponse::HTTP_NOT_FOUND
        ],
        [
            'mu@silverpine.test',
            1,
            JsonResponse::HTTP_OK
        ],
        [
            'mu@silverpine.test',
            2,
            JsonResponse::HTTP_NOT_FOUND
        ],
        [
            'ad@silverpine.test',
            1,
            JsonResponse::HTTP_OK
        ],
        [
            'ad@silverpine.test',
            2,
            JsonResponse::HTTP_NOT_FOUND
        ],
    ];
};
