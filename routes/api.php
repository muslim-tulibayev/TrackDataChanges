<?php

use App\Models\Change;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

Route::get('/test', function () {

    // $changes = Change::all();
    $changes = Change::with('changeable')->with('linkedable')->get();
    // $changes = Change::find(2)->changer();
    // $changes = Change::find(2)->changer->name;
    // $changes = Change::find(1)->changeable;
    // $changes = Change::find(2)->linkedable;
    return response()->json($changes);

    // $user = User::->find(1)->changes;
    // $user = User::with('changes')->find(1);
    // return response()->json($user);

    // $course = Course::find(1)->changes;
    // return response()->json($course);
});

Route::group(["middleware" => 'auth:api,student'], function () {
    Route::post('/edit_c', function () {
        $course = Course::create([
            "name" => "New Course",
            "price" => '1000$',
        ]);

        if (auth('api')->user() !== null)
            $changer = auth('api')->user();

        if (auth('student')->user() !== null)
            $changer = auth('student')->user();

        $changer->makeChange('Data updated', 'created new', $course);

        return response()->json([
            "message" => "Course created"
        ]);
    });

    Route::post('/edit_l', function () {
        Lesson::create([
            "sequence_number" => '1a',
            "name" => 'New lesson',
            "course_id" => 1,
        ]);
    });
});

Route::get('/user/login', function (Request $req) {
    $validator = Validator::make($req->all(), [
        'name' => 'required|string',
        'password' => 'required|string',
    ]);

    if ($validator->fails())
        return response()->json($validator->messages(), 422);

    $token = auth('api')->setTTL(60 * 12)->attempt($validator->validated());

    if (!$token)
        return response()->json(['error' => 'Unauthorized'], 401);

    return response(['token' => $token]);
});

Route::get('/user/register', function (Request $req) {
    $validator = Validator::make($req->all(), [
        'name' => 'required|string',
        'password' => 'required|string',
    ]);

    if ($validator->fails())
        return response()->json($validator->messages(), 400);

    $user = User::create([
        "name" => $req->name,
        "password" => $req->password,
    ]);

    $token = auth('api')->setTTL(60 * 12)->login($user);

    return response()->json([
        'message' => 'User successfully registered',
        'token' => $token
    ], 201);
});

Route::get('/student/login', function (Request $req) {
    $validator = Validator::make($req->all(), [
        'name' => 'required|string',
        'password' => 'required|string',
    ]);

    if ($validator->fails())
        return response()->json($validator->messages(), 422);

    $token = auth('student')->setTTL(60 * 12)->attempt($validator->validated());

    if (!$token)
        return response()->json(['error' => 'Unauthorized'], 401);

    return response(['token' => $token]);
});

Route::get('/student/register', function (Request $req) {
    $validator = Validator::make($req->all(), [
        'name' => 'required|string',
        'password' => 'required|string',
    ]);

    if ($validator->fails())
        return response()->json($validator->messages(), 400);

    $student = Student::create([
        "name" => $req->name,
        "password" => $req->password,
    ]);

    $token = auth('student')->setTTL(60 * 12)->login($student);

    return response()->json([
        'message' => 'Student successfully registered',
        'token' => $token
    ], 201);
});

Route::get('/login', function () {
    return response()->json(["error" => "Unauthenticated"], 401);
})->name('login');
