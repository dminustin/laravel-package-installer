<?php

declare(strict_types=1);

return [
    'models_namespace' => 'App\\Models',
    'models_path' => 'app/Models',
    'migration_path' => 'database/migrations',
    'tables' => [
        'Chat' => [
            'name' =>'chats',
            'connection'=>'mysql',
            'columns' => [
                'id' => ['uuid', 'primary'],
                'user1_id' => ['uuid'],
                'user2_id' => ['uuid'],
                'timestamps' => []
            ]
        ],
        'ChatMessage' => [
            'name' =>'chat_messages',
            'connection'=>'mysql',
            'columns' => [
                'id' => ['uuid', 'primary'],
                'chat_id' => ['uuid'],
                'sender_id' => ['uuid'],
                'message' => ['text'],
                'is_read' => ['boolean', 'default' => false],
                'timestamps' => []
            ]
        ]
    ]
];
