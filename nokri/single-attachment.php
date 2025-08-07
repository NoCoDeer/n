<?php $attID = isset($_GET['attachment_id']) ? sanitize_text_field($_GET['attachment_id']) : '';
$theFile = wp_get_attachment_url($attID);
if (!$theFile) {
  return;
}
return nokri_downloadfiles_option($theFile);
exit;
