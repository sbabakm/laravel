<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //$this->middleware('can:edit-user,user')->only(['edit']);
    }

    public function index()
    {

        $users = User::query();

       if($keyword = request('search')) {
            $users->where('email','LIKE',"%{$keyword}%")->orWhere('name','LIKE',"%{$keyword}%")->orWhere('id',$keyword);
       }

       if(request('admin')) {
           $users->where('is_superuser', 1)->orWhere('is_staff', 1);
       }

       $users = $users->paginate(10);
       //$users = User::paginate(10);


        return view('admin.users.all' , compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request->all());

       $validate_data = $request->validate([
           'name' => ['required', 'string', 'max:255'],
           'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
           'password' => ['required', 'string', 'min:8', 'confirmed'],
           'permissions' => ['array']
       ]);

       //$user = User::create($validate_data);
       $user = User::create([
           'name' => $validate_data['name'],
           'email' => $validate_data['email'],
           'password' => bcrypt($validate_data['password'])
       ]);

       $user->permissions()->sync($validate_data['permissions']);

        if($request->has('verify')) {
            $user->markEmailAsVerified();
        }

       return redirect(route('admin.users.index'));
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
    public function edit(User $user)
    {
        //dd($user);
//        if(Gate::allows('edit-user', $user)) {
//            return view('admin.users.edit' , ['user' => $user]);
//        }
//        abort(403);

//        if(Gate::denies('edit-user', $user)) {
//            abort(403);
//        }
//        return view('admin.users.edit' , ['user' => $user]);

//        $this->authorize('edit-user', $user);

        if(Gate::allows('edit', $user)) {
            return view('admin.users.edit' , compact('user'));
        }
        abort(403);

       // return view('admin.users.edit' , ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {


        $validate_data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',Rule::unique('users')->ignore($user->id)],
            'permissions' => ['array']
        ]);

        if(! is_null($request->password)) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $validate_data['password'] = $request->password;

            $user->update([
                'name' => $validate_data['name'],
                'email' => $validate_data['email'],
                'password' => bcrypt($validate_data['password']),
            ]);
        }
        else {

            $user->update([
                'name' => $validate_data['name'],
                'email' => $validate_data['email'],
            ]);
        }

        $user->permissions()->sync($validate_data['permissions']);

//        $user->update($validate_data);

        $pre_value_email_verified_at = is_null($user->email_verified_at);

        if($request->has('verify') && $pre_value_email_verified_at ) {
            $user->markEmailAsVerified();
        }
        elseif(!$request->has('verify')){
            $user->forceFill(['email_verified_at' => null])->save();
        }


        return redirect(route('admin.users.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route('admin.users.index'));
    }
}
