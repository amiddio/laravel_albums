<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use App\Http\Resources\ArtistResource;
use App\Repositories\ArtistRepository;
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

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return ArtistResource::collection($this->artistRepository->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArtistRequest $request): JsonResponse
    {
        $artist = $this->artistRepository->create($request->validated());

        return (new ArtistResource($artist))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $artist = $this->artistRepository->find(id: $id);
        if (!$artist) {
            throw new ModelNotFoundException;
        }

        return (new ArtistResource($artist))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArtistRequest $request, string $id): JsonResponse
    {
        $artist = $this->artistRepository->find(id: $id);
        if (!$artist) {
            throw new ModelNotFoundException;
        }

        if ($artist = $this->artistRepository->update($artist, $request->validated())) {
            return (new ArtistResource($artist))->response()->setStatusCode(200);
        }

        return response()->json(['message' => __('The artist could not be updated.')], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response|JsonResponse
    {
        $artist = $this->artistRepository->find(id: $id);
        if (!$artist) {
            throw new ModelNotFoundException;
        }

        if ($this->artistRepository->delete($artist)) {
            return response()->noContent();
        }

        return response()->json(['message' => __('The artist could not be removed.')], 400);
    }
}
