@section('footer')
<footer>
    <div class="grid g-col6">
        <div>
            <p><b>Связь с нами в Челябинске</b></p>
            <p><span class="micon tel">&nbsp;</span>+7 (351) 751-40-12 - Оборудование для АЗС, нефтебаз, маслосменное;</p>
            <p><span class="micon tel">&nbsp;</span>+7 (351) 750-18-86 - Оборудование для автосервиса;</p>
            <p><span class="micon hour">&nbsp;</span>Режим работы:<br>ПН-ПТ с 09:00 до 20:00</p>
            <p><span class="micon email">&nbsp;</span>sale@ankas.ru</p>
        </div>
        <div>
            <p><b>Аккаунт</b></p>
            <?php
            if (!isset($_SESSION['AuthedUser'])){ ?>
                <p><a href="{{ route('signin') }}">Войти</a></p>
                <p><a href="{{ route('signup') }}">Зарегистрироваться</a></p> <?php
            } else { ?>
                <p><a href="{{ route('signdown') }}">Выйти</a></p> <?php
            } ?>
        </div>
        <div class="mobile-hidden">
            <p><b>Получение и оплата</b></p>
            <p>Самовывоз</p>
            <p>Доставка транспортной компанией</p>
            <p>Доставка курьером</p>
            <p>Способы оплаты</p>
        </div>
        <div class="mobile-hidden">
            <p><b>Сервис и поддержка</b></p>
            <p>Оставить обращение</p>
            <p>Обмен и возврат</p>
            <p>Статус заказа</p>
        </div>
        <div class="mobile-hidden">
            <p><b>Оформление заказов</b></p>
            <p>Работа с организациями</p>
            <p>Работа с частными клиентами</p>
            <p>Как сделать заказ</p>
            <p>Выставить счёт на оплату онлайн</p>
        </div>
        <div class="mobile-hidden">
            <p><b>Информация</b></p>
            <p>Пользовательское соглашение</p>
            <p>Информация о товарах на сайте</p>
            <p>Участие в тендерах</p>
            <p>Для поставщиков</p>
            <p><b>Компания</b></p>
            <p>О компании</p>
            <p>Контакты</p>
            <p>Вакансии</p>
            <p>Реквизиты</p>
        </div>
    </div>
    <div class="b-footer__infoSocial">
        <div class="b-footer__icon">
            <img src="/images/g-pay.svg" alt="Google Pay" class="b-footer__card" style="width: 35px; height: 25px;">
            <img src="/images/apple-pay.svg" alt="Google Pay" class="b-footer__card" style="width: 35px; height: 25px;">
            <img src="/images/Mastercard-logo.svg" alt="Mastercard" class="b-footer__card" style="width: 35px;">
            <img src="/images/Visa_Inc._logo.svg" alt="Visa_Inc" class="b-footer__card" style="width: 35px; height: 25px;">
            <img src="/images/mir-logo-h14px.svg" alt="Mir" class="b-footer__card" style="width: 40px; height: 25px;">
        </div>
        <a href="https://market.yandex.ru/shop/346604/reviews" target="_blank" rel="noopener noreferrer" class="b-footer__market">Оставить отзыв о компании</a>
        <div class="b-footer__social b-social">
            <a target="_blank" rel="noopener noreferrer" href="https://www.youtube.com/channel/UCQwr68VnnTJzpG7cLAoptmw" title="YouTube" class="b-social__item b-social__item_type_yt yt"><img src="/images/yt.png" class="social_icon"></a>
            <a target="_blank" rel="noopener noreferrer" href="https://vk.com/ankas_ru" title="ВКонтакте" class="b-social__item b-social__item_type_vk vk"><img src="/images/vk.png" class="social_icon"></a>
            <a target="_blank" rel="noopener noreferrer" href="https://www.instagram.com/ankas.ru/?hl=ru" title="Инстаграм" class="b-social__item b-social__item_type_inst"><img src="/images/inst.png" class="social_icon"></a>
            <a target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/ankas.ru/" title="Facebook" class="b-social__item b-social__item_type_fb fb"><img src="/images/fb.png" class="social_icon"></a>
        </div>
        <div class="b-footer__copyright b-seo-text__content">
            Продолжая использовать наш сайт, вы даете согласие на обработку файлов Cookies и других данных, в соответствии с <a href="/privacy-policy">Политикой конфиденциальности</a> и <a href="/agreement">Пользовательским соглашением</a>.<br>
            Вся информация на сайте – собственность ankas.ru. Публикация любой информации с сайта ankas.ru без разрешения запрещена. <br>
            Информация на сайте ankas.ru не является публичной офертой.<br>
        </div>
        <div class="b-footer__copy">© Компания "Анкас", 2013-2020. Все права защищены.</div>
    </div>
    @show
</footer>

<?php
if (isset($_SESSION['message'])){
    $m = $_SESSION['message'];
    unset($_SESSION['message']);?>
    <script>
        $(document).ready(function(){
            $(document.body).append('<div class="popup-wrapper"><div class="popup <?php echo $m['type']; ?>"><p><?php echo $m['text']; ?></p><button>OK</button></div></div>');
            $('.popup-wrapper > .popup > button').click(function(e){
                $('.popup-wrapper').remove();
            });
        });
    </script><?php
}
?>

