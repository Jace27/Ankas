@extends('layouts.admin')

@section('head')
    @parent
    <style>
        td {
            padding: 0.25rem !important;
        }
        th[data-sortby] {
            cursor: pointer;
            white-space: nowrap;
        }
        .view {
            padding: 0.25rem;
            margin: -0.25rem;
            min-height: 30px;
            cursor: pointer;
        }
        .edit {
            padding: 0.75rem;
            cursor: pointer;
        }
        :invalid {
            background-color: rgba(220,53,69,0.1);
        }
    </style>
@endsection

@section('head-title')
    Панель управления
@endsection

@section('content')
    <h1 class="p-2">Пользователи</h1>
    <div style="overflow: auto; max-width: calc(100% - 1rem); margin-bottom: 1rem">
        <div class="b-white p-2">
            <button disabled class="btn btn-outline-danger btn-delete-selected">Удалить выбранное</button>
        </div>
        @php
        if ($mode == null) $mode = 'asc';
        $items = \App\Models\users::where('id', '>', 0);
        if ($sortby == 'role'){
        	$items = \App\Models\users::join('roles', 'role_id', '=', 'roles.id')->orderBy('roles.name', $mode)->with('role');
        }
        else
        if($sortby != null){
            $items = \App\Models\users::orderBy($sortby, $mode);
        }
        @endphp
        <table class="table table-active table-striped mb-1 fs-14" data-table="users">
            <tbody>
                <tr>
                    <th data-sortby="none"></th>
                    <th data-sortby="email">E-Mail @if($sortby == 'email') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                    <th>Пароль</th>
                    <th data-sortby="role">Роль @if($sortby == 'role') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                    <th data-sortby="last_name">Фамилия @if($sortby == 'last_name') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                    <th data-sortby="first_name">Имя @if($sortby == 'first_name') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                    <th data-sortby="third_name">Отчество @if($sortby == 'third_name') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                    <th data-sortby="phone">Телефон @if($sortby == 'phone') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                </tr>
                @php $paginator = $items->paginate(12, ['*'], 'page'); @endphp
                @foreach($paginator as $user)
                    <tr data-id="{{ $user->id }}">
                        <td><input type="checkbox"></td>
                        <td data-field="email">
                            <div class="view">{{ $user->email }}&nbsp;</div>
                            <div class="edit">
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                            </div>
                        </td>
                        <td data-field="password">
                            <button class="btn btn-outline-danger btn-reset-password">Сбросить</button>
                        </td>
                        <td data-field="role_id">
                            <div class="view">{{ $user->role()->first()->name }}&nbsp;</div>
                            <div class="edit">
                                <select name="role_id" class="form-control">
                                    @foreach(\App\Models\roles::all() as $role)
                                        <option
                                            value="{{ $role->id }}"
                                            @if($role->id == $user->role()->first()->id) selected @endif>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td data-field="last_name">
                            <div class="view">{{ $user->last_name }}&nbsp;</div>
                            <div class="edit">
                                <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}">
                            </div>
                        </td>
                        <td data-field="first_name">
                            <div class="view">{{ $user->first_name }}&nbsp;</div>
                            <div class="edit">
                                <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}">
                            </div>
                        </td>
                        <td data-field="third_name">
                            <div class="view">{{ $user->third_name }}&nbsp;</div>
                            <div class="edit">
                                <input type="text" class="form-control" name="third_name" value="{{ $user->third_name }}">
                            </div>
                        </td>
                        <td data-field="phone">
                            <div class="view">{{ $user->phone }}&nbsp;</div>
                            <div class="edit">
                                <input type="tel" class="form-control" name="phone" value="{{ $user->phone }}" pattern="^((8|\+(\d{1,5}))[\- ]?)?(\(?\d{3,4}\)?[\- ]?)?[\d\- ]{5,10}$" minlength="7" maxlength="22">
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($sortby != null)
        {{ $paginator->appends(['sortby'=>$sortby, 'mode'=>$mode])->links('vendor.pagination.bootstrap-4') }}
    @else
        {{ $paginator->links('vendor.pagination.bootstrap-4') }}
    @endif
@endsection
