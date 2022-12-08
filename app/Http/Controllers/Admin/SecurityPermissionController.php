<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BasicController;
use App\Models\SecurityPermission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityPermissionController extends BasicController
{
    public function __construct()
    {
        $this->setModel(new SecurityPermission());
    }

    public function index()
    {

        $permissions = SecurityPermission::all();
        return view('admin.security-permission.index', [
            'permissions' => $permissions,
        ]);
    }

    public function save(Request $request)
    {

        $permission =  new SecurityPermission();

        if ($request->get('_id') != 0) $permission = SecurityPermission::find($request->get('_id'));
        $permission->name = $request->get('name');
        $permission->description = $request->get('description');
        $permission->user_id = Auth::user()->id;
        $permission->save();

        return redirect()->back()->with('success', 'Permission créée avec succès.');
    }
}
