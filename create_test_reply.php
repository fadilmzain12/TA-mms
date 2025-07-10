<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Comment;
use App\Models\Member;
use App\Models\CommentReply;

try {
    $comment = Comment::first();
    $member = Member::first();
    
    if ($comment && $member) {
        $reply = CommentReply::create([
            'comment_id' => $comment->id,
            'member_id' => $member->id,
            'content' => 'Test reply untuk testing tombol balas - ini adalah balasan test'
        ]);
        
        // Update comment replies count
        $comment->replies_count = $comment->replies()->count();
        $comment->save();
        
        echo "Test reply created successfully!\n";
        echo "Comment ID: " . $comment->id . "\n";
        echo "Member ID: " . $member->id . "\n";
        echo "Reply ID: " . $reply->id . "\n";
    } else {
        echo "Error: Comment or Member not found\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
