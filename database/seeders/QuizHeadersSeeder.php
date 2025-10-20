<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\QuizHeader;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Question;
use App\Models\Answer;
use Carbon\Carbon;

class QuizHeadersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates mock quiz data for testing purposes.
     */
    public function run(): void
    {
        // Get users - assuming these exist from your setup
        $teacher = User::where('email', 'admin@admin.com')->first();
        $student1 = User::where('email', 'user@gmail.com')->first(); // CHANGED TO user@gmail.com
        $student2 = User::where('email', 'test@test.com')->first();

        if (!$teacher || !$student1) {
            $this->command->error('Required users not found! Please ensure admin@admin.com and user@gmail.com exist.');
            return;
        }

        // Get ALL questions organized by domain
        $allQuestions = Question::where('is_active', true)
            ->with('answers')
            ->orderBy('domain_id')
            ->orderBy('id')
            ->get();

        if ($allQuestions->count() < 10) {
            $this->command->error('Not enough questions in database! Please run QuestionsSeeder first. Need at least 10 questions.');
            return;
        }

        // Organize questions into specific quiz sets (10 questions each)
        // Cycle through available questions to create multiple sets
        $questionsPerSet = 10;
        $totalQuestions = $allQuestions->count();
        
        $quizSets = [];
        for ($i = 0; $i < 10; $i++) {
            $setQuestions = collect();
            for ($j = 0; $j < $questionsPerSet; $j++) {
                $questionIndex = ($i * $questionsPerSet + $j) % $totalQuestions;
                $setQuestions->push($allQuestions[$questionIndex]);
            }
            
            // Name the sets based on their index
            if ($i < 2) {
                $setName = 'CISSP Domain 1 - Security & Risk Management (Set ' . chr(65 + $i) . ')';
            } elseif ($i < 4) {
                $setName = 'CISSP Domain 2 - Asset Security (Set ' . chr(65 + $i - 2) . ')';
            } elseif ($i < 6) {
                $setName = 'CISSP Domain 3 - Security Architecture (Set ' . chr(65 + $i - 4) . ')';
            } elseif ($i < 8) {
                $setName = 'CISSP Mixed Domains - Practice Test ' . ($i - 5);
            } else {
                $setName = 'CISSP Advanced Topics - Set ' . chr(65 + $i - 8);
            }
            
            $quizSets[$setName] = $setQuestions;
        }

        $this->command->info('Creating organized quiz headers with specific question sets...');

        // Create organized quizzes for student1 (user@gmail.com) - using specific question sets
        $quizSetNames = array_keys($quizSets);
        
        // Recent quizzes (last 24 hours)
        $this->createQuizForUser($student1, $quizSets[$quizSetNames[0]], [
            'name' => $quizSetNames[0],
            'score' => 95.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => false,
            'difficulty' => [1, 2],
            'created_at' => Carbon::now()->subHours(2),
        ]);

        $this->createQuizForUser($student1, $quizSets[$quizSetNames[1]], [
            'name' => $quizSetNames[1],
            'score' => 72.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => true,
            'difficulty' => [2, 3],
            'created_at' => Carbon::now()->subHours(6),
        ]);

        $this->createQuizForUser($student1, $quizSets[$quizSetNames[2]], [
            'name' => $quizSetNames[2],
            'score' => 88.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => false,
            'difficulty' => [1],
            'created_at' => Carbon::now()->subHours(12),
        ]);

        // This week's quizzes
        $this->createQuizForUser($student1, $quizSets[$quizSetNames[3]], [
            'name' => $quizSetNames[3],
            'score' => 85.5,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => false,
            'difficulty' => [1, 2],
            'created_at' => Carbon::now()->subDays(1),
        ]);

        $this->createQuizForUser($student1, $quizSets[$quizSetNames[4]], [
            'name' => $quizSetNames[4],
            'score' => 92.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => true,
            'difficulty' => [2, 3],
            'created_at' => Carbon::now()->subDays(2),
        ]);

        $this->createQuizForUser($student1, $quizSets[$quizSetNames[5]], [
            'name' => $quizSetNames[5],
            'score' => 65.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => false,
            'difficulty' => [3],
            'created_at' => Carbon::now()->subDays(3),
        ]);

        $this->createQuizForUser($student1, $quizSets[$quizSetNames[6]], [
            'name' => $quizSetNames[6],
            'score' => 78.5,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => false,
            'difficulty' => [1, 2, 3],
            'created_at' => Carbon::now()->subDays(4),
        ]);

        $this->createQuizForUser($student1, $quizSets[$quizSetNames[7]], [
            'name' => $quizSetNames[7],
            'score' => 91.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => true,
            'difficulty' => [2],
            'created_at' => Carbon::now()->subDays(5),
        ]);

        // Older quizzes
        $this->createQuizForUser($student1, $quizSets[$quizSetNames[8]], [
            'name' => $quizSetNames[8],
            'score' => 83.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => false,
            'difficulty' => [1, 2],
            'created_at' => Carbon::now()->subDays(7),
        ]);

        $this->createQuizForUser($student1, $quizSets[$quizSetNames[9]], [
            'name' => $quizSetNames[9],
            'score' => 76.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => true,
            'difficulty' => [2, 3],
            'created_at' => Carbon::now()->subDays(10),
        ]);

        // Repeat some quiz sets for practice
        $this->createQuizForUser($student1, $quizSets[$quizSetNames[0]], [
            'name' => $quizSetNames[0] . ' (Retake)',
            'score' => 89.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => false,
            'difficulty' => [1, 2, 3],
            'created_at' => Carbon::now()->subDays(14),
        ]);

        $this->createQuizForUser($student1, $quizSets[$quizSetNames[1]], [
            'name' => $quizSetNames[1] . ' (Retake)',
            'score' => 94.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => false,
            'difficulty' => [2, 3],
            'created_at' => Carbon::now()->subDays(20),
        ]);

        $this->createQuizForUser($student1, $quizSets[$quizSetNames[2]], [
            'name' => $quizSetNames[2] . ' (Retake)',
            'score' => 68.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => true,
            'difficulty' => [3],
            'created_at' => Carbon::now()->subDays(25),
        ]);

        $this->createQuizForUser($student1, $quizSets[$quizSetNames[3]], [
            'name' => $quizSetNames[3] . ' (Retake)',
            'score' => 87.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => false,
            'difficulty' => [1, 2],
            'created_at' => Carbon::now()->subDays(30),
        ]);

        $this->createQuizForUser($student1, $quizSets[$quizSetNames[4]], [
            'name' => $quizSetNames[4] . ' (Retake)',
            'score' => 81.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => true,
            'difficulty' => [1, 2, 3],
            'created_at' => Carbon::now()->subDays(35),
        ]);

        // Create organized quizzes for student2 if exists - 10 total quizzes
        if ($student2) {
            $this->createQuizForUser($student2, $quizSets[$quizSetNames[5]], [
                'name' => $quizSetNames[5],
                'score' => 88.0,
                'quiz_size' => 10,
                'completed' => true,
                'learningmode' => true,
                'difficulty' => [1, 2],
                'created_at' => Carbon::now()->subHours(3),
            ]);

            $this->createQuizForUser($student2, $quizSets[$quizSetNames[6]], [
                'name' => $quizSetNames[6],
                'score' => 95.5,
                'quiz_size' => 10,
                'completed' => true,
                'learningmode' => false,
                'difficulty' => [2, 3],
                'created_at' => Carbon::now()->subDays(1),
            ]);

            $this->createQuizForUser($student2, $quizSets[$quizSetNames[7]], [
                'name' => $quizSetNames[7],
                'score' => 73.0,
                'quiz_size' => 10,
                'completed' => true,
                'learningmode' => false,
                'difficulty' => [3],
                'created_at' => Carbon::now()->subDays(2),
            ]);

            $this->createQuizForUser($student2, $quizSets[$quizSetNames[8]], [
                'name' => $quizSetNames[8],
                'score' => 92.0,
                'quiz_size' => 10,
                'completed' => true,
                'learningmode' => true,
                'difficulty' => [1, 2, 3],
                'created_at' => Carbon::now()->subDays(4),
            ]);

            $this->createQuizForUser($student2, $quizSets[$quizSetNames[9]], [
                'name' => $quizSetNames[9],
                'score' => 86.0,
                'quiz_size' => 10,
                'completed' => true,
                'learningmode' => false,
                'difficulty' => [2],
                'created_at' => Carbon::now()->subDays(6),
            ]);

            $this->createQuizForUser($student2, $quizSets[$quizSetNames[0]], [
                'name' => $quizSetNames[0],
                'score' => 79.0,
                'quiz_size' => 10,
                'completed' => true,
                'learningmode' => true,
                'difficulty' => [1, 2],
                'created_at' => Carbon::now()->subDays(8),
            ]);

            $this->createQuizForUser($student2, $quizSets[$quizSetNames[1]], [
                'name' => $quizSetNames[1],
                'score' => 91.0,
                'quiz_size' => 10,
                'completed' => true,
                'learningmode' => false,
                'difficulty' => [2, 3],
                'created_at' => Carbon::now()->subDays(12),
            ]);

            $this->createQuizForUser($student2, $quizSets[$quizSetNames[2]], [
                'name' => $quizSetNames[2],
                'score' => 84.0,
                'quiz_size' => 10,
                'completed' => true,
                'learningmode' => true,
                'difficulty' => [1, 2, 3],
                'created_at' => Carbon::now()->subDays(18),
            ]);

            $this->createQuizForUser($student2, $quizSets[$quizSetNames[3]], [
                'name' => $quizSetNames[3],
                'score' => 97.0,
                'quiz_size' => 10,
                'completed' => true,
                'learningmode' => false,
                'difficulty' => [2, 3],
                'created_at' => Carbon::now()->subDays(22),
            ]);

            $this->createQuizForUser($student2, $quizSets[$quizSetNames[4]], [
                'name' => $quizSetNames[4],
                'score' => 75.0,
                'quiz_size' => 10,
                'completed' => true,
                'learningmode' => false,
                'difficulty' => [1],
                'created_at' => Carbon::now()->subDays(28),
            ]);
        }

        // Create organized quizzes for teacher (5 total quizzes)
        $this->createQuizForUser($teacher, $quizSets[$quizSetNames[6]], [
            'name' => $quizSetNames[6],
            'score' => 98.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => false,
            'difficulty' => [1, 2, 3],
            'created_at' => Carbon::now()->subDays(7),
            'is_student_created' => false,
        ]);

        $this->createQuizForUser($teacher, $quizSets[$quizSetNames[7]], [
            'name' => $quizSetNames[7],
            'score' => 96.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => false,
            'difficulty' => [2, 3],
            'created_at' => Carbon::now()->subDays(15),
            'is_student_created' => false,
        ]);

        $this->createQuizForUser($teacher, $quizSets[$quizSetNames[8]], [
            'name' => $quizSetNames[8],
            'score' => 100.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => true,
            'difficulty' => [3],
            'created_at' => Carbon::now()->subDays(21),
            'is_student_created' => false,
        ]);

        $this->createQuizForUser($teacher, $quizSets[$quizSetNames[9]], [
            'name' => $quizSetNames[9],
            'score' => 93.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => false,
            'difficulty' => [1, 2, 3],
            'created_at' => Carbon::now()->subDays(28),
            'is_student_created' => false,
        ]);

        $this->createQuizForUser($teacher, $quizSets[$quizSetNames[0]], [
            'name' => $quizSetNames[0] . ' (Teacher Review)',
            'score' => 99.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => false,
            'difficulty' => [2, 3],
            'created_at' => Carbon::now()->subDays(35),
            'is_student_created' => false,
        ]);

        // Create some approved public student quizzes (visible to all)
        $this->createQuizForUser($student1, $quizSets[$quizSetNames[5]], [
            'name' => $quizSetNames[5] . ' (Public)',
            'score' => 90.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => false,
            'difficulty' => [1, 2],
            'is_private' => false,
            'is_student_created' => true,
            'is_approved' => true,
            'approved_by' => $teacher->id,
            'approved_at' => Carbon::now()->subDays(2),
            'created_at' => Carbon::now()->subDays(4),
        ]);

        $this->createQuizForUser($student1, $quizSets[$quizSetNames[6]], [
            'name' => $quizSetNames[6] . ' (Public)',
            'score' => 85.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => true,
            'difficulty' => [2, 3],
            'is_private' => false,
            'is_student_created' => true,
            'is_approved' => true,
            'approved_by' => $teacher->id,
            'approved_at' => Carbon::now()->subDays(8),
            'created_at' => Carbon::now()->subDays(10),
        ]);

        if ($student2) {
            $this->createQuizForUser($student2, $quizSets[$quizSetNames[7]], [
                'name' => $quizSetNames[7] . ' (Public)',
                'score' => 93.0,
                'quiz_size' => 10,
                'completed' => true,
                'learningmode' => false,
                'difficulty' => [1, 2, 3],
                'is_private' => false,
                'is_student_created' => true,
                'is_approved' => true,
                'approved_by' => $teacher->id,
                'approved_at' => Carbon::now()->subDays(5),
                'created_at' => Carbon::now()->subDays(7),
            ]);
        }

        // Create a few private student quizzes (not visible to others)
        $this->createQuizForUser($student1, $quizSets[$quizSetNames[8]], [
            'name' => $quizSetNames[8] . ' (Private)',
            'score' => 82.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => true,
            'difficulty' => [2],
            'is_private' => true,
            'is_student_created' => true,
            'is_approved' => false,
            'created_at' => Carbon::now()->subDays(1),
        ]);

        $this->createQuizForUser($student1, $quizSets[$quizSetNames[9]], [
            'name' => $quizSetNames[9] . ' (Private)',
            'score' => 77.0,
            'quiz_size' => 10,
            'completed' => true,
            'learningmode' => false,
            'difficulty' => [1, 2, 3],
            'is_private' => true,
            'is_student_created' => true,
            'is_approved' => false,
            'created_at' => Carbon::now()->subDays(6),
        ]);

        $this->command->info('✅ Mock quiz headers created successfully!');
    }

    /**
     * Create a quiz header and associated quiz answers for a user
     * Now uses specific question sets instead of random selection
     */
    private function createQuizForUser($user, $questionSet, $attributes = [])
    {
        $defaults = [
            'user_id' => $user->id,
            'section_id' => 1, // Information Technology section
            'certification_id' => 1, // CISSP
            'domains' => [1], // Information and Risk Management
            'difficulty' => [1, 2],
            'learningmode' => false,
            'completed' => true,
            'quiz_size' => 10,
            'score' => 75.0,
            'is_private' => false,
            'is_student_created' => true,
            'is_approved' => false,
            'name' => 'Quiz',
        ];

        $data = array_merge($defaults, $attributes);
        
        // Use specific question set instead of random selection
        $quizQuestions = $questionSet->filter(function($q) { return $q !== null; });
        if ($quizQuestions->count() === 0) {
            $this->command->warn("  Skipping quiz - no questions in set");
            return;
        }
        
        $questionsTaken = $quizQuestions->pluck('id')->toArray();
        $data['questions_taken'] = $questionsTaken;
        $data['quiz_size'] = count($questionsTaken);

        // Create the quiz header
        $quizHeader = QuizHeader::create($data);

        // Create individual quiz answers
        $correctAnswers = 0;
        $totalQuestions = count($questionsTaken);

        foreach ($quizQuestions as $index => $question) {
            $correctAnswer = $question->answers->where('is_checked', true)->first();
            $allAnswers = $question->answers;

            if (!$correctAnswer || $allAnswers->count() === 0) {
                continue;
            }

            // Simulate answer selection based on desired score
            $targetCorrectPercentage = $data['score'] / 100;
            $shouldBeCorrect = ($index / $totalQuestions) < $targetCorrectPercentage;

            $selectedAnswer = $shouldBeCorrect 
                ? $correctAnswer 
                : $allAnswers->where('is_checked', false)->random();

            $isCorrect = $selectedAnswer->id === $correctAnswer->id;
            if ($isCorrect) {
                $correctAnswers++;
            }

            Quiz::create([
                'user_id' => $user->id,
                'quiz_header_id' => $quizHeader->id,
                'section_id' => $data['section_id'],
                'certification_id' => $data['certification_id'],
                'domain_id' => $question->domain_id,
                'question_id' => $question->id,
                'answer_id' => $selectedAnswer->id,
                'is_correct' => $isCorrect,
                'created_at' => $data['created_at'] ?? Carbon::now(),
                'updated_at' => $data['created_at'] ?? Carbon::now(),
            ]);
        }

        // Update the actual score based on answers
        $actualScore = ($correctAnswers / $totalQuestions) * 100;
        $quizHeader->update(['score' => round($actualScore, 2)]);

        $this->command->info("  Created quiz for {$user->name}: {$correctAnswers}/{$totalQuestions} correct ({$actualScore}%)");
    }
}
