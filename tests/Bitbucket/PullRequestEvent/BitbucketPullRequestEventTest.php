<?php

class BitbucketPullRequestEventTest extends TestCase
{

    public function testPushEventWithoutCommits()
    {
        $data = json_decode(
            file_get_contents(__DIR__ . '/pull_request_event.json'), true
        );

        $server = [
            'HTTP_X-Event-Key' => 'pullrequest:created',
        ];

        $this->call('POST', '/events', $data, [], [], $server);

        $this->assertResponseOk();
    }


}