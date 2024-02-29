<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Branch;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function getDifferentAccount (Request $request) {
        // Log out the current user
        Auth::logout();
        // Set the intended url to the authorize url
        Session::put("url.intended", $request->current_url);
        // redirect to login form
        return redirect("login");
    }

    public function userTable() {
        $users = User::orderBy('id', 'desc')->get();
        $agns = Agency::all();
        $brns = Branch::all();
        $dpms = Department::all();
        $perms = Permission::all();
        $roles = Role::all();
        return view('pages.user-table', compact('users', 'agns', 'brns', 'dpms', 'perms', 'roles'));
    }

    public function dataTable() {
        $agns = Agency::all();
        $brns = Branch::all();
        $dpms = Department::all();
        $perms = Permission::all();
        $roles = Role::all();
        return view('pages.data-table', compact('agns', 'brns', 'dpms', 'perms', 'roles'));
    }

    public function permTable() {
        $users = User::all();
        $perms = Permission::all();
        $roles = Role::all();
        return view('pages.perm-table', compact('users', 'perms', 'roles'));
    }

    public function addData(Request $request) {
        if ($request->addType === 'agn') {
            Agency::create([
                'name' => $request->agnname,
            ]);
        } elseif ($request->addType === 'brn') {
            Branch::create([
                'name' => $request->bName,
                'agn' => $request->bAgn,
            ]);
        } elseif ($request->addType === 'dpm') {
            Department::create([
                'name' => $request->dName,
                'brn' => $request->dBrn,
                'prefix' => strtoupper($request->prefix ? $request->prefix : substr($request->dName, 0, 3)),
            ]);
        } elseif ($request->addType === 'perm') {
            Permission::create(['name' => $request->permName]);
        } elseif ($request->addType === 'role') {
            Role::create(['name' => $request->roleName]);
        }
        return response()->json(['message' => $request->all()]);
    }

    public function updateData(Request $request) {
        if ($request->addType === 'agn') {
            Agency::find($request->eid)->update([
                'name' => $request->agnname,
            ]);
        } elseif ($request->addType === 'brn') {
            Branch::find($request->eid)->update([
                'name' => $request->bName,
                'agn' => $request->bAgn,
            ]);
        } elseif ($request->addType === 'dpm') {
            Department::find($request->eid)->update([
                'name' => $request->dName,
                'brn' => $request->dBrn,
                'prefix' => strtoupper($request->prefix ? $request->prefix : substr($request->dName, 0, 3)),
            ]);
        }
        return response()->json(['message' => $request->all()]);
    }

    public function deleteData(Request $request) {
        if ($request->deltype === 'agn') {
            Agency::find($request->delid)->delete();
        } elseif ($request->deltype === 'brn') {
            Branch::find($request->delid)->delete();
        } elseif ($request->deltype === 'dpm') {
            Department::find($request->delid)->delete();
        } elseif ($request->deltype === 'perm') {
            $users = User::permission($request->delid)->get();

            foreach ($users as $key => $user) {
                if ($user->hasPermissionTo($request->delid)) {
                    $user->revokePermissionTo($request->delid);
                }
            }

            Permission::findByName($request->delid)->delete();
        } elseif ($request->deltype === 'role') {
            $users = User::with('roles')->get();

            foreach ($users as $key => $user) {
                if ($user->hasRole($request->delid)) {
                    $user->removeRole($request->delid);
                }
            }

            Role::findByName($request->delid)->delete();
        }

        return response()->json(['message' => $request->all()]);
    }

    public function storeUser(Request $request) {
        $dpm = Department::find($request->dpm);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->uname,
            'password' => Hash::make($request->pass),
            'dpm' => $dpm->id,
            'brn' => optional($dpm->getBrn)->id,
            'agn' => optional(optional($dpm->getBrn)->getAgn)->id,
            'role' => '',
            'icon' => '',
        ]);

        if ($request->role) {
            $user->assignRole($request->role);
            $user->role = $request->role;
            $user->save();
        }

        return response()->json(['message' => $request->all()]);
    }

    public function updateUser(Request $request) {
        $dpm = Department::find($request->dpm);
        $user = User::find($request->eid);
        $roles = Role::pluck('name');
        $user->name = $request->name;
        $user->email = $request->uname;
        $user->dpm = $dpm->id;
        $user->brn = optional($dpm->getBrn)->id;
        $user->agn = optional(optional($dpm->getBrn)->getAgn)->id;

        if ($request->pass) {
            $user->password = Hash::make($request->pass);
        }

        if ($request->role) {
            foreach ($roles as $role) {
                if ($user->hasRole($role)) {
                    $user->removeRole($role);
                }
            }

            $user->assignRole($request->role);
            $user->role = $request->role;
            $user->save();
        }

        $user->save();

        return response()->json(['message' => $request->all()]);
    }

    public function deleteUser(Request $request) {
        User::find($request->delId)->delete();
        return response()->json(['message' => $request->all()]);
    }
}
