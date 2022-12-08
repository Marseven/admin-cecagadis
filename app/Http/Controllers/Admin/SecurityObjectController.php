<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BasicController;
use App\Models\SecurityObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityObjectController extends BasicController
{
    public function __construct()
    {
        $this->setModel(new SecurityObject());
    }

    public function index()
    {

        $objects = SecurityObject::all();
        return view('admin.security-object.index', [
            'objects' => $objects,
        ]);
    }


    public function save(Request $request)
    {


        $object =  new SecurityObject();

        if ($request->get('_id') != 0) $object = SecurityObject::find($request->get('_id'));
        $object->name = $request->get('name');
        $object->url = $request->get('url');
        $object->icon = $request->get('icon');
        $object->enable = $request->get('enable');
        $object->user_id = Auth::user()->id;
        $object->save();

        return redirect()->back()->with('success', 'Espace créé avec succès.');
    }
}
