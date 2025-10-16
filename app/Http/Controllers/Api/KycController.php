<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Utils\ErrorCode;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class KycController extends Controller
{
    // Mock questions pool
    private $questions = [
        [
            'id' => 101,
            'en' => "Mention your mother's middlename",
            'sw' => 'Taja jina la kati la mama'
        ],
        [
            'id' => 102,
            'en' => "What is your place of birth?",
            'sw' => 'Ulizaliwa wapi?'
        ],
        [
            'id' => 103,
            'en' => "What is your father's first name?",
            'sw' => 'Jina la kwanza la baba yako ni nani?'
        ],
        [
            'id' => 104,
            'en' => "Which district were you born?",
            'sw' => 'Ulizaliwa wilaya gani?'
        ],
        [
            'id' => 105,
            'en' => "What is your residential area?",
            'sw' => 'Unaishi eneo gani?'
        ]
    ];

    // Mock user data
    private $mockUserData = [
        'fname' => 'John',
        'lname' => 'Doe',
        'mname' => 'Michael',
        'phone' => '255712345678',
        'email' => 'johndoe@example.com',
        'dob' => '1997-12-04',
        'gender' => 'Male',
        'nationality' => 'Tanzanian',
        'residential_area' => 'Kinondoni',
        'district' => 'Kinondoni',
        'region' => 'Dar es Salaam',
        'image' => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBQYFBAYGBQYHBwYIChAKCgkJChQODwwQFxQYGBcUFhYaHSUfGhsjHBYWICwgIyYnKSopGR8tMC0oMCUoKSj/2wBDAQcHBwoIChMKChMoGhYaKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCj/wAARCAAyADIDASIAAhEBAxEB/8QAGwAAAgMBAQEAAAAAAAAAAAAABAUCAwYBAAf/xAA0EAACAQMDAgQEBAYDAAAAAAABAgMABBEFEiExQQYTUWEicYGRFDKhsQcjQsHR8BVS4f/EABkBAAMBAQEAAAAAAAAAAAAAAAECAwAEBf/EACQRAAICAgICAgIDAAAAAAAAAAABAhEDIRIxBEETUTJhIiOR/9oADAMBAAIRAxEAPwD2k+M5bBhFdQpcWzncVeOR7DsVbBB9xmvW1hf3V5uNj5dvIvWWGaJkiJ/l5NgeYAPpXLS/w9sLy4a50u9ubKfJ2xpNkE/fFXPo/iKwJjsNduriMf0X8JKfuorGk6MlR21lNFFI0d/aeYqlhGy3UbFj7AqST8qZxaLqttCqX9zY2dsOVhstO86Un/u7Mv6VDQPEV5pdyyXemwX1qW2tNZXBLKfTad34ipavdNe+MtMj1CxNle2sZiaJnG5D5jKOvQgD6VJxktyNM6t7rHh24k0OfVrG8tJwEtL61hMNygACgtH8LEcDI5FbPSdW0/VrT8Xp11DdW3byk5X5g9D7iuctPEuiX1xdQWl9ZXN3aZ+KGUMo3HBbB6ZqD8fIla2dXBo3AqaJUyKt4ADRR6DpmqSPqBnaCJYPy7pfM3Y7Y4xXri80PWhFYzJcWc7gIl7Ywx+SzH+WW9sckdR06V7wk9lZ6xdzeEru0t5LkK7K0u1pQRuITH5sZHfrW0AaMKDXjFfJY47KS6jsPDLxx+VuZ7t7fCpGhOFQj4i7BjgjrRX4TxZb3d7cz6tc6laXcJjEdt5ELxMpzhm+HcMqASoGOlFxaBQ/wBUl8VWIF1o+m6Rrttv2eXcyGCXrnYcdOOhPpVt/wCLrHTdLl1DVNPuoIYsERW1uZHc+21ATQd5f+MdP03SLoWun6pHf2y3BmsJxDJsDqVby5AVOSCAQw4Irua9/EzR7rQrvStPQXep30bQx2xdUQMw2793UgHAHvQpjAr8H/iZpPj3Tp5dJubYyQkfFO7KnK5wCPXNNb7W7TTrJpbhgjuQsKEcknoKzfg/wHp/hnUYtQkup7jUYYGt454iojjV+oHXJAznjNVeJfD9/c6lPqOjajcaZqTKN8lt8ayLjAdCfS+o7GiCO/R/FGhX78W8gY/0huf0NS/5pNTtVbTLu0vFI+FCwLf+Sf1rD6Z4QutUs43upXa3cgmAncnmk9cjr3q0eBjpAWS0mUQv1Ywkt+VWkIfQPwfrAP8AzmlS26+sbv8A3Ar3+5XY/wAZhvU+KME/eqG8Oajq8pnvr4WsMpJa0tyAin2BqukA//Z'
    ];

    /**
     * Initialize KYC verification with NIN
     */
    public function initiateKyc(Request $request)
    {
        try {
            $request->validate([
                'NIN' => 'required|string'
            ]);

            $nin = $request->NIN;

            // Create a session ID for this KYC process
            $sessionId = 'kyc_' . uniqid();

            // Select first question randomly
            $firstQuestion = $this->questions[array_rand($this->questions)];

            // Store session data in roles table (using name field for session_id and guard_name for data)
            $sessionData = [
                'nin' => $nin,
                'questions_asked' => [$firstQuestion['id']],
                'answers_correct' => 0,
                'current_question' => 1
            ];

            Role::create([
                'name' => $sessionId,
                'guard_name' => json_encode($sessionData)
            ]);

            Log::info('KYC Session Created', ['session_id' => $sessionId]);

            return response()->json([
                'status' => 'success',
                'CODE' => '120',
                'NIN' => $nin,
                'RQCode' => $firstQuestion['id'],
                'EN' => $firstQuestion['en'],
                'SW' => $firstQuestion['sw'],
                'session_id' => $sessionId,
                'question_number' => 1
            ]);

        } catch (ValidationException $e) {
            $firstError = collect($e->errors())->flatten()->first();
            return responder()->error(ErrorCode::VALIDATION_FAILED, $firstError, $e->errors(), 422);
        } catch (\Exception $e) {
            Log::error('KYC Initiate Error: ' . $e->getMessage());
            return responder()->error(ErrorCode::CREATE_FAILED, 'Failed to initiate KYC', null, 500);
        }
    }

    /**
     * Answer KYC question
     */
    public function answerQuestion(Request $request)
    {
        try {
            $request->validate([
                'session_id' => 'required|string',
                'question_id' => 'required|integer',
                'answer' => 'required|string'
            ]);

            $sessionId = $request->session_id;

            // Get session from roles table
            $sessionRecord = Role::where('name', $sessionId)->first();

            if (!$sessionRecord) {
                Log::warning('KYC Session Not Found: ' . $sessionId);
                return response()->json([
                    'status' => 'error',
                    'CODE' => '400',
                    'message' => 'Invalid or expired session. Please restart KYC verification.'
                ], 400);
            }

            $sessionData = json_decode($sessionRecord->guard_name, true);
            Log::info('KYC Session Found', ['session_id' => $sessionId, 'data' => $sessionData]);

            // Mock: Accept any answer as correct
            $sessionData['answers_correct']++;
            $sessionData['current_question']++;

            // Check if we've asked 3 questions
            if ($sessionData['current_question'] > 3) {
                // Verification complete - return user data and delete session
                $sessionRecord->delete();                return response()->json([
                    'status' => 'success',
                    'CODE' => '200',
                    'message' => 'KYC verification completed successfully',
                    'data' => $this->mockUserData
                ]);
            }

            // Ask next question
            $availableQuestions = array_filter($this->questions, function($q) use ($sessionData) {
                return !in_array($q['id'], $sessionData['questions_asked']);
            });

            $nextQuestion = $availableQuestions[array_rand($availableQuestions)];
            $sessionData['questions_asked'][] = $nextQuestion['id'];

            // Update session in roles table
            $sessionRecord->update([
                'guard_name' => json_encode($sessionData)
            ]);

            return response()->json([
                'status' => 'success',
                'CODE' => '120',
                'message' => 'Answer accepted',
                'RQCode' => $nextQuestion['id'],
                'EN' => $nextQuestion['en'],
                'SW' => $nextQuestion['sw'],
                'question_number' => $sessionData['current_question']
            ]);

        } catch (ValidationException $e) {
            $firstError = collect($e->errors())->flatten()->first();
            return responder()->error(ErrorCode::VALIDATION_FAILED, $firstError, $e->errors(), 422);
        } catch (\Exception $e) {
            Log::error('KYC Answer Error: ' . $e->getMessage());
            return responder()->error(ErrorCode::UPDATE_FAILED, 'Failed to process answer', null, 500);
        }
    }
}
