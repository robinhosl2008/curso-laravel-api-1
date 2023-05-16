<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $repository)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Series::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SeriesFormRequest $request)
    {
        return response()->json($this->repository->add($request), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        // return Series::where('id', $id)->with('seasons.episodes')->first();
        $serie = Series::where('id', $id)->first();
        if (!$serie) {
            return response()->json(["message" => "Série não encontrada"]);
        }
        
        return $serie;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SeriesFormRequest $request, int $id)
    {
        $serie = Series::where('id', $id)->first();
        if (!$serie) {
            return redirect()->json(['message' => "Série não encontrada"]);
        }

        // $serie->fill($request->all());
        // $serie->save();
        $serie->update($request->all());
        return [
            "status" => 200,
            "message" => "Editado!"
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $serie = Series::where('id', $id)->first();
        if (!$serie) {
            return response()->json(['message' => 'Série não encontrada']);
        }

        $serie->delete();

        $res = [
            "status" => true,
            "message" => "Removido"
        ];

        return response($res, 200);
    }
}
