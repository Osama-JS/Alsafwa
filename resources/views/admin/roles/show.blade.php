@extends('admin.layouts.app')

@section('title', 'تفاصيل الدور')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">تفاصيل الدور: {{ $role->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">الأدوار</a></li>
                    <li class="breadcrumb-item active">تفاصيل</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">الصلاحيات الممنوحة</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($rolePermissions as $permission)
                        <div class="col-md-3">
                            <label class="badge badge-success">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-default">رجوع</a>
            </div>
        </div>
    </div>
</div>
@endsection
