<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
    <div class="container">
        <a href="{{url('/')}}" class="navbar-brand">博客</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{active_class(if_route('topics.index'))}}">
                    <a href="{{route('topics.index')}}" class="nav-link">话题</a>
                </li>
                @foreach($categorys as $cate)
                <li
                    class="nav-item {{active_class(if_route('categories.show')&&if_route_param('category',$cate->id))}}">
                    <a href="{{route('categories.show',$cate->id)}}" class="nav-link">{{$cate->name}}</a></li>
                @endforeach
            </ul>
            <ul class="navbar-nav navbar-right">
                @guest
                <li class="nav-item"><a href="{{route('login')}}" class="nav-link"><i class="fa fa-user mr-2"></i>登录</a>
                </li>
                <li class="nav-item"><a href="{{route('register')}}" class="nav-link"><i
                            class="fa fa-user-edit mr-2"></i>注册</a></li>
                @else
                <li class="nav-item">
                    <a href="{{route('topics.create')}}" class="nav-link mt-1 mr-3 font-weight-bold">
                        <i class="fa fa-plus mr-2"></i>新建帖子
                    </a>
                </li>
                <li class="nav-item notification-badge">
                    <a class="nav-link mr-3 badge pl-2 pr-2 pt-1 badge-pill badge-{{ Auth::user()->notification_count > 0 ? 'hint' : 'secondary' }} text-white"
                        href="{{ route('notifications.index') }}">
                        {{ Auth::user()->notification_count }} 通知
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{Auth::user()->avatar}}" class="img-responsive img-circle" width="30px"
                            height="30px">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('users.show',Auth::id())}}"><i
                                class="far fa-user mr-2"></i>个人中心</a>
                        <a class="dropdown-item" href="{{route('users.edit',Auth::id())}}"><i
                                class="far fa-edit mr-2"></i>编辑资料</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" id="logout" href="#">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                            </form>
                        </a>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>