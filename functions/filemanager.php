<?php
function get_file() {
$uid = Session::GetHash()->user_uid;
$file = DB::connect();
$file_data = $file->get_file($uid);
while($fetch = $file_data->fetch_assoc()) {
	$id = Hash::make($fetch['file_uid']);
	$name = $fetch['name'];
	$size = get_size($fetch['size']);
	$date = date("d M, Y", $fetch['time']);
	$type = $fetch['type'];
	$download = rand(0,89);
	echo '<a href="/download/' . $id . '"><div class="list">
				<div class="list-item">
					<div class="list-item-icon"></div>
					<div class="list-item-name">' . $name . '</div>
					<div class="list-item-date">' . $date . '</div>
					<div class="list-item-size">' . $size . '</div>
					<div class="list-item-type">' . $type . '</div>
					<div class="list-item-download">' . $download . '</div>
				</div>
			</div></a>';
}
}

?>