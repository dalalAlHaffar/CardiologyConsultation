
function initSelect2(select, url) {
    $(select).select2({
        ajax: {
            type: "GET",
            dataType: 'json',
            url:  url,

            data: function (params) {
                return {
                    term: params.term,
                    page: params.page || 1
                }
            },
            cache: true
        },
        templateResult: format,
     
        escapeMarkup: function (m) {
            return m;
        }
    });
}
function format(option) {

    if (!option.id) { return option.text; }
    if('image' in option ){
        var ob = '<img style="height:50px" src="'+option.image+'" />' + option.text ;	// replace image source with option.img (available in JSON)
    }
    else{
        var ob =  option.text ;	// replace image source with option.img (available in JSON)

    }
    return ob;
};



