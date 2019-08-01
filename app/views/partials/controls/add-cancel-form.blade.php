<div class="col-md-12">
    <hr>
    <div class="col-md-4 pull-right _flex _flex_v_center _flex_end">

        <?php if(isset($act)){
    ?>

        <a href="/account/{{ $act->accountNumber }}">
        <?php }else{
        ?>

            <a href="/dash">
    <?php
}
    ?>
            <span class="act_tools btn btn-danger alert-danger fa-lg "
                  style="margin-right:15px;" title="Cancel">
            <i class="fa fa-remove"></i> Cancel
        </span></a>
        <button class="act_tools btn btn-success alert-success fa-lg" type="submit" title="Save Changes">
            <i class="fa fa-check"></i> Save
        </button>

    </div>
</div>