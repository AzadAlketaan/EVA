<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\User;
use App\Models\UserRoleGroup;
use App\Models\RoleGroup;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('CheckPermission');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::orderBy('created_at', 'asc')->paginate(10);

        return view('user.index')->with('user', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'First_Name' => 'required|string|max:255',
            'Last_Name' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'profile_image' => 'image|nullable|max:1999',
            'cover_image' => 'image|nullable|max:1999',
        ]);

        // Handle File Upload
        if ($request->hasFile('cover_image')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_image', $fileNameToStore);

            // make thumbnails
            $thumbStore = 'thumb.' . $filename . '_' . time() . '.' . $extension;
            $thumb = Image::make($request->file('cover_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/cover_image/' . $thumbStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Handle File Upload
        if ($request->hasFile('profile_image')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('profile_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('profile_image')->storeAs('public/profile_image', $fileNameToStore);

            // make thumbnails
            $thumbStore = 'thumb.' . $filename . '_' . time() . '.' . $extension;
            $thumb = Image::make($request->file('profile_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/profile_image/' . $thumbStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Create User
        $user = new User();
        $user->First_Name = $request->input('First_Name');
        $user->Last_Name = $request->input('Last_Name');
        $user->Email = $request->input('Email');
        $user->Phone_Number = $request->input('Phone_Number');
        $user->password = bcrypt($request->input('password'));
        $user->Facebook_Account = $request->input('Facebook_Account');
        $user->Instgram_Account = $request->input('Instgram_Account');
        $user->Description = $request->input('Description');
        $user->cover_image = $fileNameToStore;
        $user->profile_image = $fileNameToStore;
        $user->save();

        return redirect('/user')->with('success', 'User Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $userrolegroup = UserRoleGroup::where('User_ID', '=', $id)->get();

        if ($userrolegroup != '[]') {
            foreach ($userrolegroup as $userrolegroups) {
                $rolegroup = RoleGroup::where('id', '=', $userrolegroups->RoleGroup_ID)->first();
                if ($rolegroup != null) {
                    $rolegroup_name[] = $rolegroup->Name;
                }
            }
        } else {
            $rolegroup_name[] = null;
        }

        return view('user.show')
            ->with('user', $user)
            ->with('rolegroup_name', $rolegroup_name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        //Check if user exists before deleting
        if (!isset($user)) {
            return redirect('/user')->with('error', 'No User Found');
        }

        return view('user.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'First_Name' => 'required|string|max:255',
            'Last_Name' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'profile_image' => 'image|nullable|max:1999',
            'cover_image' => 'image|nullable|max:1999',
        ]);

        $user = User::find($id);

        // Handle File Upload
        if ($request->hasFile('cover_image')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_image', $fileNameToStore);
            // Delete file if exists
            Storage::delete('public/cover_image/' . $user->cover_image);

            //Make thumbnails
            $thumbStore = 'thumb.' . $filename . '_' . time() . '.' . $extension;
            $thumb = Image::make($request->file('cover_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/cover_image/' . $thumbStore);
        }

        // Handle File Upload
        if ($request->hasFile('profile_image')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('profile_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('profile_image')->storeAs('public/profile_image', $fileNameToStore);
            // Delete file if exists
            Storage::delete('public/profile_image/' . $user->profile_image);

            //Make thumbnails
            $thumbStore = 'thumb.' . $filename . '_' . time() . '.' . $extension;
            $thumb = Image::make($request->file('profile_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/profile_image/' . $thumbStore);
        }

        // Update User
        $user->First_Name = $request->input('First_Name');
        $user->Last_Name = $request->input('Last_Name');
        $user->Email = $request->input('Email');
        $user->Phone_Number = $request->input('Phone_Number');
        $user->password = bcrypt($request->input('password'));
        $user->Facebook_Account = $request->input('Facebook_Account');
        $user->Instgram_Account = $request->input('Instgram_Account');
        $user->Description = $request->input('Description');
        $user->save();
        if ($request->hasFile('profile_image')) {
            $user->profile_image = $fileNameToStore;
        }
        if ($request->hasFile('cover_image')) {
            $user->cover_image = $fileNameToStore;
        }
        $user->save();

        return redirect('/user')->with('success', 'User Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        //Check if user exists before deleting
        if (!isset($user)) {
            return redirect('/user')->with('error', 'No User Found');
        }

        if ($user->cover_image != 'noimage.jpg') {
            // Delete Image
            Storage::delete('public/cover_image/' . $user->cover_image);
        }

        if ($user->profile_image != 'noimage.jpg') {
            // Delete Image
            Storage::delete('public/profile_image/' . $user->cover_image);
        }

        $user->delete();

        $userrolegroup = UserRoleGroup::where('User_ID', '=', $id)->delete();

        return redirect('/user')->with('success', 'User Removed');
    }

    public function assignroles($user_id)
    {
        $userrolegroup = UserRoleGroup::where('User_ID', '=', $user_id)->get();

        if ($userrolegroup != '[]') {
            foreach ($userrolegroup as $userrolegroups) {
                $rolegroup = RoleGroup::where('id', '=', $userrolegroups->RoleGroup_ID)->first();
                if ($rolegroup != null) {
                    $rolegroup_name[] = $rolegroup->id;
                }
            }
        } else {
            $rolegroup_name[] = null;
        }
        $rolegroup = RoleGroup::all();
        $user = User::find($user_id);

        return view('user.assignroles')
            ->with('rolegroup', $rolegroup)
            ->with('rolegroup_name', $rolegroup_name)
            ->with('user', $user);
    }

    public function submitassignroles(Request $request, $id)
    {
        $userrolegroupdisabled = UserRoleGroup::where('User_ID', '=', $id)->get();

        foreach ($userrolegroupdisabled as $userrolegroupdisableds) {
            $array[] = $request->userrolegrouparray;
            $rolegroup_id = $userrolegroupdisableds->RoleGroup_ID;

            if (!in_array($rolegroup_id, $array)) {
                UserRoleGroup::where('User_ID', '=', $id)
                    ->where('RoleGroup_ID', '=', $userrolegroupdisableds->RoleGroup_ID)
                    ->delete();
            }
        }

        if ($request->userrolegrouparray != null) {
            for ($i = 0; $i < count($request->userrolegrouparray); $i++) {
                $userrolegroup = UserRoleGroup::where('User_ID', '=', $id)
                    ->where('RoleGroup_ID', '=', $request->userrolegroup[$i])
                    ->first();

                if ($userrolegroup != '[]') {
                    $userrolegroup = new UserRoleGroup();
                    $userrolegroup->User_ID = $id;
                    $userrolegroup->RoleGroup_ID = $request->userrolegrouparray[$i];
                    $userrolegroup->save();
                }
            }
        }

        return redirect('/user')->with('success', 'Roles Assigned');
    }
}
