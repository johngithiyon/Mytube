<?php
include "libs/include/Database.class.php";
include 'libs/include/User.class.php';

session_start();

if ($_SESSION['email'] && $_SESSION['password']) {
    if ($_SESSION['remote'] == $_SERVER['REMOTE_ADDR'] && $_SESSION['agent'] == $_SERVER['HTTP_USER_AGENT']) {
        echo "<h>Welcome Back</h>";
    } else {
        echo "Get out you can't";
        exit;
    }
} else {
    header("Location:login.php");
    exit;
}

$video_infos = User::fetch_video_info();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MyTube</title>
  <link rel="stylesheet" href="assests/css/index.css" />
  <style>
    .video-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 20px;
      padding: 20px;
    }
    .video-card {
      border: 1px solid #ccc;
      padding: 10px;
      background: #f9f9f9;
      border-radius: 8px;
      position: relative;
    }
    .video-card h3, .video-card p {
      margin: 10px 0;
    }
    video {
      width: 100%;
      height: auto;
      border-radius: 6px;
    }
    .heart-icon {
      font-size: 24px;
      color: gray;
      cursor: pointer;
      transition: color 0.3s ease;
    }
    .heart-icon.liked {
      color: red;
    }
  </style>
</head>

<body>
  <!-- Top Navigation -->
  <header class="navbar">
    <div class="logo">MyTube</div>
    <div class="search">
      <input type="text" placeholder="Search" />
      <button>🔍</button>
    </div>
    <div class="nav-icons">
      <a href="upload.php">📹</a>
      <span>🔔</span>
      <span>👤</span>
    </div>
  </header>

  <!-- Sidebar + Content -->
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <ul>
        <li>🏠 Home</li>
        <a href="shorts.php"><li>📱 Shorts</li></a>
        <li>📺 Subscriptions</li>
        <li>📚 Library</li>
        <li>🕒 History</li>
      </ul>
    </aside>

    <!-- Main Feed -->
    <main class="feed">
      <div class="video-grid">
        <?php foreach ($video_infos as $video): ?>
          <div class="video-card">
            <center><p><?php echo htmlspecialchars($video['title']); ?></p></center>
            <video controls>
              <source src="<?php echo htmlspecialchars($video['video_url']); ?>" type="video/mp4">
              Your browser does not support the video tag.
            </video>
            <p><?php echo htmlspecialchars($video['description']); ?></p>

            <div style="display: flex; gap: 20px;">
              <!-- Like Button -->
              <div style="display: flex; flex-direction: column; align-items: center;">
                <button class="like-btn" data-id="<?php echo $video['id']; ?>" onclick="liked(this)">❤️</button>
                <p><?php echo User::count_likes($video['id']); ?> likes</p>
              </div>

              <!-- Unlike Button -->
              <div style="display: flex; flex-direction: column; align-items: center;">
                <button class="unlike-btn" data-id="<?php echo $video['id']; ?>" onclick="unlike(this)">🤍</button>
              </div>

              <!-- Comment Icon -->
              <div style="display: flex; flex-direction: column; align-items: center;">
                <button class="comment-btn" data-id="<?php echo $video['id']; ?>" onclick="comments(this)">💬</button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </main>
  </div>

  <script>
  function liked(button) {
    const id = button.getAttribute('data-id');
    fetch('like.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        user: "<?php echo $_SESSION['user']?>",
        videoid: id,
        status:"liked"
      })
    })
    .then(response => response.json())
    .then(data => {
      if (data.action === "liked") {
           alert("liked")
           //button.disabled = true
      }
    })
    .catch(err => {
      console.error("Error:", err);
    });
  }

  function unlike(button) {
    const id = button.getAttribute('data-id');
    fetch("unlike.php", {
      method:"POST",
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        user:"<?php echo $_SESSION['user']?>",
        videoid:id,
        status:"unliked"
      })
    })
    .then(response => response.json())
    .then(data => {
      if(data.action=="unliked") {
        alert("unliked");
        //button.disabled = true;
      }
    })
    .catch(err => {
      console.error("Error:", err);
    });
  }


  function comments(button)
  {
    const id = button.getAttribute('data-id')
    fetch("store_videoid.php",{
      method:"POST",
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        videoid:id,
      })
    })
    .then(response=>response.json())
    .then(data=>{
      console.log("From index server response",data)
    })
    .then(()=>{
      window.location.href = "comment.php"
    })
  }
  </script>
</body>
</html>
