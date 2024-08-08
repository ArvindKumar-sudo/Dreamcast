<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Response;

class UserAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $html = "";
        $userList = User::get();
        if(count($userList) > 0){
            foreach($userList as $key=>$userRow){
                $html .= '<tr>
                            <td>'.($key+1).'</td>
                            <td>
                                <div class="profile-image">
                                    <a href="javascript:void(0)">
                                        <img style="height: 55px;border-radius: 50%;border: 1px solid #9686F8;max-width: 125%;" alt="Loading..."  src="'.$userRow->profile.'" style="height: 75%;" class="img-fluid lightbox" />
                                    </a>
                                <div>
                            </td>
                            <td>'.(!empty($userRow->name) ? $userRow->name : '--').'</td>
                            <td>'.(!empty($userRow->email) ? $userRow->email : '--').'</td>
                            <td>'.(!empty($userRow->phone) ? $userRow->phone : '--').'</td>
                            <td>'.(!empty($userRow->description) ? $userRow->description : '--').'</td>
                            <td>'.(!empty($userRow->role) ? $userRow->role->name : '--').'</td>
                          </tr>';
            }
        }
        else{
            $html .= '<tr class="text-center"><td colspan="7">No Record</td> </tr>';
        }

        echo $html;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {   //dd($request->post());
        try {
            $validator = Validator::make(request()->all(), [
                'name' => 'required|max:120',
                'email' => 'required|email|unique:user,email',
                'phone' => 'required|numeric|digits:10|phone:IN|unique:user,phone',
                'description' => 'required',
                'role_id' => 'required',
                'profile' => 'required',
            ],
            [
                'phone.phone' => 'The phone number must be a valid india phone number.',
            ]
            );

            if ($validator->fails()) {
                return Response::json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                ), 400);
            }

            $input = $request->only('name', 'email', 'phone', 'description', 'role_id');

            if (!empty($request->file('profile'))) {
                $drive = public_path(DIRECTORY_SEPARATOR . 'upload/profile/' . DIRECTORY_SEPARATOR);
                $extension = $request->file('profile')->getClientOriginalExtension();
                $file_name = uniqid() . '.' . $extension;
                $request->file('profile')->move($drive, $file_name);
                $input['profile'] = 'upload/profile/' . $file_name;
            }
            User::create($input);
            return $this->returnResponse(200, true, "User Created Successfully", []);

        } catch (\Illuminate\Database\QueryException$ex) {
            return $this->returnResponse(200, false, $ex->getMessage());
        } catch (ModelNotFoundException $ex) {
            return $this->returnResponse(200, false, $ex->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
