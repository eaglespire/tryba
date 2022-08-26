@extends('user.website.user.index')
@section('mainpage')
<div class="row g-xl-8">
    <div class="col-xl-12">
        <div class="card mb-10">
            <div class="card-header card-header-stretch">
                <div class="card-title d-flex align-items-center">
                    <h3 class="fw-bolder m-0 text-dark">{{__('Menu')}}</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row gx-8">
                    <div class="col-sm-6">
                        <form id="frmEdit" class="form-horizontal">
                            <div class="form-group mb-4">
                                <label for="text">Text</label>
                                <input type="text" class="form-control item-menu mt-4" name="text" id="text" placeholder="Text">
                            </div>
                            <div class="form-group mb-4">
                                <label for="href">URL</label>
                                <input type="text" class="form-control item-menu mt-4" id="href" name="href" placeholder="URL">
                            </div>
                            <div class="form-group mb-4">
                                <label for="target">Target</label>
                                <select name="target" id="target" class="form-control item-menu mt-4">
                                    <option value="_self">Self</option>
                                    <option value="_blank">Blank</option>
                                    <option value="_top">Top</option>
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="title">Tooltip</label>
                                <input type="text" name="title" class="form-control item-menu mt-4" id="title" placeholder="Tooltip">
                            </div>
                        </form>
                        <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fas fa-sync-alt"></i> Update</button>
                        <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
                    </div>
                    <div class="col-sm-6 p-4 mt-4 mt-lg-0 bg-light">
                        <ul id="myEditor" class="sortableLists list-group">
                        </ul>
                    </div>
                </div>
                <form action="{{ route('website.widgets.menu') }}" method="post">
                    @csrf
                    <input type="hidden" id="menu" name="menus" value="{{  json_encode($user->website->webCustomization->menus) }}">
                    </div><div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button id="menuBtn" type="submit" class="btn btn-primary px-6">{{__('Save changes')}}</button>
                    </div>
                </form>
        </div>
        
        <div class="card mb-6">
            <div class="card-header card-header-stretch">
                <div class="card-title d-flex flex-grow-1 justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bolder m-0 text-dark">{{__('Slides')}}</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{route('add.slider.website')}}" class="btn btn-info btn-color-light btn-sm">{{__('Create Slide')}}</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="kt_datatable_example_6" class="table align-middle table-row-dashed g-5 ">
                    <thead>
                        <tr class="fw-bolder fs-6 text-gray-800">
                            <th class="min-w-25px"></th>
                            <th class="min-w-80px">{{__('Image')}}</th>
                            <th class="min-w-50px">{{__('Title')}}</th>
                            <th class="min-w-50px">{{__('Status')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(($user->website->webCustomization->slider != NULL) ? $user->website->webCustomization->slider : []  as $key =>$item)
                        <tr>
                            <td>
                                <button type="button" class="btn btn-clean btn-sm btn-icon btn-light-primary btn-active-light-primary me-n3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                    <span class="svg-icon svg-icon-3 svg-icon-primary">
                                        <i class="fal fa-chevron-circle-down"></i>
                                    </span>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">{{__('Options')}}</div>
                                    </div>
                                    <div class="menu-item px-3"><a href="{{ route('edit.slider.website', ['id'=> $key + 1 ]) }}" class="menu-link px-3">{{__('Edit')}}</a></div>
                                    <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#slide_delete{{ $key + 1 }}" class="menu-link px-3">{{__('Delete')}}</a></div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <div class="symbol symbol-50px me-6 bg-light">
                                        <img alt="image" src="{{ $item['url'] }}">
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item['title1'] }}</td>
                            <td>@if($item['status'] == 1)Active @else Disabled @endif</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @foreach(($user->website->webCustomization->slider != NULL) ? $user->website->webCustomization->slider : [] as $key =>$item)
            <div class="modal fade" tabindex="-1" id="slide_delete{{ $key + 1 }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{__('Delete Slide')}}</h5>
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <span class="svg-icon svg-icon-2x"></span>
                            </div>
                        </div>
                        <div class="modal-body">
                            <p>{{__('Are you sure you want to delete this?')}}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <form method="post" action="{{ route('delete.slider.website', ['id'=> $key + 1]) }}">
                                @csrf
                                @method('delete')
                                <input type="submit" class="btn btn-danger btn-sm" value="{{__('Proceed')}}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach   
        <div class="card mt-6">
            <div class="card-header card-header-stretch">
                <div class="card-title d-flex flex-grow-1 justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bolder m-0 text-dark">{{__('Team')}}</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{route('add.team.website')}}" class="btn btn-info btn-color-light btn-sm">{{__('New Team member')}}</a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                <table id="kt_datatable_example_6" class="table align-middle table-row-dashed gy-5 gs-7">
                    <thead>
                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                            <th class="min-w-25px"></th>
                            <th class="min-w-80px">{{__('Title')}}</th>
                            <th class="min-w-80px">{{__('Occupation')}}</th>
                            <th class="min-w-50px">{{__('Status')}}</th>
                            <th class="min-w-50px">{{__('Date')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(getTeam($user->website->id) as $k=>$val)
                        <tr>
                            <td>
                                <button type="button" class="btn btn-clean btn-sm btn-icon btn-light-primary btn-active-light-primary me-n3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                    <span class="svg-icon svg-icon-3 svg-icon-primary">
                                        <i class="fal fa-chevron-circle-down"></i>
                                    </span>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">{{__('Options')}}</div>
                                    </div>
                                    <div class="menu-item px-3"><a href="{{route('edit.team.website', ['id'=>$val->id])}}" class="menu-link px-3">{{__('Edit')}}</a></div>
                                    <div class="menu-item px-3"><a href="#" data-bs-toggle="modal" data-bs-target="#slide_delete{{$val->id}}" class="menu-link px-3">{{__('Delete')}}</a></div>
                                </div>
                            </td>
                            <td>{{$val->title}}</td>
                            <td>{{$val->occupation}}</td>
                            <td>@if($val->status==1)Active @else Disabled @endif</td>
                            <td>{{$val->created_at->diffforHumans()}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @foreach(getTeam($user->website->id) as $k=>$val)
        <div class="modal fade" tabindex="-1" id="slide_delete{{$val->id}}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{__('Delete Team')}}</h5>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <span class="svg-icon svg-icon-2x"></span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <p>{{__('Are you sure you want to delete this?')}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <form method="post" action="{{ route('delete.team.website', $val->id) }}">
                            @csrf
                            @method('delete')
                            <input type="submit" class="btn btn-danger btn-sm" value="{{__('Proceed')}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach 
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('asset/dashboard/fontawesome-iconpicker/fontawesome-iconpicker.min.js')}}"></script>
<script src="{{asset('asset/dashboard/jquery-menu-editor/jquery-menu-editor.js')}}"></script>
    <script>
        // icon picker options
        var iconPickerOptions = {searchText: "Buscar...", labelHeader: "{0}/{1}"};
        // sortable list options
        var sortableListOptions = {
            placeholderCss: {'background-color': "#cccccc"}
        };
        var editor = new MenuEditor('myEditor', 
                    { 
                    listOptions: sortableListOptions, 
                    iconPicker: iconPickerOptions,
                    maxLevel: 2 // (Optional) Default is -1 (no level limit)
                    // Valid levels are from [0, 1, 2, 3,...N]
                    });
        editor.setForm($('#frmEdit'));
        editor.setUpdateButton($('#btnUpdate'));
        //Calling the update method
        $("#btnUpdate").click(function(){
            editor.update();
        });
        // Calling the add method
        $('#btnAdd').click(function(){
            editor.add();
        });

        let menuHidden = document.querySelector('#menu')
        
        editor.setData(menuHidden.value);

        $('#menuBtn').click(function(){
            var str = editor.getString();
            menuHidden.value = str;
        });
    </script>
@endsection

