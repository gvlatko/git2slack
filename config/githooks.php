<?php

return [
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
            'push:repo' => \App\Git\HookEvents\Bitbucket\BitbucketPushEvent::class
        ]
    ]
];