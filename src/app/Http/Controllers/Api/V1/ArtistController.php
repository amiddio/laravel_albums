<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use App\Http\Resources\ArtistResource;
use App\Repositories\ArtistRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ArtistController extends Controller
{

    public function __construct(
        protected ArtistRepository $artistRepository
    ) {
    }

    public function index(): AnonymousResourceCollection
    {
        return ArtistResource::collection($this->artistRepository->paginate());
    }

    public function store(StoreArtistRequest $request): JsonResponse
    {
        $artist = $this->artistRepository->create($request->validated());

        return (new ArtistResource($artist))->response()->setStatusCode(201);
    }

    public function show(string $id): JsonResponse
    {
        $artist = $this->artistRepository->find(id: $id);
        if (!$artist) {
            throw new ModelNotFoundException;
        }

        return (new ArtistResource($artist))->response()->setStatusCode(200);
    }

    public function update(UpdateArtistRequest $request, string $id): JsonResponse
    {
        $artist = $this->artistRepository->find(id: $id);
        if (!$artist) {
            throw new ModelNotFoundException;
        }

        if ($artist = $this->artistRepository->update($artist, $request->validated())) {
            return (new ArtistResource($artist))->response()->setStatusCode(200);
        }

        throw new Exception;
    }

    public function destroy(string $id): Response|JsonResponse
    {
        $artist = $this->artistRepository->find(id: $id);
        if (!$artist) {
            throw new ModelNotFoundException;
        }

        if ($this->artistRepository->delete($artist)) {
            return response()->noContent();
        }

        throw new Exception;
    }
}
