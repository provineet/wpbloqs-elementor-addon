jQuery(document).ready(function ($) {
    let html = `<fieldset id="wpb-anchor-%id%">
                    <div class="container">
                        <div class="row">
                            <div class="col-6">
                                <label>ID</label>
                                <input type="text" name="wpb_anchor_id[]" id="wpb_anchor_id_%id%">
                            </div>
                            <!-- /.col-6 -->
                            <div class="col-6">
                                <label>Label</label>
                                <input type="text" name="wpb_tab_label[]" id="wpb_tab_label_%id%">
                            </div>
                            <!-- /.col-6 -->
                            <button class="wpb_delete">+</button>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container -->
                </fieldset>`;
    
    $('.wpb_add_button').on('click', function(e){
        e.preventDefault();
        let newId = $('.wpb_fields fieldset').length + 1;
        let newHtml = html.replace("%id%", newId);
        $('.wpb_fields').append(newHtml);
    });

    $('.wpb_delete').on('click', function(e){
        e.preventDefault();
        $(`#${$(this).data('id')}`).remove();
    });

    $( "#sortable" ).sortable();
});