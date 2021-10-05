@extends('layouts.public')

@section('head')
    @parent
    <style>
        input:invalid {
            background-color: rgba(220,53,69,0.1);
        }
        .tabs_wrapper { display: flex; flex-direction: column; background-color: #00975e; border: 1px solid gray; }
        .tabs_header {
            display: flex; flex-direction: row;
            z-index: 2;
            border-bottom: 1px solid gray;
        }
        .tab_header {
            border: 1px solid gray;
            background-color: white;
            margin: 0.5rem 0 -2px 0.5rem;
            padding: 0.5rem;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            cursor: pointer;
            z-index: 1;
        }
        .tab_header.selected_tab {
            border-bottom: none;
            z-index: 3;
        }
        .tabs { border-top: 1px solid gray; }
        .tabs, .tab { width: 100%; background-color: white; z-index: 1; }
        .tab { padding: 0.5rem; }
    </style>
@endsection

@section('head-title')
    Личный кабинет - Ankas
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="b-white p-1">
        <h2 class="page_header">Личный кабинет</h2>
    </div>
    <div class="b-white p-3">
        <div class="tabs_wrapper">
            <div class="tabs_header">
                <div class="tab_header selected_tab" data-tab="personal">Личные данные</div>
                <div class="tab_header" data-tab="orders">История заказов</div>
            </div>
            <div class="tabs">
                <div class="tab" data-tab="personal">
                    <form action="/account/data/change" method="post" enctype="multipart/form-data" id="form_personal_data">
                        @csrf
                        <input type="hidden" name="pass">
                        <p><b>Аккаунт:</b> <input type="email" class="form-control" value="{{ $user->email }}" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required name="email"></p>
                        <p><b>Номер телефона:</b> <input type="tel" class="form-control" value="{{ $user->phone }}" pattern="^((8|\+(\d{1,5}))[\- ]?)?(\(?\d{3,4}\)?[\- ]?)?[\d\- ]{5,10}$" required minlength="7" maxlength="22" name="phone"></p>
                        <table><tbody>
                            <tr>
                                <th>Фамилия</th>
                                <th>Имя</th>
                                <th>Отчество</th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="last_name" value="{{ $user->last_name }}" required class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="first_name" value="{{ $user->first_name }}" required class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="third_name" value="{{ $user->third_name }}" class="form-control">
                                </td>
                            </tr>
                        </tbody></table>
                    </form>
                    <p>Зарегистрирован {{ $user->created_at }}</p>
                    <button class="btn btn-outline-primary btn-save-changes">Сохранить изменения</button>
                    <button class="btn btn-outline-danger btn-password-change">Изменить пароль</button>
                </div>
                <div class="tab" data-tab="orders">
                    <div class="grid grid-items g-col4 p-1">
                        @foreach (\App\Models\orders::orderBy('updated_at', 'desc')->get() as $order)
                            @if($order->email == $user->email)
                                <div class="b-white border">
                                    <a href="/orders/{{ $order->id }}">
                                        <span><b>Сумма: </b>{{ $order->sum() }}</span><br>
                                        <span><b>Заказан: </b>{{ $order->updated_at }}</span><br>
                                        <span><b>Статус: <i>{{ $order->status()->first()->name }}</i></b></span><br>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                        @if(count(\App\Models\orders::where('email', '=', $user->email)->get()) == 0)
                            <b>Вы не осуществляли заказов</b>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @parent
    <div class="modal" tabindex="-1" role="dialog" id="password_change_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Изменение пароля</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/account/password/change" method="post" enctype="multipart/form-data">
                        @csrf
                        <p>Старый пароль</p>
                        <input type="password" required class="form-control" name="old_public_pass">
                        <input type="hidden" required class="form-control" name="old_pass">
                        <hr>
                        <p>Новый пароль</p>
                        <input type="password" required minlength="8" class="form-control" name="new_public_pass">
                        <p>Повторите пароль</p>
                        <input type="password" required minlength="8" class="form-control" name="repeat_pass">
                        <input type="hidden" required class="form-control" name="new_pass">
                        <input type="submit" class="btn btn-outline-danger mt-3" value="Изменить пароль">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="save_changes_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Изменение личных данных</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Чтобы сохранить изменения, введите пароль:</p>
                    <input type="password" required class="form-control" name="pass">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary">Подтвердить</button>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/sha256.js"></script>
    <script>
        $(document).ready(function(){
            $('.tab').css('display', 'none');
            $('.tab:nth-child(1)').css('display', 'block');
            $('.tab_header').click(function(){
                let tab = this.dataset.tab;
                $('.tab_header').removeClass('selected_tab');
                $(this).addClass('selected_tab');
                $('.tab').css('display', 'none');
                $('.tab').each(function(index, elem){
                    if (elem.dataset.tab == tab){
                        $(elem).css('display', 'block');
                    }
                });
            });

            $('.btn-password-change').click(function(){
                $('#password_change_modal').modal('show');
            });
            $('#password_change_modal form').on('submit', function (e) {
                e.preventDefault();
                let form = this;
                if ($(form).children('[name=old_public_pass]').val() != '') {
                    if ($(form).children('[name=new_public_pass]').val() == $(form).children('[name=repeat_pass]').val()) {
                        $(form).children('[name=old_pass]').val(sha256($(form).children('[name=old_public_pass]').val()));
                        $(form).children('[name=new_pass]').val(sha256($(form).children('[name=new_public_pass]').val()));
                        $(form).children('[name=new_public_pass]').val('');
                        $(form).children('[name=repeat_pass]').val('');
                        form.submit();
                    } else {
                        display_message('Изменение пароля', 'Пароли не совпадают');
                    }
                }
            });

            $('.btn-save-changes').click(function(){
                $('#save_changes_modal').modal('show');
            });
            $('#save_changes_modal .btn-primary').click(function(){
                if ($('#save_changes_modal input:invalid').length == 0){
                    $('#form_personal_data input[name=pass]').val(sha256($('#save_changes_modal input[name=pass]').val()));
                    $('#save_changes_modal').modal('hide');
                    $('#save_changes_modal input[name=pass]').val('');
                    if ($('#form_personal_data *:invalid').length == 0)
                        $('#form_personal_data').submit();
                }
            });
        });
    </script>
@endsection
