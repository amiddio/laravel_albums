<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\ReleaseTypeData;
use App\Http\Controllers\Controller;
use App\Repositories\ReleaseTypeRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Resources\ReleaseTypeResource;

class ReleaseTypeController extends Controller
{

    /**
     * @param ReleaseTypeRepository $releaseTypeRepository
     */
    public function __invoke(ReleaseTypeRepository $releaseTypeRepository)
    {
        //return $releaseTypeRepository->getAll();
        return ReleaseTypeResource::collection($releaseTypeRepository->getAll());
    }

}
