<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Vocabulary;
use App\Models\Quiz;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'slug'       => 'mathematical-foundations',
                'title'      => 'Mathematical Foundations',
                'description' => 'Master the core vocabulary of mathematics used in academic and research contexts.',
                'color'      => '#2563EB',
                'category'   => 'Algebra',
                'difficulty' => 'beginner',
                'total_xp'   => 500,
                'sort_order' => 1,
                'is_featured' => true,
                'lessons'    => [
                    [
                        'slug'             => 'sets-and-operations',
                        'title'            => 'Sets and Operations',
                        'description'      => 'Understanding mathematical sets and fundamental operations.',
                        'lesson_type'      => 'vocabulary',
                        'duration_minutes' => 15,
                        'xp_reward'        => 50,
                        'sort_order'       => 1,
                        'vocabularies'     => [
                            ['term' => 'Set', 'mathematical_meaning' => 'A collection of distinct objects, considered as an object in its own right.', 'pronunciation' => '/sɛt/', 'example' => 'A = {1, 2, 3}', 'translation' => 'Himpunan'],
                            ['term' => 'Union', 'mathematical_meaning' => 'The set containing all elements that are in A, B, or both.', 'pronunciation' => '/ˈjuːniən/', 'example' => 'A ∪ B', 'translation' => 'Gabungan'],
                            ['term' => 'Intersection', 'mathematical_meaning' => 'The set of elements common to all sets.', 'pronunciation' => '/ˌɪntəˈsekʃən/', 'example' => 'A ∩ B', 'translation' => 'Irisan'],
                            ['term' => 'Subset', 'mathematical_meaning' => 'A set A is a subset of B if every element of A is also in B.', 'pronunciation' => '/ˈsʌbset/', 'example' => 'A ⊆ B', 'translation' => 'Himpunan Bagian'],
                        ],
                    ],
                    [
                        'slug'             => 'sets-quiz',
                        'title'            => 'Sets Quiz',
                        'description'      => 'Test your knowledge of sets and operations.',
                        'lesson_type'      => 'quiz',
                        'duration_minutes' => 10,
                        'xp_reward'        => 80,
                        'sort_order'       => 2,
                    ],
                    [
                        'slug'             => 'functions-and-mappings',
                        'title'            => 'Functions and Mappings',
                        'description'      => 'Core concepts of mathematical functions.',
                        'lesson_type'      => 'vocabulary',
                        'duration_minutes' => 20,
                        'xp_reward'        => 60,
                        'sort_order'       => 3,
                        'vocabularies'     => [
                            ['term' => 'Function', 'mathematical_meaning' => 'A relation that uniquely associates members of one set with members of another set.', 'pronunciation' => '/ˈfʌŋkʃən/', 'example' => 'f(x) = x²', 'translation' => 'Fungsi'],
                            ['term' => 'Domain', 'mathematical_meaning' => 'The set of all possible input values of a function.', 'pronunciation' => '/ˈdoʊmeɪn/', 'example' => 'Domain of f(x) = √x is x ≥ 0', 'translation' => 'Domain'],
                            ['term' => 'Range', 'mathematical_meaning' => 'The set of all possible output values of a function.', 'pronunciation' => '/reɪndʒ/', 'example' => 'Range of f(x) = x² is y ≥ 0', 'translation' => 'Range/Kodomain'],
                        ],
                    ],
                    [
                        'slug'             => 'number-theory-basics',
                        'title'            => 'Number Theory Basics',
                        'description'      => 'Introduction to integer properties and prime numbers.',
                        'lesson_type'      => 'reading',
                        'duration_minutes' => 18,
                        'xp_reward'        => 45,
                        'sort_order'       => 4,
                    ],
                    [
                        'slug'             => 'foundations-exercise',
                        'title'            => 'Foundations Exercise',
                        'description'      => 'Practice exercises for mathematical foundations.',
                        'lesson_type'      => 'exercise',
                        'duration_minutes' => 25,
                        'xp_reward'        => 100,
                        'sort_order'       => 5,
                    ],
                ],
            ],
            [
                'slug'       => 'calculus-english',
                'title'      => 'Calculus in English',
                'description' => 'Learn how to read, write, and communicate calculus concepts in academic English.',
                'color'      => '#7C3AED',
                'category'   => 'Calculus',
                'difficulty' => 'intermediate',
                'total_xp'   => 750,
                'sort_order' => 2,
                'is_featured' => true,
                'lessons'    => [
                    [
                        'slug'             => 'limits-and-continuity',
                        'title'            => 'Limits and Continuity',
                        'description'      => 'Understanding the language of limits in calculus.',
                        'lesson_type'      => 'vocabulary',
                        'duration_minutes' => 20,
                        'xp_reward'        => 60,
                        'sort_order'       => 1,
                        'vocabularies'     => [
                            ['term' => 'Limit', 'mathematical_meaning' => 'The value that a function approaches as the input approaches some value.', 'pronunciation' => '/ˈlɪmɪt/', 'formula' => 'lim(x→a) f(x) = L', 'translation' => 'Limit'],
                            ['term' => 'Continuity', 'mathematical_meaning' => 'A function is continuous if small changes in input produce small changes in output.', 'pronunciation' => '/ˌkɒntɪˈnjuːɪti/', 'translation' => 'Kekontinuan'],
                            ['term' => 'Derivative', 'mathematical_meaning' => 'The rate at which a function changes at any given point.', 'pronunciation' => '/dɪˈrɪvətɪv/', 'formula' => "f'(x) = lim(h→0) [f(x+h)-f(x)]/h", 'translation' => 'Turunan'],
                        ],
                    ],
                    [
                        'slug'             => 'integration-vocabulary',
                        'title'            => 'Integration Vocabulary',
                        'description'      => 'Key terms for integral calculus.',
                        'lesson_type'      => 'vocabulary',
                        'duration_minutes' => 22,
                        'xp_reward'        => 65,
                        'sort_order'       => 2,
                        'vocabularies'     => [
                            ['term' => 'Integral', 'mathematical_meaning' => 'A mathematical object that can be interpreted as an area or a generalization of area.', 'pronunciation' => '/ˈɪntɪɡrəl/', 'formula' => '∫f(x)dx', 'translation' => 'Integral'],
                            ['term' => 'Antiderivative', 'mathematical_meaning' => 'A function F whose derivative is f.', 'pronunciation' => '/ˌæntɪdɪˈrɪvətɪv/', 'translation' => 'Anti-turunan'],
                        ],
                    ],
                    [
                        'slug'             => 'calculus-quiz-1',
                        'title'            => 'Calculus Quiz I',
                        'description'      => 'Assessment on limits, derivatives, and integrals.',
                        'lesson_type'      => 'quiz',
                        'duration_minutes' => 15,
                        'xp_reward'        => 100,
                        'sort_order'       => 3,
                    ],
                    [
                        'slug'             => 'series-and-sequences',
                        'title'            => 'Series and Sequences',
                        'description'      => 'Infinite series and convergence terminology.',
                        'lesson_type'      => 'vocabulary',
                        'duration_minutes' => 20,
                        'xp_reward'        => 70,
                        'sort_order'       => 4,
                    ],
                    [
                        'slug'             => 'calculus-reading',
                        'title'            => 'Reading Calculus Proofs',
                        'description'      => 'How to read and interpret formal calculus proofs in English.',
                        'lesson_type'      => 'reading',
                        'duration_minutes' => 30,
                        'xp_reward'        => 80,
                        'sort_order'       => 5,
                    ],
                    [
                        'slug'             => 'calculus-exercise',
                        'title'            => 'Calculus Exercise',
                        'description'      => 'Practice writing and explaining calculus in English.',
                        'lesson_type'      => 'exercise',
                        'duration_minutes' => 35,
                        'xp_reward'        => 120,
                        'sort_order'       => 6,
                    ],
                ],
            ],
            [
                'slug'       => 'linear-algebra-vocabulary',
                'title'      => 'Linear Algebra Vocabulary',
                'description' => 'Comprehensive vocabulary for vectors, matrices, and linear transformations in academic English.',
                'color'      => '#059669',
                'category'   => 'Linear Algebra',
                'difficulty' => 'intermediate',
                'total_xp'   => 700,
                'sort_order' => 3,
                'lessons'    => [
                    [
                        'slug'             => 'vectors-and-spaces',
                        'title'            => 'Vectors and Vector Spaces',
                        'description'      => 'Core vector terminology.',
                        'lesson_type'      => 'vocabulary',
                        'duration_minutes' => 20,
                        'xp_reward'        => 55,
                        'sort_order'       => 1,
                        'vocabularies'     => [
                            ['term' => 'Vector', 'mathematical_meaning' => 'A quantity having direction as well as magnitude.', 'pronunciation' => '/ˈvektər/', 'formula' => 'v = (v₁, v₂, ..., vₙ)', 'translation' => 'Vektor'],
                            ['term' => 'Matrix', 'mathematical_meaning' => 'A rectangular array of numbers, symbols, or expressions arranged in rows and columns.', 'pronunciation' => '/ˈmeɪtrɪks/', 'translation' => 'Matriks'],
                            ['term' => 'Eigenvalue', 'mathematical_meaning' => 'A scalar λ such that Av = λv for some non-zero vector v.', 'pronunciation' => '/ˈaɪɡənˌvæljuː/', 'formula' => 'det(A - λI) = 0', 'translation' => 'Nilai Eigen'],
                        ],
                    ],
                    [
                        'slug'             => 'matrix-operations',
                        'title'            => 'Matrix Operations',
                        'description'      => 'Vocabulary for matrix manipulation.',
                        'lesson_type'      => 'vocabulary',
                        'duration_minutes' => 18,
                        'xp_reward'        => 50,
                        'sort_order'       => 2,
                    ],
                    [
                        'slug'             => 'linear-algebra-quiz',
                        'title'            => 'Linear Algebra Quiz',
                        'description'      => 'Test your linear algebra vocabulary.',
                        'lesson_type'      => 'quiz',
                        'duration_minutes' => 12,
                        'xp_reward'        => 90,
                        'sort_order'       => 3,
                    ],
                    [
                        'slug'             => 'transformations-reading',
                        'title'            => 'Linear Transformations',
                        'description'      => 'Reading about linear maps and transformations.',
                        'lesson_type'      => 'reading',
                        'duration_minutes' => 25,
                        'xp_reward'        => 65,
                        'sort_order'       => 4,
                    ],
                ],
            ],
            [
                'slug'       => 'statistics-research-english',
                'title'      => 'Statistics for Research',
                'description' => 'English vocabulary for statistical analysis used in academic papers and research presentations.',
                'color'      => '#DC2626',
                'category'   => 'Statistics',
                'difficulty' => 'advanced',
                'total_xp'   => 900,
                'sort_order' => 4,
                'lessons'    => [
                    [
                        'slug'             => 'descriptive-statistics',
                        'title'            => 'Descriptive Statistics',
                        'description'      => 'Terms for summarizing and describing data.',
                        'lesson_type'      => 'vocabulary',
                        'duration_minutes' => 22,
                        'xp_reward'        => 70,
                        'sort_order'       => 1,
                        'vocabularies'     => [
                            ['term' => 'Mean', 'mathematical_meaning' => 'The sum of all values divided by the number of values.', 'pronunciation' => '/miːn/', 'formula' => 'μ = Σx/n', 'translation' => 'Rata-rata'],
                            ['term' => 'Variance', 'mathematical_meaning' => 'The expectation of the squared deviation from the mean.', 'pronunciation' => '/ˈveəriəns/', 'formula' => 'σ² = Σ(x-μ)²/n', 'translation' => 'Variansi'],
                            ['term' => 'Standard Deviation', 'mathematical_meaning' => 'A measure of the amount of variation or dispersion of a set of values.', 'pronunciation' => '/ˈstændərd ˌdiːviˈeɪʃən/', 'formula' => 'σ = √(Σ(x-μ)²/n)', 'translation' => 'Simpangan Baku'],
                        ],
                    ],
                    [
                        'slug'             => 'hypothesis-testing',
                        'title'            => 'Hypothesis Testing',
                        'description'      => 'Language for statistical hypothesis tests.',
                        'lesson_type'      => 'vocabulary',
                        'duration_minutes' => 25,
                        'xp_reward'        => 75,
                        'sort_order'       => 2,
                    ],
                    [
                        'slug'             => 'regression-vocabulary',
                        'title'            => 'Regression Analysis',
                        'description'      => 'Key terms for regression and correlation.',
                        'lesson_type'      => 'vocabulary',
                        'duration_minutes' => 20,
                        'xp_reward'        => 65,
                        'sort_order'       => 3,
                    ],
                    [
                        'slug'             => 'stats-quiz-1',
                        'title'            => 'Statistics Quiz I',
                        'description'      => 'Assessment on descriptive and inferential statistics.',
                        'lesson_type'      => 'quiz',
                        'duration_minutes' => 20,
                        'xp_reward'        => 120,
                        'sort_order'       => 4,
                    ],
                    [
                        'slug'             => 'writing-results-section',
                        'title'            => 'Writing a Results Section',
                        'description'      => 'How to write statistical results in academic English.',
                        'lesson_type'      => 'exercise',
                        'duration_minutes' => 40,
                        'xp_reward'        => 150,
                        'sort_order'       => 5,
                    ],
                ],
            ],
            [
                'slug'       => 'discrete-mathematics',
                'title'      => 'Discrete Mathematics',
                'description' => 'English vocabulary for combinatorics, graph theory, and logic used in computer science and math research.',
                'color'      => '#0891B2',
                'category'   => 'Discrete Math',
                'difficulty' => 'beginner',
                'total_xp'   => 600,
                'sort_order' => 5,
                'lessons'    => [
                    [
                        'slug'             => 'logic-and-proofs',
                        'title'            => 'Logic and Proofs',
                        'description'      => 'Language of mathematical logic and proof writing.',
                        'lesson_type'      => 'vocabulary',
                        'duration_minutes' => 18,
                        'xp_reward'        => 55,
                        'sort_order'       => 1,
                        'vocabularies'     => [
                            ['term' => 'Proposition', 'mathematical_meaning' => 'A statement that is either true or false.', 'pronunciation' => '/ˌprɒpəˈzɪʃən/', 'translation' => 'Proposisi'],
                            ['term' => 'Conjunction', 'mathematical_meaning' => 'A compound statement formed by combining two statements with AND.', 'pronunciation' => '/kənˈdʒʌŋkʃən/', 'formula' => 'p ∧ q', 'translation' => 'Konjungsi'],
                            ['term' => 'Disjunction', 'mathematical_meaning' => 'A compound statement formed by combining two statements with OR.', 'pronunciation' => '/dɪsˈdʒʌŋkʃən/', 'formula' => 'p ∨ q', 'translation' => 'Disjungsi'],
                        ],
                    ],
                    [
                        'slug'             => 'combinatorics-basics',
                        'title'            => 'Combinatorics Basics',
                        'description'      => 'Permutations, combinations, and counting principles.',
                        'lesson_type'      => 'vocabulary',
                        'duration_minutes' => 20,
                        'xp_reward'        => 60,
                        'sort_order'       => 2,
                    ],
                    [
                        'slug'             => 'graph-theory-intro',
                        'title'            => 'Graph Theory Introduction',
                        'description'      => 'Fundamental vocabulary for graph theory.',
                        'lesson_type'      => 'vocabulary',
                        'duration_minutes' => 20,
                        'xp_reward'        => 60,
                        'sort_order'       => 3,
                    ],
                    [
                        'slug'             => 'discrete-quiz',
                        'title'            => 'Discrete Math Quiz',
                        'description'      => 'Test your discrete mathematics vocabulary.',
                        'lesson_type'      => 'quiz',
                        'duration_minutes' => 15,
                        'xp_reward'        => 100,
                        'sort_order'       => 4,
                    ],
                ],
            ],
            [
                'slug'       => 'academic-writing-math',
                'title'      => 'Academic Writing in Mathematics',
                'description' => 'Master the conventions of writing mathematical papers, proofs, and research reports in English.',
                'color'      => '#D97706',
                'category'   => 'Academic Writing',
                'difficulty' => 'advanced',
                'total_xp'   => 1000,
                'sort_order' => 6,
                'lessons'    => [
                    [
                        'slug'             => 'proof-writing-language',
                        'title'            => 'Language of Proof Writing',
                        'description'      => 'Phrases and connectives used in mathematical proofs.',
                        'lesson_type'      => 'vocabulary',
                        'duration_minutes' => 25,
                        'xp_reward'        => 80,
                        'sort_order'       => 1,
                        'vocabularies'     => [
                            ['term' => 'Theorem', 'mathematical_meaning' => 'A statement that has been proved on the basis of previously established statements.', 'pronunciation' => '/ˈθɪərəm/', 'translation' => 'Teorema'],
                            ['term' => 'Lemma', 'mathematical_meaning' => 'A subsidiary result proved for use in the proof of a main theorem.', 'pronunciation' => '/ˈlemə/', 'translation' => 'Lemma'],
                            ['term' => 'Corollary', 'mathematical_meaning' => 'A result that follows with little or no proof from a theorem.', 'pronunciation' => '/ˈkɒrəleri/', 'translation' => 'Akibat Wajar'],
                            ['term' => 'Conjecture', 'mathematical_meaning' => 'A conclusion or proposition based on incomplete information.', 'pronunciation' => '/kənˈdʒektʃər/', 'translation' => 'Konjektur'],
                        ],
                    ],
                    [
                        'slug'             => 'abstract-introduction',
                        'title'            => 'Writing an Abstract',
                        'description'      => 'Structure and language for mathematical paper abstracts.',
                        'lesson_type'      => 'reading',
                        'duration_minutes' => 30,
                        'xp_reward'        => 85,
                        'sort_order'       => 2,
                    ],
                    [
                        'slug'             => 'academic-writing-quiz',
                        'title'            => 'Academic Writing Quiz',
                        'description'      => 'Test your academic writing vocabulary.',
                        'lesson_type'      => 'quiz',
                        'duration_minutes' => 20,
                        'xp_reward'        => 130,
                        'sort_order'       => 3,
                    ],
                    [
                        'slug'             => 'proof-exercise',
                        'title'            => 'Proof Writing Exercise',
                        'description'      => 'Write your first proof in English.',
                        'lesson_type'      => 'exercise',
                        'duration_minutes' => 45,
                        'xp_reward'        => 200,
                        'sort_order'       => 4,
                    ],
                ],
            ],
        ];

        foreach ($courses as $courseData) {
            $lessonsData = $courseData['lessons'] ?? [];
            unset($courseData['lessons']);

            $lessonCount = count($lessonsData);
            $courseData['total_lessons'] = $lessonCount;
            $courseData['is_active'] = true;

            $course = Course::updateOrCreate(
                ['slug' => $courseData['slug']],
                $courseData
            );

            foreach ($lessonsData as $lessonData) {
                $vocabulariesData = $lessonData['vocabularies'] ?? [];
                unset($lessonData['vocabularies']);

                $lessonData['course_id'] = $course->id;
                $lessonData['is_active'] = true;

                $lesson = Lesson::updateOrCreate(
                    ['slug' => $lessonData['slug']],
                    $lessonData
                );

                foreach ($vocabulariesData as $vocabData) {
                    $vocabData['lesson_id'] = $lesson->id;
                    $vocabData['difficulty'] = $course->difficulty;

                    Vocabulary::updateOrCreate(
                        ['lesson_id' => $lesson->id, 'term' => $vocabData['term']],
                        $vocabData
                    );
                }
            }

            // Recalculate estimated_minutes from lessons
            $totalMinutes = $course->lessons()->sum('duration_minutes');
            $course->update(['estimated_minutes' => $totalMinutes]);
        }
    }
}