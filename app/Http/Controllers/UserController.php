<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use App\Services\UserService;

class UserController extends Controller
{
    private UserService $userService;
    
    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    //menampilkan
    public function login(): Response
    {
        return response()
            ->view("user.login", [
                "title" => "Login"
            ]);
    }
    //aksi atau exsen loginnya
    public function doLogin(Request $request): Response|RedirectResponse //atau nanti sukses nanti pakai reidrect
    {
        $user =  $request->input('user');
        $password = $request->input('password');

        //validasi input kosong
        if(empty($user) || empty($password)){
            return response()->view("user.login", [
                "title"=>"Login",
                "error"=>"User or password is required"
            ]);
        }

        //login berhasil
        if($this->userService->login($user, $password))
        {
            $request->session()->put("user", $user);
            return redirect("/");
        }

        //login gagal
        return response()->view("user.login", [
            "title" => "Login",
            "error" => "User or password is wrong"
        ]);

    }

    public function doLogout(Request $request): RedirectResponse
    {
        $request->session()->forget("user");
        return redirect("/");
    }
}
