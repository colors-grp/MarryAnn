<!--//alertify functions-->
<script src="<?=base_url()?>/h7-assets/resources/alertify/lib/alertify.min.js"></script>
<link rel="stylesheet" href="<?=base_url()?>/h7-assets/resources/alertify/themes/alertify.core.css" />
<link rel="stylesheet" href="<?=base_url()?>/h7-assets/resources/alertify/themes/alertify.default.css" />
<script>
function message(){
    var error_message = '\n <?=$this->lang->line('happy_face');?>'+'  <?=$this->lang->line('waite_for_us');?>';
    if(<?=(isset($error_num))?$error_num:0;?> == 1){
        alert_info(error_message);
    }
}
function alert_success(message){
	alertify.set({ delay: 7000 });
    alertify.success(message);
    return false;
}
function alert_error(message){
	alertify.set({ delay: 7000 });
    alertify.error(message);
    return false;
}
function alert_warning(message){
	alertify.set({ delay: 7000 });
    alertify.warning(message);
    return false;
}
function alert_info(message){
	alertify.set({ delay: 7000 });
    alertify.info(message);
    return false;
}
//end of alertify functions
</script>