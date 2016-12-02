<?php

return [
    'providers' => [
        \App\Git\HookProviders\GitHubHookProvider::class,
    ],
    'events' => [
        'github' => [
            'push' => \App\Git\HookEvents\GitHub\GitHubPushEvent::class,
            'create' => \App\Git\HookEvents\GitHub\GitHubCreateEvent::class,
            'commit_comment' => \App\Git\HookEvents\GitHub\GitHubCommitCommentEvent::class,
        ]
    ]
];