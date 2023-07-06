<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rule;
use App\Models\User;

class UserRoleController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res=User::with('rules:id,name')->has('rules')->where('name','!=','Admin')->get();
        $data=[];
        foreach($res as $r){
            $data[]=[
                'user'=>$r->name,
                'role'=>$r->rules->pluck('name')->implode(', ')
            ];
        }
        return $this->apiResponse($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addRole(Request $request,$uid,$rid)
    {
        $user=User::findOrFail($uid);
        $rule=Rule::findOrFail($rid);
        $user->rules()->attach($rule);
        return $this->SuccessResponse('Added role successfuly for this user',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uid,$rid)
    {
        $user=User::findOrFail($uid);
        $role=Rule::findOrFail($rid);
        if($user && $role){
            $user->rules()->detach($role);
            return $this->SuccessResponse('Deleted Role from this user',200);
        }
        else{
            return $this->errorResponse('An error occured',403);
        }


    }
}
