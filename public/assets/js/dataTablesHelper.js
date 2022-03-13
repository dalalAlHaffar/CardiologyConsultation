function initAjaxDataTable(route , columns , table_id , drawCallback , ajaxDataFun = null , defaultOrder = null   ) {
    var table = $('#'+table_id).DataTable({
        "aaSorting": [[2, 'desc']],
        "processing": true,
        "serverSide": true,
        "ajax": {
            url : route ,
            method : "GET",
            data: function(data){
               
                if(  ajaxDataFun != null ){
                    ajaxDataFun(data);
                }
            }
        },
        "columns": initAjaxDataTableColumns(columns) ,
        "initComplete": function(settings, json) {
        } ,
        "createdRow": function (row, data, index) {
        },
        "order": (defaultOrder != null ? defaultOrder : [])  ,
        "columnDefs": [ { "orderable": false, "targets":[ 0 ]  } ],
        "drawCallback":  drawCallback ,
    });

    // $('#search-form').on('submit', function(e) {
    //     e.preventDefault();
    //     table.draw();
    // });
    return table;

}



function initAjaxDataTableColumns(columns) {
    let ref_columns = new Array();
    columns.forEach(function (column) {
        ref_columns.push({
            "data" : column , "name" : column
        })
    })
    return ref_columns ;
}

function createActionList() {

    let outerDIV = $("<div>", {
        class : "btn-group dropright"
    });

    let actionBTN = $("<button>", {
        class : "btn btn-outline-info dropdown-toggle",
        text:'actions',
        type : "button" ,
        "data-toggle" : "dropdown" ,
        "aria-haspopup" :"true" ,
        "aria-expanded" : "false"

    });


    let innerDIV = $('<div>' , {
        class : "dropdown-menu" ,
        "x-placement" : "left-start",
        "style" : "position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-162px, 0px, 0px);"
    })

    let title = $('<h6>' , {
        class : "dropdown-header",
        text:'Actions : ',
    })

    innerDIV.append(title);
    outerDIV.append(actionBTN);
    outerDIV.append(innerDIV);
    return outerDIV;
}

function appendToActionList(actionList , item) {
    let innerDIV = $(actionList).find('div') ;
    innerDIV.append(item)
}


function addActionLink(href , title , iconClass ) {
    let link = $('<a>' , {
        href :  href ,
        class : "dropdown-item",
        // text: title
    });

    let span = $("<span>", {
        class : "btn-label"
    });

    let i = $("<i>", {
        class : iconClass ,
        style: "margin-right :5px;"
    });
    span.append(i);
    span.html(span.html() + title)

    link.append(span);
    return link;
}


function addActionModal(id , title , iconClass  , link_id = "",  onClick = null  ) {
    var link = $('<a>' , {
        href          : "#" ,
        class         : "dropdown-item",
        "data-toggle" : "modal" ,
        "data-target" : id,
        id            : link_id
    });

    if(onClick != null){
        $(link).click(function () {
            onClick($(this));
        })
    }

    let span = $("<span>", {
        class : "btn-label"
    });

    let i = $("<i>", {
        class : iconClass ,
        style: "margin-right :5px;"
    });
    span.append(i);
    span.html(span.html() + title)

    link.append(span);
    return link;
}

function addModal(id , title , bodyFun = null , FooterFun = null) {

    let container = $("<div>", {
        class : "modal fade" ,
        id : id ,
        tabindex : "-1" ,
        role : "dialog" ,
        "aria-hidden" : "true" ,
        "aria-labelledby" : id + "Title"
    });

    let modalDialog = $("<div>", {
        class : "modal-dialog" ,
        role : "document"
    });

    let modalContent = $("<div>", {
        class : "modal-content" ,
    });


    let modalHeader = $("<div>", {
        class : "modal-header" ,
    });


    let modalTitle = $("<h5>", {
        class : "modal-title" ,
        text  : title ,
        id    : id + "Title"
    });

    let modalDismissBtn = $("<button>", {
        type : "button",
        class : "close" ,
        "data-dismiss" : "modal" ,
        "aria-label" : "Close"
    });

    let spanClose = $("<span>", {
        "aria-hidden" : "true" ,
        text : "&times;"
    });

    let modalBody = $("<div>", {
        class : "modal-body" ,
        text : "......."
    });

    if( bodyFun != null ){
        bodyFun(modalBody);
    }

    let modalFooter = $("<div>", {
        class : "modal-footer" ,
        text : "......."
    });

    if( FooterFun != null ){
        FooterFun(modalFooter);
    }


    modalDismissBtn.append(spanClose)
    modalHeader.append(modalTitle)
    modalHeader.append(modalDismissBtn)
    modalContent.append(modalHeader)
    modalContent.append(modalBody)
    modalContent.append(modalFooter)
    modalDialog.append(modalContent);
    container.append(modalDialog)
    return container ;
}


function addActionForm(href , title , iconClass ,csrf_token , method = "post" ) {
    let form = $("<form/>", { action :  href , method : "post" });

    if( method == "delete" || method == "put" || method == "patch"  ){
        let inputMethod = $("<input>" , {
            type : 'hidden' ,
            name : '_method' ,
            value : method
        });

        form.append(inputMethod);
    }


    let i = $("<i>", {
        class : iconClass ,
        style: "margin-right :5px;"
    });

    let button = $("<button>", {
        type:'submit',
        class : "dropdown-item",
        // text: title
    });

    let input = $("<input>" , {
        type : 'hidden' ,
        name : '_token' ,
        value : csrf_token
    });

    form.append(input);
    button.append(i);
    button.html(button.html() + title)
    form.append(button);
    return form;
}
