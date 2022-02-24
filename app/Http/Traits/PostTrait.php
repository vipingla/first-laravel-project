<?php

namespace App\Http\Traits;
use App\Models\Userdata;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Repositories\PostRepositoryInterface;

trait PostTrait {

    private $repository;
	
	/**
	 * __construct
	 *
	 * @param  mixed $repository
	 * @return void
	 */
	public function __construct(PostRepositoryInterface $repository)
	{
	   $this->repository = $repository;
	}
	
	/**
	 * index
	 * this function used to display form and user data listing
	 * @return void
	 */
	public function index(){
		$data = $this->repository->getAll();
		return view('user-data-form')->with('data', $data);
	}

	/**
     * deleteUser
     * use to delete user data using user id
     * @param  mixed $id
     * @return void
     */
    public function deleteUser($id)
    {
        $userID = Crypt::decrypt($id);
        $data = $this->repository->deleteUser($userID);
        //return Userdata::where('id',$userID)->delete();
    }

    /**
     * getuser
     * this return the single user data using id
     * @param  mixed $id
     * @return void
     */
    public function getuser($id)
    {
        $userID = Crypt::decrypt($id);
        $UserData = $this->repository->getuserbyId($userID);
        return $UserData;
    }    
    /**
     * store
     * this function used to save user form data 
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:userdatas',
            'skills' => 'required',
            'expertise' => 'required',
        ]);
        
        $post = new Userdata;
        $post->name = $this->clean($request->name);
        $post->skills = $this->clean($request->skills);
        $post->expertise = $request->expertise;
        try {
            $post->save();
            return redirect('user-data-form')->with('status', 'User Data Has Been inserted');
        }
        catch (\Exception $e) {
            return redirect('user-data-form')->with('error', 'Something went wrong!!')->withInput();
        }
    }
    
    /**
     * updateUser
     * this funtion is used to update user record
     * @param  mixed $request
     * @return void
     */
    public function updateUser(Request $request)
    {
        if($request->name != $request->oldUserName)
        {
            $request->validate([
                'name' => 'required|unique:userdatas',
                'skills' => 'required',
                'expertise' => 'required',
            ]);
        }
        else
        {
            $request->validate([
                'name' => 'required',
                'skills' => 'required',
                'expertise' => 'required',
            ]);    
        }
        
        //$post = new Userdata;
        //$post->id = $request->user_id;
        $post = Userdata::find($request->user_id);
        $post->name = $this->clean($request->name);
        $post->skills = $this->clean($request->skills);
        $post->expertise = $request->expertise;
        try {
            $post->save();
            //return redirect('user-data-form')->with('status', 'User Data Has Been inserted');
            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'User data updated succesfully.',
            ]);
        }
        catch (\Exception $e) {
            //return redirect('user-data-form')->with('error', 'Something went wrong!!')->withInput();
            return response()->json([
                'status' => false,
                'code' => 401,
                'message' => 'User data updated succesfully.',
                'oldData' => $request->all()
            ]);
        }
    }
        
    /**
     * clean
     * sanitize the input
     * @param  mixed $string
     * @return void
     */
    protected function clean($string) {
        $string = preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
        //$string = preg_replace('/[^a-zA-Z0-9_ -]/s','',$string);
        $string = preg_replace('/[0-9]+/', '', $string); // remove all numbers
        $string = trim($string); // trim all spaces
        return $string; 
        //return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }

}