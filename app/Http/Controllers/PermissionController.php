<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\RoleGroupPermission;
use App\Models\RoleGroup;

class PermissionController extends Controller
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
        $permission = Permission::orderBy('created_at' , 'desc')->get();

        $rolegrouppermission = RoleGroupPermission::all();

        $rolegroup = RoleGroup::all();

        return view('permission.index')->with('rolegroup', $rolegroup)->with('permission', $permission)->with('rolegrouppermission', $rolegrouppermission);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rolegroup = RoleGroup::all();
        

        return view('permission.create')->with('rolegroup', $rolegroup);
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

        // Create Permission
        $permission = new Permission;
        $permission->Name = $request->input('Name');
        $permission->save();
        
        //dd( $permission->id); 

        if( $request->rolegrouprolearray != null )
        {                       
            for ($i=0; $i < count($request->rolegrouprolearray); $i++) {  
                $rolegrouppermission = new RoleGroupPermission;  
                $rolegrouppermission->RoleGroup_ID = $request->rolegrouprolearray[$i];
                $rolegrouppermission->Permission_ID = $permission->id;
                $rolegrouppermission->save();
            }
            
        }


        return redirect('/permission')->with('success', 'Permission Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::find($id);

        $rolegrouppermission = RoleGroupPermission::where('Permission_ID' , '=' , $id)->get();

        if ($rolegrouppermission != '[]') {
            foreach($rolegrouppermission as $rolegrouppermissions)
            {
                $rolegroup = RoleGroup::where('id' , '=' , $rolegrouppermissions->RoleGroup_ID)->first();
                if ($rolegroup != null) {
                    $rolegroup_name[] = $rolegroup->Name; 
                }
            }
        }
        else
        {
            $rolegroup_name[] = null;
        }

        return view('permission.show')->with('rolegroup_name', $rolegroup_name)->with('permission', $permission);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        
        //Check if Permission exists before deleting
        if (!isset($permission)){
            return redirect('/permission')->with('error', 'No Permission Found');
        }

        $rolegrouppermission = RoleGroupPermission::where('Permission_ID' , '=' , $id)->get();


        if ($rolegrouppermission != '[]') {
            foreach($rolegrouppermission as $rolegrouppermissions)
            {
                $rolegroup = RoleGroup::where('id' , '=' , $rolegrouppermissions->RoleGroup_ID)->first();
                if ($rolegroup != null) {
                    $rolegroup_name[] = $rolegroup->Name; 
                }
            }
            $array_size = 'notempty';
        }
        else
        {
            $rolegroup_name[] = null;

            $array_size = 'empty';
        }

        $rolegroup = RoleGroup::all();

        return view('permission.edit')->with('array_size', $array_size)->with('rolegroup_name', $rolegroup_name)->with('rolegroup', $rolegroup)->with('permission', $permission);
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

        $permission = Permission::find($id);
        $permission->Name = $request->input('Name');
        $permission->save();

        $rolegrouppermissiondisabled = RoleGroupPermission::where('Permission_ID' , '=' , $id)->get(); 

        
        if ($rolegrouppermissiondisabled != '[]') {
          
            foreach ($rolegrouppermissiondisabled as $rolegrouppermissiondisableds) {
                $array[] = $request->rolegrouprolearray;           
                $rolegroup_id = $rolegrouppermissiondisableds->RoleGroup_ID;

                if(!in_array($rolegroup_id , $array))
                {  
                    RoleGroupPermission::where('Permission_ID' , '=' , $id)->where('RoleGroup_ID' , '=' , $rolegrouppermissiondisableds->RoleGroup_ID)->delete();
                }
            }
        }

        if( $request->rolegrouprolearray != null)
        {
            
            for ($i=0; $i < count($request->rolegrouprolearray); $i++) { 

                $rolegrouppermission = RoleGroupPermission::where('Permission_ID' , '=' , $id)->where('RoleGroup_ID' , '=' , $request->rolegrouprolearray[$i])->first();   
                
                if ($rolegrouppermission != '[]'){
                    $rolegrouppermission = new RoleGroupPermission;
                    $rolegrouppermission->Permission_ID = $id;
                    $rolegrouppermission->RoleGroup_ID = $request->rolegrouprolearray[$i];
                    $rolegrouppermission->save(); 
                }        
            }

        }


        return redirect('/permission')->with('success', 'Permission Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::find($id);
        
        $rolegrouppermission = RoleGroupPermission::where('Permission_ID' , '=' , $id)->delete();
        
        //Check if post exists before deleting
        if (!isset($permission)){
            return redirect('/permission')->with('error', 'No Permission Found');
        }
        
        $permission->delete();

        return redirect('/permission')->with('success', 'Permission Removed');
    }
}
