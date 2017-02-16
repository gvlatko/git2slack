<?php

class BitbucketPushEventTest extends TestCase{

    public function testPushEventWithoutCommits()
    {
        $data = json_decode(
            file_get_contents(__DIR__ . '/push_event_without_commits.json'), true
        );

        $server = [
            'HTTP_X-Event-Key' => 'repo:push',
        ];

        $this->call('POST', '/events', $data, [], [], $server);

        $this->assertResponseOk();
    }

    public function testPushEventWithFiveOrLessCommits()
    {
        $data = json_decode(
            file_get_contents(__DIR__ . '/push_event_with_five_or_less_commits.json'), true
        );

        $server = [
            'HTTP_X-Event-Key' => 'repo:push'
        ];

        $this->call('POST', '/events', $data, [], [], $server);

        $this->assertResponseOk();
    }


    public function testPushEventWithFiveOrMoreCommits()
    {
        $data = json_decode(
            file_get_contents(__DIR__ . '/push_event_with_five_or_more_commits.json'), true
        );

        $server = [
            'HTTP_X-Event-Key' => 'repo:push'
        ];

        $this->call('POST', '/events', $data, [], [], $server);

        $this->assertResponseOk();
    }
}