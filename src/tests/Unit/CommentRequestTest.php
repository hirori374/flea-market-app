<?php

namespace Tests\Unit;

use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CommentRequestTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testValidDataPasses()
    {
        $request = new CommentRequest();

        $data = [
            'item_id' => '1',
            'user_id' => '1',
            'content' => 'testComment',
        ];

        $validator = Validator::make(
            $data,
            $request->rules(),
            $request->messages()
        );

        $this->assertFalse($validator->fails());
    }
    public function testContentIsRequired()
    {
        $request = new CommentRequest();

        $data = [
            'item_id' => '1',
            'user_id' => '1',
            'content' => '',
        ];

        $validator = Validator::make(
            $data,
            $request->rules(),
            $request->messages()
        );

        $this->assertTrue($validator->fails());
        $this->assertEquals(
            ['コメントを入力してください'],
            $validator->errors()->get('content')
        );
    }
    public function testContentIsMax()
    {
        $request = new CommentRequest();

        $data = [
            'item_id' => '1',
            'user_id' => '1',
            'content' => 'testCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestCommentTestComment',
        ];

        $validator = Validator::make(
            $data,
            $request->rules(),
            $request->messages()
        );

        $this->assertTrue($validator->fails());
        $this->assertEquals(
            ['コメントは255文字以内で入力してください'],
            $validator->errors()->get('content')
        );
    }
}
