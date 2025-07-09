<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {

    }

    public function me()
    {
        $data['user'] = User::where('user.id', Auth::user()->id)
				->with([
					'gurdian:id,name,user_image',
					'parent:id,name,user_image',
					'location_data:location_name,id',
				])
				->with('userDetails', function ($q) {
					$q->select(
						'user_details.id',
						'user_details.user_id',
						'user_details.email',
					)
						->leftjoin("designation as d", "d.id", "user_details.designation_id")
						->leftjoin("department as dp", "dp.id", "user_details.department_id");
				})
				->first([
					'id',
					'name',
					'user_login_name',
					'email',
					'password',
					'user_image',
					'location_id'
				]);
                $useraddress = null;
			$user['gurddian_id'] = '0';
			$data['user']['is_active'] = '';
			$data['user']['address'] = $useraddress;

            return $data;
    }
	// used in controller 
    // $userData = $this->gurdianController->read($id, ['id']);
    // $userData = [];
	// if (!$userData) {
	//     return 'somthnig wents to wrong';
	// }

    // public function read($id,$fields = []);

	// use in repo
    public function read($id, $fields = [])
    {
        $fieldsData = (!empty($fields) ? $fields : '*');
        return $this->user->select($fieldsData)->find($id);
    }
	

}
