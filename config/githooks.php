<?php

return [
    'slack' => [
        'webhook_url' => 'https://hooks.slack.com/services/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'
    ],
    'commits' => [
        'limit' => 5
    ],
    'providers' => [
        \App\Git\HookProviders\GitHubHookProvider::class,
        \App\Git\HookProviders\BitbucketHookProvider::class,
        \App\Git\HookProviders\GitlabHookProvider::class
    ],
    'events' => [
        'github' => [
//            'push' => \App\Git\HookEvents\GitHub\GitHubPushEvent::class,
//            'create' => \App\Git\HookEvents\GitHub\GitHubCreateEvent::class,
//            'commit_comment' => \App\Git\HookEvents\GitHub\GitHubCommitCommentEvent::class,
            'pull_request' => \App\Git\HookEvents\GitHub\GitHubPullRequestEvent::class
        ],
        'bitbucket' => [
//            'repo:push' => \App\Git\HookEvents\Bitbucket\BitbucketPushEvent::class
            'pullrequest:created' => \App\Git\HookEvents\Bitbucket\BitbucketPullRequestEvent::class,
            'pullrequest:updated' => \App\Git\HookEvents\Bitbucket\BitbucketPullRequestEvent::class,
            'pullrequest:fulfilled' => \App\Git\HookEvents\Bitbucket\BitbucketPullRequestEvent::class,
            'pullrequest:rejected' => \App\Git\HookEvents\Bitbucket\BitbucketPullRequestEvent::class
        ],
        'gitlab' => [
//            'Push Hook' => \App\Git\HookEvents\Gitlab\GitlabPushEvent::class
            'Merge Request Hook' => \App\Git\HookEvents\Gitlab\GitlabPullRequestEvent::class
        ]
    ]
];