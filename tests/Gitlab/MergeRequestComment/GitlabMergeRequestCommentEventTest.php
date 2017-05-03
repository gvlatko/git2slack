<?php

class GitlabMergeRequestCommentEventTest extends TestCase
{

    public function testMergeRequestCommentCreated()
    {
        $data = json_decode(
            file_get_contents(__DIR__ . '/merge_request_comment.json'), true
        );

        $server = [
            'HTTP_X-Gitlab-Event' => 'Note Hook'
        ];

        $this->call('POST', '/events', $data, [], [], $server);

        $this->assertResponseOk();
    }


}