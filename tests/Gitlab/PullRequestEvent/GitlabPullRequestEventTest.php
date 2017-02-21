<?php

class GitlabPullRequestEventTest extends TestCase
{

    public function testPushEventWithoutCommits()
    {
        $data = json_decode(
            file_get_contents(__DIR__ . '/pull_request_event.json'), true
        );

        $server = [
            'HTTP_X-Gitlab-Event' => 'Merge Request Hook'
        ];

        $this->call('POST', '/events', $data, [], [], $server);

        $this->assertResponseOk();
    }


}