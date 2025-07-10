// Debug helpers for MMS system
console.log('Debug helpers loaded');

// Function to debug reply button functionality
function debugReplyButtons() {
    const replyButtons = document.querySelectorAll('.reply-btn');
    console.log(`Found ${replyButtons.length} reply buttons`);
    
    replyButtons.forEach((button, index) => {
        const commentId = button.getAttribute('data-comment-id');
        const replyForm = document.getElementById(`reply-form-${commentId}`);
        console.log(`Reply button ${index}: comment-id=${commentId}, form exists=${!!replyForm}`);
    });
}

// Function to debug comment structure
function debugComments() {
    const comments = document.querySelectorAll('.comment-item');
    console.log(`Found ${comments.length} comments`);
    
    comments.forEach((comment, index) => {
        const commentId = comment.id;
        const replyForm = comment.querySelector('.reply-form');
        const replies = comment.querySelectorAll('.reply-item');
        console.log(`Comment ${index}: id=${commentId}, has reply form=${!!replyForm}, replies count=${replies.length}`);
    });
}

// Auto-run debug functions when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        debugReplyButtons();
        debugComments();
    }, 1000);
});