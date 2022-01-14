<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Course\CourseRepository;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    /**
     * @var CourseRepository
     */
    private $courseRepository;

    /**
     * @param CourseRepository $courseRepository
     */
    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * @OA\GET(
     *     path="/api/courses",
     *     summary="Courses",
     *     tags={"Courses"},
     *     @OA\RequestBody(
     *        required = true,
     *        description = "Courses list",
     *        @OA\JsonContent(
     *             type="object",
     *       @OA\Property(property="message", type="string", example=""),
     *       @OA\Property(property="success", type="boolean", example="true"),
     *             @OA\Property(
     *                property="payload",
     *                type="array",
     *                example={{
     *                  "id": 1,
     *                  "code": "059-209-6781",
     *                  "name": "IT",
     *                  "description": "IT",
     *                  "created_at": "2022-01-13T19:00:17.000000Z",
     *                  "updated_at": "2022-01-13T19:00:17.000000Z",
     *                }, {
     *                  "id": 1,
     *                  "code": "059-209-6781",
     *                  "name": "English",
     *                  "description": "English",
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
     *                         property="code",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="description",
     *                         type="string",
     *                         example=""
     *                      ),
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
     * return course list
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $courses = $this->courseRepository->all();
            $response = [
                'success' => true,
                'payload' => $courses,
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

    /**
     * @OA\GET(
     *     path="/api/student-courses",
     *     summary="Student Courses",
     *     tags={"Student Courses"},
     *     @OA\RequestBody(
     *        required = true,
     *        description = "Student Courses list",
     *        @OA\JsonContent(
     *             type="object",
     *       @OA\Property(property="message", type="string", example=""),
     *       @OA\Property(property="success", type="boolean", example="true"),
     *             @OA\Property(
     *                property="payload",
     *                type="array",
     *                example={{
     *                  "id": 1,
     *                  "code": "059-209-6781",
     *                  "name": "IT",
     *                  "description": "IT",
     *                  "created_at": "2022-01-13T19:00:17.000000Z",
     *                  "updated_at": "2022-01-13T19:00:17.000000Z",
     *                }, {
     *                  "id": 1,
     *                  "code": "059-209-6781",
     *                  "name": "English",
     *                  "description": "English",
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
     *                         property="code",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="description",
     *                         type="string",
     *                         example=""
     *                      ),
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
     * return student courses
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function studentCourses()
    {
        try {
            $student = auth()->user();

            $studentCourses = $student->courses;

            $response = [
                'success' => true,
                'payload' => $studentCourses,
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

    /**
     * @OA\Post(
     ** path="/courses/enroll",
     *   tags={"Enrollement"},
     *   summary="Enroll Courses",
     *   operationId="enroll",
     *   @OA\Parameter(
     *      name="course_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="int"
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
    @OA\Property(property="code", type="string",example="327-829-8548"),
    @OA\Property(property="name", type="string",example="IT"),
    @OA\Property(property="description", type="string",example="Rem quos esse est voluptates rerum"),
    @OA\Property(property="created_at", type="string",example="2022-01-13T18:16:24.000000Z"),
    @OA\Property(property="updated_at", type="string",example="2022-01-13T18:16:24.000000Z"),
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
     * enroll course
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function enrollCourse(Request $request)
    {
        $request->validate([
            'course_id' => 'required|integer'
        ]);

        try {
            $student = auth()->user();

            $course = $this->courseRepository->find($request->course_id);
            $studentCourse = $this->courseRepository->checkStudentCourse($request->course_id);

            if ($studentCourse == null) {
                $student->courses()->attach($request->course_id);

                $response = [
                    'success' => true,
                    'payload' => $course,
                    'message' => 'successfully enrolled'
                ];

                return response($response, '200');
            } else {
                $response = [
                    'success' => true,
                    'payload' => $course,
                    'message' => 'already enrolled'
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
