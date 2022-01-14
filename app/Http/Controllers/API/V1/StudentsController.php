<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Student\StudentRepository;

class StudentsController extends Controller
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * @param StudentRepository $studentRepository
     */
    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * @OA\GET(
     *     path="/api/students",
     *     summary="Students",
     *     tags={"Students"},
     *     @OA\RequestBody(
     *        required = true,
     *        description = "Students list",
     *        @OA\JsonContent(
     *             type="object",
     *       @OA\Property(property="message", type="string", example=""),
     *       @OA\Property(property="success", type="boolean", example="true"),
     *             @OA\Property(
     *                property="payload",
     *                type="array",
     *                example={{
     *                  "id": 1,
     *                  "name": "chiran",
     *                  "email": "chiran@gmail.com",
     *                  "email_verified_at": "null",
     *                  "status": "1",
     *                  "created_at": "2022-01-13T19:00:17.000000Z",
     *                  "updated_at": "2022-01-13T19:00:17.000000Z",
     *                }, {
     *                 "id": 1,
     *                  "name": "chiran2",
     *                  "email": "chiran2@gmail.com",
     *                  "email_verified_at": "null",
     *                  "status": "1",
     *                  "created_at": "2022-01-13T19:00:17.000000Z",
     *                  "updated_at": "2022-01-13T19:00:17.000000Z",
     *                }},
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="id",
     *                         type="int",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="status",
     *                         type="int",
     *                         example=""
     *                      ),
     *          @OA\Property(
     *                         property="email_verified_at",
     *                         type="string",
     *                         example=""
     *                      ),
     *
     *                      @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example=""
     *                      ),
     *       @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example=""
     *                      ),
     *                ),
     *             ),
     *        ),
     *     ),
     *
     *
     *     @OA\Response(
     *        response="200",
     *        description="Successful response",
     *     ),
     * )
     */


    /**
     * return student list
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $students = $this->studentRepository->all();

            $response = [
                'success' => true,
                'payload' => $students,
                'message' => ''
            ];
            return response($response, 200);

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
