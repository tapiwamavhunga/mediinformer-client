<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Corcel\Model\Post;
use Corcel\Model\Taxonomy;
use Corcel\Acf\Field\BasicField;
use Corcel\Acf\FieldFactory;
use Corcel\Acf\Field\PostObject;
use App\Models\SMS;
use App\Models\UserSettings;
use App\Models\EmailTracking;
use App\Models\Company;
use App\Models\Emails;
use App\Models\Verify;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
 use DataTables;


use App\Models\User;

use DB;
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
   

    protected function index(){
       $result = array(); 
       $posts = Post::type('medicalbrochure')->status('publish')->get();
       // $posts = Post::published()->newest()->paginate(200);

         if ( $posts ) {
                foreach ( $posts as $key => $post ) {
                    $first_letter = substr($post->post_title,0,1);
                    if( ! empty( $first_letter ) ) {
                        $result[$first_letter][] = array(
                            'ID' => $post->ID,
                            'title' => $post->post_title,
                            'meta'=> $post->meta->brochure_type,
                            'link'=> $post->meta->link,
                        );
                    }
                }
            }


        if( ! empty( $result ) ) {
            ksort( $result );
        }

        $categories = Taxonomy::where('taxonomy', 'category')->get();

        
        // $cat->each(function($category) {
        //     echo $category->name;
        // });

        // foreach ($categories as $cat) {
        //     var_dump($cat) ;
        // }

        

        $viewShareVars = ['result','categories'];
        return view('home',compact($viewShareVars));
    }

   

   public function adminVerify(){
        $verify = Verify::latest()->paginate(50);
        $users = User::latest()->paginate(50);

      $viewShareVars = ['users', 'verify'];
        return view('adminVerify',compact($viewShareVars));
   }


   public function adminHome()

    {   

    $result = array(); 
    $posts = Post::type('medicalbrochure')->status('publish')->paginate(6);



    $users = User::latest()->paginate(5);
    $user_id = auth()->user()->id;

    $user = auth()->user();
    $usersettings = UserSettings::where('user_id', $user_id)->first();

    $viewShareVars = ['user','posts', 'users', 'usersettings'];

        return view('adminHome',compact($viewShareVars));

    }


     public function adminCompanies()

    {   
        $users = User::latest()->paginate(5);
        $posts = Post::type('medicalbrochure')->status('publish')->paginate(6);
        $companies = Company::all();
        $user_id = auth()->user()->id;
        $user = auth()->user();

        $viewShareVars = ['user','posts', 'users', 'companies'];

        return view('adminCompanies',compact($viewShareVars));

    }


    public function getusers(Request $request)

    {
        $user = auth()->user();
        $user_id = auth()->user()->id;
        $users = User::latest()->paginate(5);
        $usersettings = UserSettings::where('user_id', $user_id)->first();

        if ($request->ajax()) {

            $data = User::select('*');

            return Datatables::of($data)

                    ->addIndexColumn()

                    ->addColumn('action', function($row){

       

                           $btn = '<a href="javascript:void(0)" class="edit btn btn-info btn-sm">View</a>';

                           $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';

                           $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>';

         

                            return $btn;

                    })

                    ->rawColumns(['action'])

                    ->make(true);

        }

        
         $viewShareVars = ['users', 'user', 'usersettings'];
        return view('adminUsers',compact($viewShareVars));
        //return view('users');

    }



    public function adminUsers()

    {   


        $users= User::paginate(50); //Eloquent ORM

        $user = auth()->user();
        $user_id = auth()->user()->id;
        $usersettings = UserSettings::where('user_id', $user_id)->first();
        // print_r($usersettings);
        $viewShareVars = ['users', 'user', 'usersettings'];
        return view('adminUsers',compact($viewShareVars));

    }


    public function adminBrochures()

    {   


        ds('Hello World');
        die();
        $users = User::latest()->paginate(25);

        $user = auth()->user();
        $user_id = auth()->user()->id;
            $posts = Post::type('medicalbrochure')->status('publish')->paginate(25);

        $viewShareVars = ['users', 'user', 'posts'];

        return view('adminBrochures',compact($viewShareVars));

    }


    
    public function adminSettings()

    {   

    // $result = array(); 
    //    $posts = Post::type('medicalbrochure')->status('publish')->take(6)->get();;
       
         $user = auth()->user();
    //             $viewShareVars = ['user','posts'];

       $users = User::latest()->paginate(5);
        $viewShareVars = ['users', 'user'];
        return view('adminSettings',compact($viewShareVars));

    }


    public function edit(User $user)
    {   
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }
    
     public function update(User $user)
    { 
        if(Auth::user()->email == request('email')) {
        
        $this->validate(request(), [
                'name' => 'required',
              //  'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed'
            ]);

            $user->name = request('name');
           // $user->email = request('email');
            $user->password = bcrypt(request('password'));
            $user->save();
            return back();
            
        }
        else{
            
        $this->validate(request(), [
                'name' => 'required',
                //'email' => 'required|email|unique:users',
                'email' => 'email|required|unique:users,email,'.$this->segment(2),
                'password' => 'required|min:6|confirmed'
            ]);

            $user->name = request('name');
            $user->email = request('email');
            $user->password = bcrypt(request('password'));

            $user->save();

            return back();  
            
        }
    }
   

   

      public function reports(){ 

       



        $user = auth()->user();
        $user_id = auth()->user()->id;

        $reports = Emails::where('user_id', $user_id)->get();

        //dd($reports);

         $sms_reports_count = SMS::where('user_id', $user_id)->count();
         $sms_reports = SMS::where('user_id', $user_id)->get();



        $viewShareVars = ['user','reports', 'sms_reports_count', 'sms_reports'];

        return view('reports', compact($viewShareVars));

     }



       public function sms_reports(){ 

        $user = auth()->user();
        $user_id = auth()->user()->id;
        $reports = EmailTracking::where('user_id', $user_id)->first();
        
        $viewShareVars = ['user','reports'];

        return view('sms_reports', compact($viewShareVars));

     }



}


