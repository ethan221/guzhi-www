

<form action="<?php echo $payurl; ?>" name="E_FORM" method="post">

    <?php foreach($parameter as $key => $val){ ?>
    <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $val; ?>" /><br />
    <?php } ?>
</form>

<script>
    function submit(){
        javascript:document.E_FORM.submit();
    }
    submit();
</script>