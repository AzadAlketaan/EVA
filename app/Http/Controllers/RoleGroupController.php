<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleGroup;
use App\Models\RoleGroupPermission;
use App\Models\Permission;

class RoleGroupController extends Controller
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
        $rolegroup = RoleGroup::orderBy('created_at')->paginate(10);
        return view('rolegroup.index')->with('rolegroup', $rolegroup);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $permission = Permission::all();
        
        return view('rolegroup.create')->with('permission', $permission);
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
            'Name' => 'required',
        ]);

        // Create RoleGroup
        $rolegroup = new RoleGroup;
        $rolegroup->Name = $request->input('Name');
        $rolegroup->save();
        
        if( $request->rolegrouppermissionarray != null)
        {
            for ($i=0; $i < count($request->rolegrouppermissionarray); $i++) {   
                $rolegrouppermission = new RoleGroupPermission;
                $rolegrouppermission->RoleGroup_ID = $rolegroup->id;
                $rolegrouppermission->Permission_ID = $request->rolegrouppermissionarray[$i];
                $rolegrouppermission->save();
            }
        }

        return redirect('/rolegroup')->with('success', 'RoleGroup Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rolegroup = RoleGroup::find($id);

        $rolegrouppermission = RoleGroupPermission::where('RoleGroup_ID' , '=' , $id)->get();

        if ($rolegrouppermission != '[]') {
            foreach($rolegrouppermission as $rolegrouppermissions)
            {
                $permission = Permission::where('id' , '=' , $rolegrouppermissions->Permission_ID)->first();
                if ($permission != null) {
                    $permission_name[] = $permission->Name; 
                }
            }
        } 
        else
        {
            $permission_name[] = null;
        }

        return view('rolegroup.show')->with('rolegroup', $rolegroup)->with('permission_name', $permission_name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rolegroup = RoleGroup::find($id);
        
        //Check if RoleGroup exists before deleting
        if (!isset($rolegroup)){
            return redirect('/rolegroup')->with('error', 'No RoleGroup Found');
        }

        $rolegrouppermission = RoleGroupPermission::where('RoleGroup_ID' , '=' , $id)->get();

        if ($rolegrouppermission != '[]') {
            foreach($rolegrouppermission as $rolegrouppermissions)
            {
                $permission = Permission::where('id' , '=' , $rolegrouppermissions->Permission_ID)->first();
                if ($permission != null) {
                    $permission_name[] = $permission->id; 
                }
            }
        }
        else
        {
            $permission_name[] = null;
        }
        $permission = Permission::all();

        return view('rolegroup.edit')->with('permission', $permission)->with('rolegroup', $rolegroup)->with('permission_name', $permission_name);
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
            'Name' => 'required',
        ]);
        
        $rolegroup = RoleGroup::find($id);
        $rolegroup->Name = $request->input('Name');
        $rolegroup->save();
       
        $rolegrouppermissiondisabled = RoleGroupPermission::where('RoleGroup_ID' , '=' , $id)->get(); 

        foreach ($rolegrouppermissiondisabled as $rolegrouppermissiondisableds) {
            $array[] = $request->rolegrouppermissionarray;
            $permission_id = $rolegrouppermissiondisableds->Permission_ID;

            if(!in_array($permission_id , $array))
            {  
                RoleGroupPermission::where('RoleGroup_ID' , '=' , $id)->where('Permission_ID' , '=' , $rolegrouppermissiondisableds->Permission_ID)->delete();
            }
        }

        if( $request->rolegrouppermissionarray != null)
        {
            for ($i=0; $i < count($request->rolegrouppermissionarray); $i++) {   
                
                $rolegrouppermission = RoleGroupPermission::where('RoleGroup_ID' , '=' , $id)->where('Permission_ID' , '=' , $request->rolegrouppermission[$i])->first();   

                if ($rolegrouppermission != '[]'){
                    $rolegrouppermission = new RoleGroupPermission;
                    $rolegrouppermission->RoleGroup_ID = $id;
                    $rolegrouppermission->Permission_ID = $request->rolegrouppermissionarray[$i];
                    $rolegrouppermission->save(); 
                }                
            }
        }
            
        return redirect('/rolegroup')->with('success', 'RoleGroup Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rolegroup = RoleGroup::find($id);
        
        //Check if post exists before deleting
        if (!isset($rolegroup)){
            return redirect('/rolegroup')->with('error', 'No RoleGroup Found');
        }
        
        $rolegroup->delete();

        $rolegrouppermission = RoleGroupPermission::where('RoleGroup_ID' , '=' , $id)->delete();


        return redirect('/rolegroup')->with('success', 'RoleGroup Removed');
    }
}
