<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Translation::paginate(50);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string',
            'locale' => 'required|string|max:10',
            'content' => 'required|string',
            'tags' => 'nullable|array'
        ]);

        return Translation::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Translation $translation)
    {
        return $translation;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Translation $translation)
    {
        $translation->update($request->all());
        return $translation;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Translation $translation)
    {
        $translation->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function search(Request $request)
    {
        $query = Translation::query();

        if ($request->key) {
            $query->where('key', 'LIKE', "%{$request->key}%");
        }

        if ($request->content) {
            $query->where('content', 'LIKE', "%{$request->content}%");
        }

        if ($request->tag) {
            $query->whereJsonContains('tags', $request->tag);
        }

        return $query->limit(100)->get();
    }

    public function export(Request $request)
    {
        $locale = $request->locale ?? 'en';

        return response()->stream(function () use ($locale) {
            echo Translation::where('locale', $locale)
                ->select('key', 'content')
                ->cursor()
                ->mapWithKeys(fn ($item) => [$item->key => $item->content])
                ->toJson();
        }, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
