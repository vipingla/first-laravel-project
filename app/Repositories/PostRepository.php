<?php namespace App\Repositories;

use App\Models\Userdata;

class PostRepository implements PostRepositoryInterface
{
	public function getAll(){
		return Userdata::orderBy('id', 'desc')->paginate(5);
	}

	public function getPost($id){
		return Userdata::findOrFail($id);
	}

    public function deleteUser($id){
		return Userdata::where('id',$id)->delete();        
	}

    public function getuserbyId($id){
		return Userdata::where('id', $id)->first();     
	}

	// more 

}