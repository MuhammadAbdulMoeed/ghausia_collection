<?php

namespace App\Http\Controllers;

use App\Helper\ImageUploadHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'ASC')->whereNot('email','admin@gmail.com')->paginate(10);
        return view('backend.users.index')->with('users', $users);
    }

    public function create()
    {
        return view('backend.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'string|required|max:30',
                'email' => 'string|required|unique:users',
                'password' => 'string|required',
                'role' => 'required|in:admin,user',
                'status' => 'required|in:active,inactive',
                'photo' => 'sometimes|mimes:jpeg,jpg,png',  //'string|nullable',
            ]);
        // dd($request->all());
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        // dd($data);
        $data['photo'] = null;
        if ($request->has('photo')) {
            try {
                $data['photo'] = ImageUploadHelper::uploadImage($request->photo, 'upload/photo/');
            } catch (\Exception $e) {
                request()->session()->flash('error','Error in Saving Photo: ' . $e->getMessage());
                return redirect()->back();
            }
        }
        $status = User::create($data);

        if ($status) {
            request()->session()->flash('success', 'Successfully added user');
            return redirect()->route('login.form');
        } else {
            request()->session()->flash('error', 'Error occurred while adding user');
        }

        return redirect()->route('users.index');
        //return redirect()->route('users.index');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.users.edit')->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate($request,
            [
                'name' => 'string|required|max:30',
                'email' => 'string|required',
                'role' => 'required|in:admin,user',
                'status' => 'required|in:active,inactive',
                'photo' => 'sometimes|mimes:jpeg,jpg,png',  //'string|nullable',
            ]);
        // dd($request->all());
        $data = $request->all();
        // dd($data);
        if ($request->has('photo')) {
            try {
                $data['photo'] = ImageUploadHelper::uploadImage($request->photo, 'upload/photo/');
                if (isset($user->photo)) {
                    if (file_exists(public_path($user->photo))) {
                        unlink(public_path($user->photo));
                    }
                }
            } catch (\Exception $e) {
                request()->session()->flash('error','Error in Saving Photo: ' . $e->getMessage());
                return redirect()->back();
            }
        }
        $status = $user->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Successfully updated');
        } else {
            request()->session()->flash('error', 'Error occured while updating');
        }
        return redirect()->route('users.index');

    }

    public function destroy($id)
    {
        $delete = User::findorFail($id);
        $status = $delete->delete();
        if ($status) {
            request()->session()->flash('success', 'User Successfully deleted');
        } else {
            request()->session()->flash('error', 'There is an error while deleting users');
        }
        return redirect()->route('users.index');
    }
}
