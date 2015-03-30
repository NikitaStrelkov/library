$(function () {
// delete elements
    $('.button-delete').on('click', function ( ) {
        var obj = $(this);
        sendAjax("/delete/", getData( obj ), function(response){
            if(response.status === true) {
                alert("You have successfully deleted data");
                obj.closest('tr').remove();
            } else {
                alert(response.message);
            }
        });
    });
// edit events
    $(".button-edit").on("click", function ( ) {
        sendAjax('/edit/', getData( $(this) ), function(response){
            if(response.status === true) {
                alert("You have successfully changed element data");
            } else {
                alert(response.message);
            }
        });
    });
    $(".button-add-new").on("click", function ( ) {
        var data = getData( $(this) );
        sendAjax('/edit/', data, function(response){
            if(response.status === true) {
                alert("You have successfully added element");
                var newTdHtml = '',
                    params = data['params'];
                for (var prop in params) {
                    if(params.hasOwnProperty(prop) && prop !== 'id') {
                        var td = '<td><input type="text" class="prop" data-propname="{{ prop }}" value="{{ prop-value }}"></td>';
                        newTdHtml += td.replace(/{{ prop }}/, prop).replace(/{{ prop-value }}/, params[prop]);
                    }
                }
                newTdHtml +=
                    '<td><input type="button" class="button-edit" data-id="null" data-class="{{ class }}" value="Edit"> ' +
                    '<input type="button" class="button-delete" data-id="null" data-class="{{ class }}" value="Delete"></td>';
                var finalRow = newTdHtml.replace(/{{ class }}/g, data['class']);
                $(finalRow).insertBefore($(".row").eq(0));
            } else {
                alert(response.message);
            }
        });
    });

    function getData ( button ) {
        var data = {},
            id = button.data("id"),
            params = {};
        data["class"] = button.data("class");
        button.
            closest(".row").
            find(".prop").
            each(function() {
                var that = $(this);
                params[that.data("propname")] = that.val();
            });
        params["id"] = id;
        data['params'] = params;
        return data;
    }

    function sendAjax(url, data, handler) {
        $.ajax({
            "url": url,
            "data": {"request": data},
            "type": "POST",
            "dataType": "JSON",
            "success": function(response) {
                if(typeof handler === 'function') {
                    handler(response);
                }
            }
        });
    }
});
