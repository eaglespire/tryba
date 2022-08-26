@extends('user.expense.index')

@section('mainpage')
    <div class="row g-xl-8">
        <div class="col-xl-12">
        <div class="row g-5 g-xxl-8">
            <div class="card">
            <div class="card-body pt-3">
                <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                    <thead>
                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                            <th class="min-w-50px"></th>
                            <th class="min-w-80px">{{__('Month')}}</th>
                            <th class="min-w-80px">{{__('Amount')}}</th>
                            <th class="min-w-50px">{{__('Category')}}</th>
                            <th class="min-w-50px">{{__('Sub category')}}</th>
                            <th class="min-w-50px">{{__('Created')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($expenses as $item)
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
                                <div class="menu-item px-3"><a href="{{ route('updateBudget',$item->id) }}" class="menu-link px-3">{{__('Edit')}}</a></div>
                                <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#delete{{$item->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                            </div>
                        </td>
                        <td data-href="">{{ $item->month }} {{ $item->year }}</td>
                        <td data-href="">{{ $currency->symbol }} {{ number_format($item->amount) }}</td>
                        <td data-href="">{{ $item->category->Name }}</td>
                        <td data-href="">
                            @if ($item->subcategory) {{ $item->subcategory->Name }} @endif </td>
                        <td data-href="">{{ $item->created_at->diffforHumans() }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            </div>
        </div>
        @foreach($expenses as $item)
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
                                <form method="post" action="{{ route('deleteBudget', $item->id) }}">
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
