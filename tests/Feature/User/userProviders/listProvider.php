<?php

use Illuminate\Http\JsonResponse;

return function ($roles) {
    return [
        ['sa@journey.test', 8],
        ['oa@silverpine.test', 6],
        ['um@silverpine.test', 6],
        ['fa@silverpine.test', 4],
        ['mu@silverpine.test', 4],
        ['ad@silverpine.test', 4],
    ];
};
