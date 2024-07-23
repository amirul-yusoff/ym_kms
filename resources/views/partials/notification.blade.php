<?php
	$user = Auth::user();
	// this is place for developer notification
?>

<script type="text/javascript">
	if(!localStorage.noty) {
		setTimeout(function() {
			var user = '<?php echo $user->employee_name; ?>';
			toastr.options = {
				closeButton: true,
				showMethod: 'slideDown',
				timeOut: 0,
				extendedTimeOut: 0,
				onCloseClick: function() {
					localStorage.setItem('noty', true);
				}
			};
			toastr.info('Profile Image Upload has been fix. You may change your profile image now.', 'Hello '+user);
		}, 100);
	}
</script>
