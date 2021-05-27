
function appendUserRow(id, user) {
    var html = "<div id=\"opt-row." + id + "\" class=\"form-group row\">\n" +

        "            <div class=\"col-3\">\n" +
        "                <input required type=\"text\" class=\"form-control\" id=\"opt-name." + id + "\" name=\"name[]" + id + "\" placeholder=\"Name\" value=\"" + user.name + "\">\n" +
        "            </div>\n" +
        // "            <div class=\"col-3\">\n" +
        // "                <input required type=\"email\" class=\"form-control\" id=\"opt-email." + id + "\" name=\"opt-email." + id + "\" placeholder=\"name@example.com\" value=\"" + user.email + "\">\n" +
        // "            </div>\n" +
        "            <div class=\"col-2\">\n" +
        "                <input required type=\"number\" class=\"form-control\" id=\"opt-no." + id + "\" name=\"phone_number[]" + id + "\" placeholder=\"Phone Number\" value=\"" + user.no + "\">\n" +
        "            </div>\n" +
        "             <button type=\"button\" onclick=\"delRow(" + id + ")\" class=\"btn btn-danger\">Delete</button>\n" +
        "        </div>";
    $("#form-placeholder").append(html);
}

function delRow(id) {
    var element = document.getElementById("opt-row." + id);
    element.parentNode.removeChild(element);
}

$(document).ready(function () {
    var count = 0;
    $("#btn-add").click(function () {
        appendUserRow(count++, {
            type: "",
            name: "",
            email: "",
            no: ""
        })
    });
});

