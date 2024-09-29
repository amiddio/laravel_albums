<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReleaseTypeResource;
use App\Repositories\ReleaseTypeRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReleaseTypeController extends Controller
{

    public function __invoke(ReleaseTypeRepository $releaseTypeRepository): AnonymousResourceCollection
    {
        return ReleaseTypeResource::collection($releaseTypeRepository->getAll());
    }
}
