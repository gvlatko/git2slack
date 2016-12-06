<?php

class GitHubPushEventTest extends TestCase
{

    public function testPushEventWithoutCommits()
    {
        $data = json_decode(
            file_get_contents(__DIR__ . '/push_event_without_commits.json'), true
        );

        $server = [
            'HTTP_X-GitHub-Event' => 'push',
            'HTTP_X-Hub-Signature' => 'sha1=' . hash_hmac('sha1', json_encode($data), env('GITHUB_WEBHOOK_SECRET'))
        ];

        $this->call('POST', '/events', $data, [], [], $server);

        $this->assertResponseOk();
    }


    public function testPushCommitWithFiveOrLessCommits()
    {
        $data = json_decode(
            file_get_contents(__DIR__ . '/push_event_with_five_or_less_commits.json'), true
        );

        $server = [
            'HTTP_X-GitHub-Event' => 'push',
            'HTTP_X-Hub-Signature' => 'sha1=' . hash_hmac('sha1', json_encode($data), env('GITHUB_WEBHOOK_SECRET'))
        ];

        $this->call('POST', '/events', $data, [], [], $server);

        $this->assertResponseOk();
    }

    public function testPushCommitWithMoreThanFiveCommits()
    {
        $data = json_decode(
            file_get_contents(__DIR__ . '/push_event_with_more_than_five_commits.json'), true
        );

        $server = [
            'HTTP_X-GitHub-Event' => 'push',
            'HTTP_X-Hub-Signature' => 'sha1=' . hash_hmac('sha1', json_encode($data), env('GITHUB_WEBHOOK_SECRET'))
        ];

        $this->call('POST', '/events', $data, [], [], $server);

        $this->assertResponseOk();
    }
}