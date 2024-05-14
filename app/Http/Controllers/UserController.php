<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\LoginService;
use App\Http\Requests\LoginRequest;

class UserController extends Controller
{
    private LoginService $loginService;
    private UserService $userService;

    public function __construct()
    {
        $this->loginService = new LoginService;
        $this->userService = new UserService;

    }

    public function login(LoginRequest $request)
    {

            $dataUser = ['ci' => $request->ci, 'password' => $request->password];
            $this->loginService->tryLoginOrFail($dataUser);
            $token = $this->loginService->generateToken($dataUser);
            $user = auth()->user();
            $permissionsArray = $this->userService->getPermissions($user->id);

            $permissionsWithFormat = $this->userService->formatToPermissions($permissionsArray);

            return inertia::location('/dashboard');

            // return inertia('Index', 
            // [
            //     'token' => $token,
            //     'user_data' => 
            //     [
            //         'area_id' => $user->area_id, 
            //         'type_user_id' => $user->type_user_id, 
            //         'name' => $user->name, 
            //         'last_name' => $user->last_name, 
            //         'ci' => $user->ci, 
            //         'username' => $user->username, 
            //         'charge' => $user->charge,
            //         'permissions' => $permissionsWithFormat
            //     ],

            // ]);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json(['message' => 'Session eliminada']);
    }

    public function changePassword(UpdatePasswordRequest $request)
    {   
        $data = [
            'oldPassword' => $request->oldPassword,
            'newPassword' => $request->newPassword,
            'confirmPassword' => $request->confirmPassword
        ];

        try {
            $this->loginService->tryChangePassword($data);

            return response()->json([
                'status' => true,
                'message' => 'Contraseña cambiada',
            ], 200);
            
        } catch (GeneralExceptions $e) {
            
            if ($e->getCustomCode() == 401) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage()
                ], 401);
            }
            
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function username()
    {
        return 'username';
    }

    public function failLogin()
    {
        return 'No tiene los permisos para ingresar a esta url';
    }
}
