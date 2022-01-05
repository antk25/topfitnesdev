<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Http\Requests\Admin\GradeRequest;
use Illuminate\Support\Str;


class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $grades = Grade::paginate(20);
        return view('admin.grades.index', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.grades.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GradeRequest $request)
    {
        Grade::create([
            'name' => request('name'),
            'about' => request('about')
        ]);

        return redirect()->route('grades.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $grade = Grade::find($id);

        return view('admin.grades.edit', compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function update(GradeRequest $request, Grade $grade)
    {

        $grade->update([
            'name' => request('name'),
            'about' => request('about')
        ]);

        return redirect()->route('grades.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Grade::destroy($id);

        return back();
    }
}
