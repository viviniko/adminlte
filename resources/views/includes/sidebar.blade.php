<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ $user->avatar or asset('assets/images/avatar.png') }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{ $user->name }}</p>
                <!-- Status -->
                <a href="#">{{ $user->email }}</a>
            </div>
        </div>

        <!-- search form (Optional)
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        @if (Menu::has('main'))
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">{{ Menu::build('main')->options('header') }}</li>
                @include('includes.sidebar-menu', array('items' => Menu::build('main')->roots()))
            </ul>
        @endif
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
