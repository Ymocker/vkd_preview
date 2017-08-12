<h4>Операции</h4>
<!-- Sidebar Menu -->
<ul class="sidebar-menu nav">

	<li class="{{ active_class(if_uri(['admin/dashboard']), 'selected') }}">
		<a href="{!! url('admin/dashboard') !!}" title="Редактируемый номер">Ред. номер</a>
	</li>
	<li class="{{ active_class(if_uri(['admin/add']), 'selected') }}">
		<a href="{!! url('admin/add') !!}" title="Добавить">Новая реклама</a>
	</li>
	<li class="{{ active_class(if_uri(['admin/addtext']), 'selected') }}">
		<a href="{!! url('admin/addtext') !!}" title="Текстовый файл">Текстовый файл</a>
	</li>

	<li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Удалить рекламу <span class="caret"></span></a>

            <ul class="dropdown-menu" role="menu">
                    <li> <a href="{!! url('admin/polosa/1') !!}">с первой полосы</a></li>
                    <li><a href="{!! url('admin/polosa/2') !!}">с внутренних полос</a></li>
                    <li><a href="{!! url('admin/polosa/4') !!}">с четвертой плосы</a></li>
                    <li class="divider"></li>
                    <li><a href="{!! url('admin/polosa/0') !!}">с сайта</a></li>
            </ul>
	</li>

	<li class="{{active_class(if_uri(['admin/polosa/999']), 'selected') }}">
		<a href="{!! url('admin/polosa/999') !!}">Архив рекламы</a>
	</li>

	@if ($admData['addNewNom'])
		<li class="{{active_class(if_uri(['admin/newnumber']), 'selected') }}">
			<a href="{!! url('admin/newnumber') !!}" title="Добавить">Новый номер</a>
		</li>
	@else
		<li class="{{active_class(if_uri(['admin/delnumber']), 'selected') }}">
			<a href="{!! url('admin/delnumber') !!}" title="Удалить">Последний номер</a>
		</li>
	@endif

	<li class="{{active_class(if_uri(['admin/settings']), 'selected') }}">
		<a href="{!! url('admin/settings') !!}" title="Настройки">Настройки</a>
	</li>
	<li>
	   <hr>
	</li>
        <li class="{{active_class(if_uri(['admin/security']), 'selected') }}">
		<a href="{!! url('admin/security') !!}" title="Безопасность">Безопасность</a>
	</li>
	<li>
	   <hr>
	</li>
        <li>
		<a href="{!! url('admin/logout') !!}" title="Выход">Выход</a>
	</li>

</ul><!-- /.sidebar-menu -->