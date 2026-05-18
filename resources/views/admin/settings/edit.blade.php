@extends('layouts.main')

@section('title', 'Site Settings')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Edit <small>Site Settings</small>
                </h1>
                <ol class="breadcrumb">
                    {{ generateBreadcrumb() }}
                </ol>
            </div>
        </div>

        <!-- Flash Messages -->
        <div class="row">
            <div class="col-lg-12">
                @component('elements.admin.components.flash') @endcomponent
            </div>
        </div>

        <div class="parent-content-wrapper">
            <div id="content-sortable">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="fa fa-user"></i> Edit Settings
                                    <a class="collapse-link pull-right">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </h3>
                            </div>

                            <div class="panel-body">

                                <!-- ✅ REPLACED Form::Model -->
                                <form
                                    action="{{ route('admin.site.setting') }}"
                                    method="POST"
                                    enctype="multipart/form-data"
                                    id="setting"
                                    autocomplete="off"
                                >
                                    @csrf
                                    @method('PATCH')

                                    {{-- Settings Form Fields --}}
                                    @include('admin.settings._partials.form')

                                    <div class="form-actions pull-right">
                                        <button type="submit" class="btn btn-info btn-rounded">
                                            <i class="fa fa-pencil"></i> Update
                                        </button>
                                    </div>
                                </form>
                                <!-- ✅ END FORM -->

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
