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
    ],
    'events' => [
        'github' => [
            'push' => \App\Git\HookEvents\GitHub\GitHubPushEvent::class,
            'create' => \App\Git\HookEvents\GitHub\GitHubCreateEvent::class,
            'commit_comment' => \App\Git\HookEvents\GitHub\GitHubCommitCommentEvent::class,
        ],
        'bitbucket' => [
            'repo:push' => \App\Git\HookEvents\Bitbucket\BitbucketPushEvent::class
        ]
    ]
];