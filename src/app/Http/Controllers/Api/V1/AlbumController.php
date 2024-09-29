<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlbumRequest;
use App\Http\Resources\AlbumResource;
use App\Repositories\AlbumRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class AlbumController extends Controller
{

    public function __construct(
        protected AlbumRepository $albumRepository
    ) {
    }

    public function index(string $albumId, string $resourceTypeId): AnonymousResourceCollection
    {
        $albums = $this->albumRepository->getAlbumsByArtistAndReleaseType($albumId, $resourceTypeId);

        return AlbumResource::collection($albums);
    }

    public function store(AlbumRequest $request): JsonResponse
    {
        $album = $this->albumRepository->create($request->validated());

        return (new AlbumResource($album))->response()->setStatusCode(201);
    }

    public function show(string $id): JsonResponse
    {
        $album = $this->albumRepository->getAlbum(id: $id);
        if (!$album) {
            throw new ModelNotFoundException;
        }

        return (new AlbumResource($album))->response()->setStatusCode(200);
    }

    public function update(AlbumRequest $request, string $id): JsonResponse
    {
        $album = $this->albumRepository->find(id: $id);
        if (!$album) {
            throw new ModelNotFoundException;
        }

        if ($album = $this->albumRepository->update($album, $request->validated())) {
            return (new AlbumResource($album))->response()->setStatusCode(200);
        }

        throw new Exception;
    }

    public function destroy(string $id): Response|JsonResponse
    {
        $album = $this->albumRepository->find(id: $id);
        if (!$album) {
            throw new ModelNotFoundException;
        }

        if ($this->albumRepository->delete($album)) {
            return response()->noContent();
        }

        throw new Exception;
    }
}
