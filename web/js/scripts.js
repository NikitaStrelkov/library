(function () {
// edit events
    var elements = document.querySelectorAll(".button-edit");
    for (var prop in elements) {
        if (elements.hasOwnProperty(prop) && typeof elements[prop] === 'object') {
            addEvent(elements[prop], "click", function () {
                var data = new FormData(),
                    id = this.dataset.id,
                    modelClass = this.dataset.class;
                data.append("id", id);
                data.append("class", modelClass);
                if(modelClass === 'Book') {
                    data.append("title", document.querySelector(".title-" + id).value);
                    data.append("author", document.querySelector(".author-" + id).value);
                    data.append("numberOfPages", document.querySelector(".numberOfPages-" + id).value);
                } else if ( modelClass === 'Owner') {
                    data.append("name", document.querySelector(".name-" + id).value);
                    data.append("lastName", document.querySelector(".lastName-" + id).value);
                    data.append("job", document.querySelector(".job-" + id).value);
                }
                sendAjax("/ajax/edit.php", data, function(){
                    alert("You have changed element data");
                });
            });
        }
    }
// new elements
    var element = document.querySelector(".button-add-new");
        addEvent(element, "click", function () {
            var data = new FormData(),
                modelClass = this.dataset.class,
                params = [];
            data.append("class", modelClass );
            if(modelClass === 'Book') {
                params.push(document.querySelector(".title-new").value);
                params.push(document.querySelector(".author-new").value);
                params.push(document.querySelector(".numberOfPages-new").value);
                data.append("title", params[0]);
                data.append("author", params[1]);
                data.append("numberOfPages", params[2]);
            } else if (modelClass === 'Owner') {
                params.push(document.querySelector(".name-new").value);
                params.push(document.querySelector(".lastName-new").value);
                params.push(document.querySelector(".job-new").value);
                data.append("name", params[0]);
                data.append("lastName", params[1]);
                data.append("job", params[2]);
            }
            sendAjax("/ajax/edit.php", data, function(){
                var node = document.createElement('tr');
                node.innerHTML = '' +
                '<td><input type="text" class="" value="' + params[0] + '"></td>' +
                '<td><input type="text" class="" value="' + params[1] + '"></td>' +
                '<td><input type="text" class="" value="' + params[2] + '"></td>' +
                '<td><input type="button" class="button-edit" data-id="null" data-class="" value="Edit"> ' +
                '<input type="button" class="button-delete" data-id="null" data-class="" value="Delete"></td>';
                document.querySelector("table tbody").insertBefore(node, document.querySelector("table tbody tr"));
                alert("You have added book");
            });
        });
// delete elements
    elements = document.querySelectorAll(".button-delete");
    for (var prop in elements) {
        if (elements.hasOwnProperty(prop) && typeof elements[prop] === 'object') {
            addEvent(elements[prop], "click", function () {
                var data = new FormData(),
                    elem = this;
                data.append("id", this.dataset.id);
                data.append("class", this.dataset.class);
                sendAjax("/ajax/delete.php", data, function(){
                    elem.parentNode.parentNode.innerHTML = '';
                });
            });
        }
    }

    function addEvent(elem, type, handler){
        if (elem.addEventListener){
            elem.addEventListener(type, handler, false)
        } else {
            elem.attachEvent("on"+type, handler)
        }
    }

    // кроссбраузерное создание объекта XMLHttpRequest
    function getXHR(){
        var xmlhttp;
        try {
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (E) {
                xmlhttp = false;
            }
        }
        if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
            xmlhttp = new XMLHttpRequest();
        }
        return xmlhttp;
    }

    function sendAjax(url, data, handler) {
        var req = getXHR();
        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                if(req.status == 200) {
                    if(typeof handler === 'function') {
                        handler();
                    }
                }
            }
        };
        req.open('POST', url, true);
        req.send(data);
    }
})();
