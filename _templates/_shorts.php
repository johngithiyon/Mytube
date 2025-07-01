<?php

include "minio_client.php";
session_start();
$user = $_SESSION['user'];
$video_url = "";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $videoname = $_FILES['shortVideo']['name'];
    $video_path = $_FILES['shortVideo']['tmp_name'];
    $video_size =  $_FILES['shortVideo']['size'];


    $client = getClient();
    $bucket = "shorts";

    if ($video_size <= 3817394) {
        $result = $client->putObject([
          'Bucket' => $bucket,
          'Key'    => $videoname,
          'SourceFile' => $video_path,
          'ACL'    => 'public-read',
          'ContentType' => mime_content_type($video_path),
        ]);

    } else {
        echo "Invalid Videos";
    }

    $video_url = $result['ObjectURL'];

    if ($shorts = User::shorts($user, $video_url)) {
        echo "inserted successfully";
    } else {
        echo "Not inserted";
    }

}

$shorts_fetch = User::shorts_fetch();

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>My Shorts</title>
</head>

<body>
<center>
	<h1>🎬 Upload Your Shorts</h1>

	<form action="shorts.php" method="POST" enctype="multipart/form-data">
		<input type="file" name="shortVideo" accept="video/*" required>
		<button type="submit" class="upload-btn">Upload Short</button>
	</form><br><br><br>


	<div class="short-container" id="shortContainer">
		<?php foreach ($shorts_fetch as $shorts) {?> 
		<video controls  width="320"  height="240" style="background: black;">
			<source
				src="<?php echo $shorts['video_url']?>" type="video/mp4">
			Your browser does not support the video tag.
		</video>
		<div class="actions">
			<button>❤️</button> <button>💬</button> <button>🔗</button>
		</div>
		<?php }?> 
	</div>
</center>

</body>

</html>