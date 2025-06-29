<?php

use Aws\Exception\AwsException;

include "minio_client.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
	$video_name = $_FILES['videoFile']['name'];
    $video_tmp  = $_FILES['videoFile']['tmp_name'];

	$client = getClient();
    $bucket = "videos";

     try{
           $result = $client->putObject([
				'Bucket' => $bucket,
				'Key'    => $video_name,
				'SourceFile' => $video_tmp,
				'ACL'    => 'public-read'
		   ]);
	 }
	 catch(AwsException $e)
	 {
		echo "Upload to minio is failed";
		exit;
	 }
  
	 $video_url = $result['ObjectURL'];

	 $video_info = User::videos_info($title, $description,$video_url);


    if ($video_info) {
        header("Location:index.php");
    } else {
        header("Location:upload.php");
    }

}

?>

<!DOCTYPE html>
<html>

<head>
	<title>Upload Video</title>
	<link rel="stylesheet" href="assests/css/upload.css">
</head>

<body>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<h2>Upload Your Video</h2>

		<label>Title:</label>
		<input type="text" name="title" required>

		<label>Description:</label>
		<textarea name="description" required></textarea>

		<label>Select video file:</label>
		<input type="file" name="videoFile" accept="video/*" required>

		<input type="submit" value="Upload Video">
	</form>
</body>

</html>