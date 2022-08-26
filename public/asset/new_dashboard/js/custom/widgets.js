"use strict";
var KTWidgets = (function () {
    var e = function (e, t, a, s) {
        var r = document.querySelector(t),
            i = parseInt(KTUtil.css(r, "height"));
        if (r) {
            var o = {
                    series: [{ name: "Profit", data: a }],
                    chart: { fontFamily: "inherit", type: "bar", height: i, toolbar: { show: !1 } },
                    plotOptions: { bar: { horizontal: !1, columnWidth: ["30%"], endingShape: "rounded" } },
                    legend: { show: !1 },
                    dataLabels: { enabled: !1 },
                    stroke: { show: !0, width: 2, colors: ["transparent"] },
                    xaxis: {
                        crosshairs: { show: !1 },
                        categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        axisBorder: { show: !1 },
                        axisTicks: { show: !1 },
                        labels: { style: { colors: KTUtil.getCssVariableValue("--bs-gray-400"), fontSize: "12px" } },
                    },
                    yaxis: { crosshairs: { show: !1 }, labels: { style: { colors: KTUtil.getCssVariableValue("--bs-gray-400"), fontSize: "12px" } } },
                    states: { normal: { filter: { type: "none", value: 0 } }, hover: { filter: { type: "none" } }, active: { allowMultipleDataPointsSelection: !1, filter: { type: "none", value: 0 } } },
                    fill: { opacity: 1 },
                    tooltip: {
                        style: { fontSize: "12px" },
                        y: {
                            formatter: function (e) {
                                return "$" + e + "k";
                            },
                        },
                    },
                    colors: [KTUtil.getCssVariableValue("--bs-primary")],
                    grid: { borderColor: KTUtil.getCssVariableValue("--bs-gray-300"), strokeDashArray: 4, yaxis: { lines: { show: !0 } } },
                },
                l = new ApexCharts(r, o),
                n = !1,
                c = document.querySelector(e);
            !0 === s && (l.render(), (n = !0)),
                c.addEventListener("shown.bs.tab", function (e) {
                    0 == n && (l.render(), (n = !0));
                });
        }
    };
    return {
        init: function () {
            var t, a, s, r, i, o, l, n, c;
            !(function () {
                var e = document.getElementById("kt_chart_widget_1_chart"),
                    t = parseInt(KTUtil.css(e, "height"));
                if (e) {
                    var a = {
                        series: [{ name: "Net Profit", data: [30, 30, 43, 43, 34, 34, 26, 26, 47, 47] }],
                        chart: { fontFamily: "inherit", type: "area", height: t, toolbar: { show: !1 }, zoom: { enabled: !1 }, sparkline: { enabled: !0 } },
                        plotOptions: {},
                        legend: { show: !1 },
                        dataLabels: { enabled: !1 },
                        fill: { type: "solid", opacity: 0.075 },
                        stroke: { curve: "smooth", show: !0, width: 3, colors: [KTUtil.getCssVariableValue("--bs-primary")] },
                        xaxis: {
                            categories: ["Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov"],
                            axisBorder: { show: !1 },
                            axisTicks: { show: !1 },
                            labels: { show: !1, style: { colors: KTUtil.getCssVariableValue("--bs-gray-500"), fontSize: "12px" } },
                            crosshairs: { show: !1, position: "front", stroke: { color: KTUtil.getCssVariableValue("--bs-gray-200"), width: 1, dashArray: 3 } },
                            tooltip: { enabled: !0, formatter: void 0, offsetY: 0, style: { fontSize: "12px" } },
                        },
                        yaxis: { min: 0, max: 60, labels: { show: !1, style: { colors: KTUtil.getCssVariableValue("--bs-gray-500"), fontSize: "12px" } } },
                        states: { normal: { filter: { type: "none", value: 0 } }, hover: { filter: { type: "none", value: 0 } }, active: { allowMultipleDataPointsSelection: !1, filter: { type: "none", value: 0 } } },
                        tooltip: {
                            style: { fontSize: "12px" },
                            y: {
                                formatter: function (e) {
                                    return "$" + e + " sales";
                                },
                            },
                        },
                        colors: [KTUtil.getCssVariableValue("--bs-primary")],
                        markers: { colors: [KTUtil.getCssVariableValue("--bs-light-primary")], strokeColor: [KTUtil.getCssVariableValue("--bs-primary")], strokeWidth: 3 },
                    };
                    new ApexCharts(e, a).render();
                }
            })(),
                (t = document.getElementById("kt_charts_widget_2_chart")),
                (a = parseInt(KTUtil.css(t, "height"))),
                (s = KTUtil.getCssVariableValue("--bs-gray-500")),
                (r = KTUtil.getCssVariableValue("--bs-gray-200")),
                (i = KTUtil.getCssVariableValue("--bs-primary")),
                (o = KTUtil.getCssVariableValue("--bs-gray-300")),
                t &&
                    new ApexCharts(t, {
                        series: [
                            { name: "Net Profit", data: [50, 60, 70, 80, 70, 60, 70, 80, 90, 100, 80] },
                            { name: "Revenue", data: [50, 60, 70, 80, 70, 60, 70, 80, 90, 100, 80] },
                        ],
                        chart: { fontFamily: "inherit", type: "bar", height: a, toolbar: { show: !1 } },
                        plotOptions: { bar: { horizontal: !1, columnWidth: ["50%"], endingShape: "rounded" } },
                        legend: { show: !1 },
                        dataLabels: { enabled: !1 },
                        stroke: { show: !0, width: 2, colors: ["transparent"] },
                        xaxis: { categories: ["Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"], axisBorder: { show: !1 }, axisTicks: { show: !1 }, labels: { style: { colors: s, fontSize: "12px" } } },
                        yaxis: { labels: { style: { colors: s, fontSize: "12px" } } },
                        fill: { type: "solid" },
                        states: { normal: { filter: { type: "none", value: 0 } }, hover: { filter: { type: "none", value: 0 } }, active: { allowMultipleDataPointsSelection: !1, filter: { type: "none", value: 0 } } },
                        tooltip: {
                            style: { fontSize: "12px" },
                            y: {
                                formatter: function (e) {
                                    return "$" + e + " revenue";
                                },
                            },
                        },
                        colors: [i, o],
                        grid: { borderColor: r, strokeDashArray: 4, yaxis: { lines: { show: !0 } } },
                    }).render(),
                e("#kt_charts_widget_3_tab_1", "#kt_charts_widget_3_chart_1", [30, 40, 30, 25, 40, 45, 30, 20, 40, 25, 20, 30], !0),
                e("#kt_charts_widget_3_tab_2", "#kt_charts_widget_3_chart_2", [25, 30, 25, 45, 30, 40, 30, 25, 40, 20, 25, 30], !1),
                (function () {
                    var e = document.getElementById("kt_chart_widget_4_chart"),
                        t = parseInt(KTUtil.css(e, "height"));
                    if (e) {
                        var a = {
                            series: [74],
                            chart: { fontFamily: "inherit", height: t, type: "radialBar", offsetY: 0 },
                            plotOptions: {
                                radialBar: {
                                    startAngle: -90,
                                    endAngle: 90,
                                    hollow: { margin: 0, size: "70%" },
                                    dataLabels: {
                                        showOn: "always",
                                        name: { show: !0, fontSize: "13px", fontWeight: "700", offsetY: -5, color: KTUtil.getCssVariableValue("--bs-gray-500") },
                                        value: { color: KTUtil.getCssVariableValue("--bs-gray-700"), fontSize: "30px", fontWeight: "700", offsetY: -40, show: !0 },
                                    },
                                    track: { background: KTUtil.getCssVariableValue("--bs-light-primary"), strokeWidth: "100%" },
                                },
                            },
                            colors: [KTUtil.getCssVariableValue("--bs-primary")],
                            stroke: { lineCap: "round" },
                            labels: ["My Achievements"],
                        };
                        new ApexCharts(e, a).render();
                    }
                })(),
                (l = document.querySelector("#kt_widget_5_load_more_btn")),
                (n = document.querySelector("#kt_widget_5")),
                l &&
                    l.addEventListener("click", function (e) {
                        e.preventDefault(),
                            l.setAttribute("data-kt-indicator", "on"),
                            setTimeout(function () {
                                l.removeAttribute("data-kt-indicator"), n.classList.remove("d-none"), l.classList.add("d-none"), KTUtil.scrollTo(n, 200);
                            }, 2e3);
                    }),
                (c = document.querySelector("#kt_user_follow_button")) &&
                    c.addEventListener("click", function (e) {
                        e.preventDefault(),
                            c.setAttribute("data-kt-indicator", "on"),
                            (c.disabled = !0),
                            c.classList.contains("btn-success")
                                ? setTimeout(function () {
                                      c.removeAttribute("data-kt-indicator"),
                                          c.classList.remove("btn-success"),
                                          c.classList.add("btn-light"),
                                          c.querySelector(".svg-icon").classList.add("d-none"),
                                          (c.querySelector(".indicator-label").innerHTML = "Follow"),
                                          (c.disabled = !1);
                                  }, 1500)
                                : setTimeout(function () {
                                      c.removeAttribute("data-kt-indicator"),
                                          c.classList.add("btn-success"),
                                          c.classList.remove("btn-light"),
                                          c.querySelector(".svg-icon").classList.remove("d-none"),
                                          (c.querySelector(".indicator-label").innerHTML = "Following"),
                                          (c.disabled = !1);
                                  }, 1e3);
                    });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTWidgets.init();
});

