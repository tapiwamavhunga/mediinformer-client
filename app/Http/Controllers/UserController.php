<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\UserSettings;
use Illuminate\Http\Request;
use Corcel\Model\Post;
use Corcel\Model\Taxonomy;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
  

     public function __construct()
    {
        $this->middleware('auth', ['except' => [ 'profile']]);
    }
    public function profile($id)
    {
        $user = User::find($id);
        $user_id = auth()->user()->id;
        $usersettings = UserSettings::where('user_id', $user_id)->first();
        return view('user.profile', compact('user', 'usersettings') );
    }


    public function settings($id)
    {
        $user = User::find($id);
        return view('user.settings', compact('user') );
    }
    

    public function profileUpdate(Request $request){
        //validation rules

        $request->validate([
            'name' =>'required|min:4|string|max:255',
            'email'=>'required|email|string|max:255'
        ]);
        $user =Auth::user();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->save();
        return back()->with('message','Profile Updated');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(100);
        $user = auth()->user();
       //         $viewShareVars = ['users, user'];

       //  return view('user.index',compact($viewShareVars))
       //      ->with('i', (request()->input('page', 1) - 1) * 5);
                $usersettings = UserSettings::where('user_id', $user->id)->first();

        $user = auth()->user();
                $viewShareVars = ['user','users', 'usersettings'];

        return view('user.index',compact($viewShareVars));
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
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
    
        User::create($request->all());
     
        return redirect()->route('admin.users')
                        ->with('success','User created successfully.');
    }
     
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        $user_id = auth()->user()->id;
        $usersettings = UserSettings::where('user_id', $user->id)->first();

        return view('user.show',compact('user', 'usersettings'));
    } 
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit',compact('user'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

      
        if($request->hasFile('image')){
            $request->validate([
              'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);
            $path = $request->file('image')->store('public/images');
            $user->image = $path;
        }
        $user = \auth::user();

        $user->is_admin = $request['is_admin'];
        $user->is_verified = $request['is_verified'];

        $user->update($request->all());
        return redirect()->route('home')
                        ->with('success','Post updated successfully');



  


    }

    public function verifypractice(Request $request, User $user)
    {
        return view('user.verify_practice',compact('user'));
    }


      public function updatepractice(Request $request, $id){
      
        $myuser = User::find($id);
        
        $myuser->is_admin = $request['is_admin'];
        $myuser->is_verified = $request['is_verified'];
        $myuser->save();
        return back()->with('message','Profile Updated');
    }


    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    
        return redirect()->route('user.index')
                        ->with('success','User deleted successfully');
    }
   




}


