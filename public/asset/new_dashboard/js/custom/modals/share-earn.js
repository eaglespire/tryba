"use strict";
var KTModalShareEarn = {
    init: function () {
        var e, s;
        (e = $(".castro-copy")),
            (s = new ClipboardJS(e)) &&
                s.on("success", function (s) {
                    var t = e.innerHTML;
                        (e.innerHTML = "Copied!"),
                        setTimeout(function () {
                            (e.innerHTML = t);
                        }, 3e3),
                        s.clearSelection();
                });
    },
};
KTUtil.onDOMContentLoaded(function () {
    KTModalShareEarn.init();
});
