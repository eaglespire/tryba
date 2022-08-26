@extends('user.expense.index')

@section('mainpage')
    <div class="col-md-12">
        <div class="card mb-5 mb-xl-8">
            <!--begin::Body-->
            <div class="card-body p-0 d-flex justify-content-between flex-column">
                <div class="d-flex flex-stack card-p flex-grow-1">
                    <!--begin::Icon-->
                    <div class="symbol symbol-45px">
                        <div class="symbol-label">
                            <i class="fal fa-sync text-primary"></i>
                        </div>
                    </div>
                    <!--end::Icon-->
                    <!--begin::Text-->
                    <div class="d-flex flex-column text-end">
                        <span class="fw-boldest text-dark fs-2">{{__('Income')}}</span>
                        <span class="text-dark-400 fw-bold fs-6">{{date("M, d", strtotime($startDate))}} - {{date("M, d Y", strtotime($endDate))}}</span>
                        <span class="text-dark-400 fw-bold fs-6">{{number_format($amountIncome,2).$currency->name}}</span>
                    </div>
                    <!--end::Text-->
                </div>
                <!--begin::Chart-->
                <div class="">
                    @if($amountIncome)
                        <div id="kt_chart_earning" class="card-rounded-bottom h-125px"></div>
                    @else
                        <div class="card-rounded-bottom h-125px text-center text-primary">{{__('No data')}}</div>
                    @endif
                </div>
                <!--end::Chart-->
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card mb-5 mb-xl-8">
            <!--begin::Body-->
            <div class="card-body p-0 d-flex justify-content-between flex-column">
                <div class="d-flex flex-stack card-p flex-grow-1">
                    <!--begin::Icon-->
                    <div class="symbol symbol-45px">
                        <div class="symbol-label">
                            <i class="fal fa-sync text-primary"></i>
                        </div>
                    </div>
                    <!--end::Icon-->
                    <!--begin::Text-->
                    <div class="d-flex flex-column text-end">
                        <span class="fw-boldest text-dark fs-2">{{__('Expenses')}}</span>
                        <span class="text-dark-400 fw-bold fs-6">{{date("M, d", strtotime($startDate))}} - {{date("M, d Y", strtotime($endDate))}}</span>
                        <span class="text-dark-400 fw-bold fs-6">{{number_format($amountExpense,2).$currency->name}}</span>
                    </div>
                    <!--end::Text-->
                </div>
                <!--begin::Chart-->
                <div class="">
                    @if($amountExpense)
                    <div id="kt_chart_earning_2" class="card-rounded-bottom h-125px"></div>
                    @else
                    <div class="card-rounded-bottom h-125px text-center text-primary">{{__('No data')}}</div>
                    @endif
                </div>
                <!--end::Chart-->
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var element = document.getElementById('kt_chart_earning_2');

            var height = parseInt(KTUtil.css(element, 'height'));
            var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
            var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
            var baseColor = KTUtil.getCssVariableValue('--bs-info');
            var lightColor = KTUtil.getCssVariableValue('--bs-light-info');

            if (!element) {
                return;
            }

            var options = {
                series: [{
                    name: 'Expenses',
                    data: [<?php foreach ($expense as $val) {
                                echo $val->amount . ',';
                            } ?>]
                }],
                chart: {
                    fontFamily: 'inherit',
                    type: 'area',
                    height: height,
                    toolbar: {
                        show: !1
                    },
                    zoom: {
                        enabled: !1
                    },
                    sparkline: {
                        enabled: !0
                    }
                },
                plotOptions: {

                },
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                fill: {
                    type: 'solid',
                    opacity: 1
                },
                stroke: {
                    curve: 'smooth',
                    show: true,
                    width: 0.5,
                    colors: [baseColor]
                },
                xaxis: {
                    categories: [<?php foreach ($expense as $val) {
                                        echo "'" . date("M j", strtotime($val->updated_at)) . "'" . ',';
                                    } ?>],
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    },
                    crosshairs: {
                        position: 'front',
                        stroke: {
                            color: baseColor,
                            width: 1,
                            dashArray: 3
                        }
                    },
                    tooltip: {
                        enabled: true,
                        formatter: undefined,
                        offsetY: 0,
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px'
                    },
                    y: {
                        formatter: function(val) {
                            return '@php echo $currency->symbol; @endphp' + val
                        }
                    }
                },
                colors: [lightColor],
                grid: {
                    borderColor: borderColor,
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                markers: {
                    strokeColor: baseColor,
                    strokeWidth: 3
                }
            };

            var chart = new ApexCharts(element, options);
            chart.render();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var element = document.getElementById('kt_chart_earning');

            var height = parseInt(KTUtil.css(element, 'height'));
            var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
            var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
            var baseColor = KTUtil.getCssVariableValue('--bs-info');
            var lightColor = KTUtil.getCssVariableValue('--bs-light-info');

            if (!element) {
                return;
            }

            var options = {
                series: [{
                    name: 'Income',
                    data: [<?php foreach ($expense as $val) {
                                echo $val->amount . ',';
                            } ?>]
                }],
                chart: {
                    fontFamily: 'inherit',
                    type: 'area',
                    height: height,
                    toolbar: {
                        show: !1
                    },
                    zoom: {
                        enabled: !1
                    },
                    sparkline: {
                        enabled: !0
                    }
                },
                plotOptions: {

                },
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                fill: {
                    type: 'solid',
                    opacity: 1
                },
                stroke: {
                    curve: 'smooth',
                    show: true,
                    width: 0.5,
                    colors: [baseColor]
                },
                xaxis: {
                    categories: [<?php foreach ($expense as $val) {
                                        echo "'" . date("M j", strtotime($val->updated_at)) . "'" . ',';
                                    } ?>],
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    },
                    crosshairs: {
                        position: 'front',
                        stroke: {
                            color: baseColor,
                            width: 1,
                            dashArray: 3
                        }
                    },
                    tooltip: {
                        enabled: true,
                        formatter: undefined,
                        offsetY: 0,
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px'
                    },
                    y: {
                        formatter: function(val) {
                            return '@php echo $currency->symbol; @endphp' + val
                        }
                    }
                },
                colors: [lightColor],
                grid: {
                    borderColor: borderColor,
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                markers: {
                    strokeColor: baseColor,
                    strokeWidth: 3
                }
            };

            var chart = new ApexCharts(element, options);
            chart.render();
        });
    </script>

@endsection