<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Notifications\SendWelcomeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     ** path="/api/register",
     *   tags={"Register"},
     *   summary="Student Register",
     *   operationId="register",
     *   @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *         @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="successfully register"),
     *      @OA\Property(property="success", type="boolean", example="true"),
     *      @OA\Property(property="payload", type="object",
    format="query",
    @OA\Property(property="id", type="int",example="1" ),
    @OA\Property(property="name", type="string",example="chiran"),
    @OA\Property(property="email", type="string",example="chiran1@gmail.com"),
    @OA\Property(property="created_at", type="string",example="2022-01-13T18:16:24.000000Z"),
    @OA\Property(property="updated_at", type="string",example="2022-01-13T18:16:24.000000Z"),
    @OA\Property(property="token", type="string",example="12|wA5KIi8F8e6BBdW79NWw1iPXJ3Xy4YeaArlc84r7"),
     *     ),
     *    ),
     *
     *      ),
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *)
     **/


    /**
     * Register student
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|string'
        ]);

        try {
            $student = Student::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $token = $student->createToken('apiAppToken')->plainTextToken;

            $response = [
                'student' => $student,
                'token' => $token
            ];

            // send welcome email
            Notification::send($student, new SendWelcomeEmail());

            return response($response, 200);

        } catch (\Throwable $th) {
            return response(['message' => $th->getMessage()]);
        }

    }


    /**
     * student log out
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response(['message' => 'logged out successfully']);
    }


    /**
     * @OA\Post(
     ** path="/api/login",
     *   tags={"Login"},
     *   summary="Login",
     *   operationId="login",
     *
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *         @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="successfully login"),
     *      @OA\Property(property="success", type="boolean", example="true"),
     *      @OA\Property(property="payload", type="object",
    format="query",
    @OA\Property(property="id", type="int",example="1" ),
    @OA\Property(property="name", type="string",example="chiran"),
    @OA\Property(property="email", type="string",example="chiran1@gmail.com"),
    @OA\Property(property="email_verified_at", type="string",example="null"),
    @OA\Property(property="status", type="int",example="1"),
    @OA\Property(property="created_at", type="string",example="2022-01-13T18:16:24.000000Z"),
    @OA\Property(property="updated_at", type="string",example="2022-01-13T18:16:24.000000Z"),
    @OA\Property(property="token", type="string",example="12|wA5KIi8F8e6BBdW79NWw1iPXJ3Xy4YeaArlc84r7"),
     *     ),
     *    ),
     *
     *      ),
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     * @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     * @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    /**
     * login registered student
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|string'
        ]);

        try {
            $student = Student::where('email', $data['email'])->first();

            if (!$student || !Hash::check($data['password'], $student->password)) {
                $response = [
                    'success' => false,
                    'payload' => [],
                    'message' => 'Invalid credentials'
                ];
                return response($response, 422);
            } else {
                $token = $student->createToken('apiAppToken')->plainTextToken;
                $student->token = $token;
                $response = [
                    'success' => true,
                    'payload' => $student,
                    'message' => 'successfully login'
                ];

                return response($response, 200);
            }
        } catch (\Throwable $th) {
            $response = [
                'success' => false,
                'payload' => [],
                'message' => $th->getMessage()
            ];
            return response($response, 422);
        }

    }
}
