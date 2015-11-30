<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class QuestionTest extends TestCase
{
    use DatabaseMigrations;

    public function test_users_can_create_questions()
    {
        $user = factory(Quest\User::class)->create();

        $this->actingAs($user)
            ->visit('/new')
            ->submitForm('New Poll', [
                'question_text' => 'My Question',
                'choices' => ['first choice', 'second choice']
            ])
            ->see('My Question')
            ->see('first choice')
            ->see('second choice')
            ->seeInDatabase('questions', ['question_text' => 'My Question'])
            ->seeInDatabase('choices', ['choice_text' => 'first choice',
                                        'choice_text' => 'second choice'
                                        ]);
    }

    public function test_users_can_vote_on_a_poll()
    {
        $user = factory(Quest\User::class)->create();
        $question = factory(Quest\Question::class)->create();
        $choiceY = factory(Quest\Choice::class, 'yes')->create();
        $choiceN = factory(Quest\Choice::class, 'no')->create();

        $this->visit('/')
            ->select('Yes', $question->slug)
            ->press('Vote')
            ->see('You have voted successfully.')
            ->seeInDatabase('choices', ['votes' => 1]);
    }
}
