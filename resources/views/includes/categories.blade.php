<div class="grid g-col6 grid-items">
    <?php
    if (isset($_SESSION['AuthedUser'])){
    if ($_SESSION['AuthedUser']['role'] == 'Администратор'){ ?>
    <div class="grid-item item-new">
        <img src="/images/new.png">
    </div>
    <script>
        $(document).ready(function () {
            $('.item-new').click(function(e){
                $('#new-item-popup').removeClass('d-none');
                $('#new-item-popup').addClass('d-block');
            });
        });
    </script>

    <div class="popup-wrapper d-none" id="new-item-popup">
        <div class="popup popup-big">
            <h2>Добавить новую категорию</h2>
            <form action="{{ route('add-category') }}" method="post">
                <p><b>Название:</b></p>
                <input class="d-block" type="text">
                <input class="d-block" type="submit" value="Добавить">
            </form>
            <button>Отменить</button>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#new-item-popup button').click(function(e){
                $('#new-item-popup').removeClass('d-block');
                $('#new-item-popup').addClass('d-none');
            });
        });
    </script>
    <?php
    }
    }

    $cats = \App\Models\categories::all();
    foreach ($cats as $cat){
        echo '<div>';
        var_dump($cat);
        echo '</div>';
    }
    ?>
</div>
