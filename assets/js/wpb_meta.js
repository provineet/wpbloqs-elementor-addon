"use strict";

jQuery(document).ready(function ($) {
  var html = "<fieldset id=\"wpb-anchor-%id%\"><div class=\"container\"><div class=\"row\"><div class=\"col-6\"><label>ID</label><input type=\"text\" name=\"wpb_anchor_id[]\" id=\"wpb_anchor_id_%id%\"></div><div class=\"col-6\"><label>Label</label><input type=\"text\" name=\"wpb_tab_label[]\" id=\"wpb_tab_label_%id%\"></div><button class=\"wpb_delete\">+</button></div></div></fieldset>";
  $(".wpb_add_button").on("click", function (e) {
    e.preventDefault();
    var newId = $(".wpb_fields fieldset").length + 1;
    var newHtml = html.replace("%id%", newId);
    $(".wpb_fields").append(newHtml);
  });
  $(".wpb_delete").on("click", function (e) {
    e.preventDefault();
    $("#".concat($(this).data("id"))).remove();
  });
  $("#sortable").sortable();
});
//# sourceMappingURL=maps/wpb_meta.js.map