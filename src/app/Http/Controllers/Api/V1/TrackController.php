<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrackRequest;
use App\Http\Requests\UpdateTrackRequest;
use App\Http\Resources\TrackResource;
use App\Repositories\TrackRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TrackController extends Controller
{

    public function __construct(
        protected TrackRepository $trackRepository
    ) {
    }

    public function store(StoreTrackRequest $request): JsonResponse
    {
        $track = $this->trackRepository->create($request->validated());

        return (new TrackResource($track))->response()->setStatusCode(201);
    }

    public function update(UpdateTrackRequest $request, string $id)
    {
        $track = $this->trackRepository->find(id: $id);
        if (!$track) {
            throw new ModelNotFoundException;
        }

        if ($track = $this->trackRepository->update($track, $request->validated())) {
            return (new TrackResource($track))->response()->setStatusCode(200);
        }

        throw new Exception;
    }

    public function destroy(string $id): Response|JsonResponse
    {
        $track = $this->trackRepository->find(id: $id);
        if (!$track) {
            throw new ModelNotFoundException;
        }

        if ($this->trackRepository->delete($track)) {
            return response()->noContent();
        }

        throw new Exception;
    }
}
