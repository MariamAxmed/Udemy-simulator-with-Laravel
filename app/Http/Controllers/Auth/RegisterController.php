<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\MailRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use http\Env\Request;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $check = User::query()
            ->whereNotNull('email_verified_at')
            ->where('email', $request->email)
            ->exists();

        if ($check) {
            return response([
                'message' => 'Email already exists'
            ], 422);
        }

        $code = rand(1000, 9999);
        $expiredTime = time() + (60 * 10);  // 10 minutes sonrani verir
        $user = User::query()->create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => $request->password,
            'email_code' => $code,
            'email_code_expired' => $expiredTime,
        ]);
        $email = $request->email;


        $subject = 'Udemy M hesabi tesdiqleme';
        $body = "Salam, Xosh gelmisiz $user->name $user->surname, <br> hesabinizi tesdiqlemek ucun kod: $code. Kod 10 deqiqe erzinde kecerlidir.";


        //Mail gonder
        Mail::send('mail.standard', compact('body'), function ($mail) use ($subject, $email) //compact body bu demekdir: ['body' => $body]. compact php nin funksiyasidir Laravelin YOX{
        {
            $mail->to($email)->subject($subject);
        });




        return response([
            'message' => 'Istifadeci ugurla yaradildi',
            'data' => [
                'user_id' => $user->id,
            ]
        ], 201);
    }

    public function emailVerified(MailRequest $request, $user_id)
    {
        $user = User::query()
            ->whereNull('email_verified_at') // Check for unverified email
            ->where('id', $user_id)
            ->first();

        if (!$user) {
            return response([
                'message' => 'Istifadeci tapilmadi',
                'data' => [
                    'data' => null
                ]
            ], 404);
        }

        if(!$user)
            return response([
                'message' => 'Istifadechi tapilmadi!',
                'data' => [
                    'data' => null
                ]
            ], 400);

        if ($user->email_code != $request->code) {
            return response([
                'message' => 'Kod sehvdir!',
                'data' => [
                    'data' => null
                ]
            ], 400);
        }

        if ($user->email_code_expired < time()) {
            return response([
                'message' => 'Kodun vaxti bitib',
                'data' => [
                    'data' => null
                ]
            ], 400);
        }

        $user->update([
            'email_verified_at' => now(),
            'email_code' => null,
            'email_code_expired' => null
        ]);

        User::query()
            ->where('email', $user->email)
            ->where('id', '!=', $user_id)
            ->delete();


        return response([
            'message' => 'Qeydiyyat ugurla tamamlandi',
            'data' => [
                'user_id' => $user->id,
                'data' => null
            ]
        ]);
    }

}
