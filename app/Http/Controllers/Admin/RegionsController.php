<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Region;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class RegionsController
 *
 * @package App\Http\Controllers\Admin
 */
class RegionsController extends Controller
{


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $regions = Region::where('parent_id', null)
            ->orderBy('name')
            ->paginate(Region::PER_PAGE);

        return view('admin.regions.index', compact('regions'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $parent = null;

        if ($request->get('parent')) {
            $parent = Region::findOrFail($request->get('parent'));
        }

        return view('admin.regions.create', compact('parent'));
    }

    /**
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:regions,name,NULL,id,parent_id,' . ($request['parent'] ?: 'NULL'),
            'slug' => 'required|string|max:255|unique:regions,slug,NULL,id,parent_id,' . ($request['parent'] ?: 'NULL'),
            'parent' => 'nullable|exists:regions,id',
        ]);

        $region = Region::create([
            'name' => $request['name'],
            'slug' => $request['slug'],
            'parent_id' => $request['parent'],
        ]);

        return redirect()->route('admin.regions.show', $region);
    }

    /**
     * @param Region $region
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Region $region)
    {
        $children = Region::where('parent_id', $region->id)
            ->orderBy('name')
            ->paginate(Region::PER_PAGE);

        return view('admin.regions.show', compact('region', 'children'));
    }

    /**
     * @param Region $region
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Region $region)
    {
        return view('admin.regions.edit', compact('region'));
    }

    /**
     * @param Request $request
     * @param Region $region
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Region $region)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:regions,name,' . $region->id . ',id,parent_id,' . $region->parent_id,
            'slug' => 'required|string|max:255|unique:regions,slug,' . $region->id . ',id,parent_id,' . $region->parent_id,
        ]);
        $region->update([
            'name' => $request['name'],
            'slug' => $request['slug'],
        ]);

        return redirect()->route('admin.regions.show', $region);
    }

    /**
     * @param Region $region
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Region $region)
    {
        $region->delete();

        return redirect()->route('admin.regions.index');
    }
}
