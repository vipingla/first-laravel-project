<?php namespace App\Repositories;

interface PostRepositoryInterface{
	
	public function getAll();

	public function getPost($id);

    public function deleteUser($id);

    public function getuserbyId($id);

	// more
}