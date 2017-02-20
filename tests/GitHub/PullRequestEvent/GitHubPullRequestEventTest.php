<?php

class GitHubPullRequestEventTest extends TestCase
{

    public function testPushEventWithoutCommits()
    {
        $data = json_decode(
            file_get_contents(__DIR__ . '/pull_request_event.json'), true
        );

        $server = [
            'HTTP_X-GitHub-Event' => 'pull_request',
            'HTTP_X-Hub-Signature' => 'sha1=' . hash_hmac('sha1', json_encode($data), env('GITHUB_WEBHOOK_SECRET'))
        ];

        $this->call('POST', '/events', $data, [], [], $server);

        $this->assertResponseOk();
    }


}