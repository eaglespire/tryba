@extends('user.expense.index')

@section('mainpage')
    <div class="col-xl-12">
        <div class="card my-5 my-xl-8">
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
                        <span class="fw-boldest text-dark fs-2">{{ $type }}</span>
                        <span class="text-dark-400 fw-bold fs-6">{{date("M, d", strtotime($startDate))}} - {{date("M, d Y", strtotime($endDate))}}</span>
                        <span class="text-dark-400 fw-bold fs-6">{{number_format($amount,2).$currency->name}}</span>
                    </div>
                    <!--end::Text-->
                </div>
                <!--begin::Chart-->
                <div class="">
                    @if($amount)
                        <div id="kt_chart_earning" class="card-rounded-bottom h-125px"></div>
                    @else
                        <div class="card-rounded-bottom h-125px text-center text-primary">{{__('No data')}}</div>
                    @endif
                </div>
                <!--end::Chart-->
            </div>
        </div>
    </div>
    <div class="row g-xl-8">
        <div class="col-xl-12">
        <div class="row g-5 g-xxl-8">
            <div class="card">
                <div class="card-header card-header-stretch">
                    <div class="card-title d-flex align-items-center">
                        <h3 class="fw-bolder m-0 text-dark">{{ $type }} {{__('Report')}}</h3>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <table id="kt_datatable_example_7" class="table align-middle table-row-dashed gy-5 gs-7">
                        <thead>
                            <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                <th class="min-w-80px"></th>
                                <th class="min-w-80px">{{__('Name')}}</th>
                                <th class="min-w-80px">{{__('Amount')}}</th>
                                <th class="min-w-70px">{{__('Date')}}</th>
                                <th class="min-w-50px">{{__('Category')}}</th>
                                <th class="min-w-50px">{{__('Sub category')}}</th>
                                <th class="min-w-50px">{{__('Created')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($result as $item)
                        <tr>
                            <td>
                                <button type="button" class="btn btn-clean btn-sm btn-icon btn-light-primary btn-active-light-primary me-n3" data-kt-menu-trigger="click">
                                    <span class="svg-icon svg-icon-3 svg-icon-primary">
                                    <i class="fal fa-chevron-circle-down"></i>
                                    </span>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                                    <div class="menu-item px-3">
                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">{{__('Options')}}</div>
                                    </div>
                                    @if(!empty($item->invoiceurl))
                                        <div class="menu-item px-3"><a href="{{ asset($item->invoiceurl) }}" class="menu-link px-3">{{__('View invoice')}}</a></div>
                                    @endif
                                        <div class="menu-item px-3"><a href="{{ route('putIncome',$item->id) }}" class="menu-link px-3">{{__('Edit')}}</a></div>
                                    <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#delete{{$item->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                                </div>
                            </td>
                            <td data-href="">{{ $item->name }}</td>
                            <td data-href="">{{ $currency->symbol }} {{ number_format($item->amount) }}</td>
                            <td data-href="">{{ date('m/d/Y',strtotime($item->date)) }}</td>
                            <td data-href="">{{ ($item->category) ? $item->category->Name : "" }}</td>
                            <td data-href="">{{ ($item->subcategory) ? $item->subcategory->Name : ""}}</td>
                            <td data-href="">{{ $item->created_at->diffforHumans() }}</td>
                        
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @foreach($result as $item)
            <div class="modal fade" id="delete{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body mt-4">
                            <div class="card bg-white border-0 mb-0">
                                <div class="card-header">
                                    <h3 class="mb-0">{{__('Are you sure you want to delete this?')}}</h3>
                                </div>
                                <div class="card-body d-flex px-lg-5 py-lg-5 text-right">
                                    <button type="button" class="btn btn-neutral btn-sm" data-dismiss="modal">{{__('Close')}}</button>
                                    <form method="post" action="{{ route('deleteIncome', $item->id) }}">
                                        @csrf
                                        @method('delete')
                                        <input type="submit" class="btn btn-danger btn-sm" value="{{__('Proceed')}}">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
@endsection

@section('script')
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
                    name: 'Expenses',
                    data: [<?php foreach ($result as $val) {
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
                    categories: [<?php foreach ($result as $val) {
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
