const sendRequest = function (param) {

    "use strict";

    return new Promise(function (resolve, reject) {

        $.ajax({
            method: param.method,
            data: param.data,
            url: param.url,
            dataType: "json",
            success: resolve,
            error: reject
        });
    });
};

const numberFormat = function (num, type) {

    "use strict";

    if (type === undefined) {
        type = "num"
    }

    let prefix;
    let decimals;

    switch (type) {
    case "num":
        prefix = "";
        decimals = 0;
        break;
    case "curr":
        prefix = "$";
        decimals = 2;
        break;
    }

    return prefix + Number(num).toFixed(decimals).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
};

const datepickerIso = function (domId) {

    "use strict";

    return $.datepicker.formatDate("yy-mm-dd", $(`#${domId}`).datepicker("getDate"));
};

const setupDatepicker = function (param) {

    "use strict";

    $(`#${param.domId}`).datepicker(param.options);
};
