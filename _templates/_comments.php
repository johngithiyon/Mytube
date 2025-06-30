<?php
session_start();
$user = $_SESSION['user'];

$comment_data = User::fetch_comment($_SESSION['videoid'])
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Comments</title>
	<link rel="stylesheet" href="assests/css/comment.css">
</head>

<body>

	<div class="chat-container">
		<div class="chat-header">Comments</div>

		<div class="chat-messages" id="chat-box">
		</div>

		 <!-- Comments Display Section -->
		 <div class="chat-messages" id="chat-box">
      <?php foreach ($comment_data as $comment): ?>
        <div class="comment-item">
          <strong><?php echo htmlspecialchars($comment['user']); ?>:</strong>
          <p><?php echo htmlspecialchars($comment['comment']); ?></p>
          <small><?php echo htmlspecialchars($comment['created_at']); ?></small>
        </div>
      <?php endforeach; ?>
    </div>
	

		<form class="chat-input">
			<textarea id="comment" placeholder="Type your message..." required></textarea>
			<button type="button" onclick="sendcomment()">Send</button>
		</form>
	</div>
	<script>
		function sendcomment() {

			const comments = document.getElementById('comment').value;

			fetch("com.php", {
					method: "POST",
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify({
						user:"<?php echo $user?>",
						comment: comments
					})
				})
				.then(response => response.json())
				.then(data => {
					console.log("from comment.php response from server",data)
					if (data.status === "success") {
						alert("Your comment was submitted successfully");
					} else {
						alert("Comment failed to submit.");
					}
				})
				.catch(err => {
					console.error("Error submitting comment:", err);
				});
		}
	</script>
</body>

</html>