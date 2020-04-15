_e = [];
_r = [];

$("#ctrl_new_entitytype").click(function() {
    var cell = createEntitytype({"_e":""}); /* add to graph */
    _e[cell.cid] = {cell: cell};                /* add to entity directory */
});

$("#ctrl_delete").click(function() {
    var cid = highlighted_cell.model.cid;
    highlighted_cell.unhighlight();
    graph.removeCells(graph.getCell(cid));  /* remove from graph */
    delete _e[cid];                         /* remove from directory */
    delete _r[cid];
    onUnselect();
});

$("#ctrl_input_name").keyup(function() {
    var cid = highlighted_cell.model.cid;
    _e[cid].name = $(this).val();
    _e[cid].cell.attr("text/text",$(this).val())
});

foo = null;
// $(foo2.el).effect("pulsate")
function onSelect(cell) {
    onUnselect();
    var cid = cell.model.cid;
    $("#ctrl_delete").removeClass("disabled brown").addClass("red");
    foo = cell;
    switch (cell.attributes()["data-type"]) {
        case "erd.Entity":
            $(".ctrl_entitytype").css("visibility", "visible").show();
            $("#ctrl_input_name").val(_e[cid].name != undefined ? _e[cid].name : "");
            $("#ctrl_input_name").focus();
            break;
    }

}

function onUnselect() {
    $("#ctrl_delete").removeClass("red").addClass("disabled brown");
    $(".ctrl_entitytype").css("visibility", "hidden").hide();
    $(".ctrl_relationship").css("visibility", "hidden").hide();
    $(".ctrl_attribute").css("visibility", "hidden").hide();
    $("#ctrl_input_name").val("");
}