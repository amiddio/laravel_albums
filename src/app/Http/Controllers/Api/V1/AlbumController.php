<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlbumRequest;
use App\Http\Resources\AlbumResource;
use App\Repositories\AlbumRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class AlbumController extends Controller
{

    public function __construct(protected AlbumRepository $albumRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $albumId, string $resourceTypeId):AnonymousResourceCollection
    {
        $albums = $this->albumRepository->getAlbumsByArtistAndReleaseType($albumId, $resourceTypeId);

        return AlbumResource::collection($albums);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlbumRequest $request): JsonResponse
    {
        $album = $this->albumRepository->create($request->validated());

        return (new AlbumResource($album))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $album = $this->albumRepository->getAlbum(id: (string)$id);
        if (!$album) {
            throw new ModelNotFoundException;
        }

        return (new AlbumResource($album))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     * @throws Exception
     */
    public function update(AlbumRequest $request, string $id): JsonResponse
    {
        $album = $this->albumRepository->find(id: $id);
        if (!$album) {
            throw new ModelNotFoundException;
        }

        if ($album = $this->albumRepository->update($album, $request->validated())) {
            return (new AlbumResource($album))->response()->setStatusCode(200);
        }

        throw new Exception(__('The album with ID:\':id\' could not be updated.', ['id' => $id]));
    }

    /**
     * Remove the specified resource from storage.
     * @throws Exception
     */
    public function destroy(string $id): Response|JsonResponse
    {
        $album = $this->albumRepository->find(id: $id);
        if (!$album) {
            throw new ModelNotFoundException;
        }

        if ($this->albumRepository->delete($album)) {
            return response()->noContent();
        }

        throw new Exception(__('The album with ID:\':id\' could not be removed.', ['id' => $id]));
    }
}
