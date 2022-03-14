<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Http\Requests\LocationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Gate;

class LocationController extends Controller
{
    public function index()
    {
        $location = Location::orderBy('loc')->paginate(10);
        return view('locations.index', compact('location'));
    }

    public function create()
    {
        Gate::authorize('create-ticket');
        return view('locations.create');
    }
    
    public function store(LocationRequest $request)
    {
        $location = Location::make($request->only('loc'));
        $location->save();
        return redirect()
            ->route('locations.index')
            ->with('toast_success', 'Lokasi telah ditambah');
    }

    public function edit(Location $location)
    {
        Gate::authorize('manage');
        return view('locations.edit', compact('location'));
    }

    public function destroy(Location $location)
    {
        Gate::authorize('manage');
        $location->delete();
        return redirect()->route('locations.index')
            ->with('toast_success', 'Lokasi berhasil dihapus');
    }

    public function update(LocationRequest $request, Location $location)
    {
        Gate::authorize('manage');
        $location->update($request->only('loc'));

        $location->save();

        return response()->redirectTo(route('locations.index'))
            ->with('toast_success', 'Lokasi telah diupdate');
    }
}
