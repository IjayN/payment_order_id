<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/favicon.png" type="image/x-icon">
    <link rel="icon" href="/favicon.png" type="image/x-icon">
    <title>Sembe Admin</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/app2.css')}}">
    <style>
        .loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #F5F8FA;
            z-index: 9998;
            text-align: center;
        }

        .plane-container {
            position: absolute;
            top: 50%;
            left: 50%;
        }
    </style>
</head>
<body class="light">
<!-- Pre loader -->
<div id="loader" class="loader">
    <div class="plane-container">
        <div class="preloader-wrapper small active">

        </div>
    </div>
</div>
<div id="app">
    <aside class="main-sidebar fixed offcanvas shadow" data-toggle='offcanvas'>
        <section class="sidebar">
            <div class="w-80px mt-3 mb-3 ml-3">
                <img src="{{asset('assets/img/basic/logo2.png')}}" alt="">
            </div>
            <div class="relative">
                <a data-toggle="collapse" href="#userSettingsCollapse" role="button" aria-expanded="false"
                   aria-controls="userSettingsCollapse"
                   class="btn-fab btn-fab-sm absolute fab-right-bottom fab-top btn-primary shadow1 ">
                    <i class="icon icon-cogs"></i>
                </a>
                <div class="user-panel p-3 light mb-2">
                    <div class="collapse multi-collapse" id="userSettingsCollapse">
                        <div class="list-group mt-3 shadow">
                            <a href="{{url('admin/profile/'.Auth::user()->id)}}"
                               class="list-group-item list-group-item-action ">
                                <i class="mr-2 icon-umbrella text-blue"></i>Profile
                            </a>
                            <a href="{{url('logout')}}" class="list-group-item list-group-item-action"><i
                                        class="mr-2 icon-security text-purple"></i>Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="sidebar-menu">
                <li class="header"><strong>MAIN NAVIGATION</strong></li>
                <li><a href="{{url('/')}}">
                        <i class="icon icon-sailing-boat-water purple-text s-18"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @if(!\Illuminate\Support\Facades\Auth::user()->production && !\Illuminate\Support\Facades\Auth::user()->accountant)
                    <li class="treeview"><a href="#"><i class="icon icon-product-hunt orange-text s-18"></i>Products
                            ( {{$admin_products}} )<i
                                    class="icon icon-angle-left s-18 pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="{{url('/admin/categories')}}"><i class="icon icon-circle-o"></i>Categories
                                    ( {{$admin_categories}} )</a>
                            </li>
                            <li><a href="{{url('products')}}"><i class="icon icon-circle-o"></i>All Products
                                    ( {{$admin_products}} )<i
                                            class="icon icon-angle-left s-18 pull-right"></i></a>
                            </li>
                            <li><a href="{{url('new-product')}}"><i class="icon icon-add"></i>Add
                                    New </a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview"><a href="#"><i class="icon icon-shopping-cart blue-text s-18"></i>Orders
                            ( {{$admin_orders}} )<i
                                    class="icon icon-angle-left s-18 pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="{{url('admin/orders')}}"><i class="icon icon-circle-o"></i>All Orders</a>
                            </li>
                            <li><a href="{{url('admin/orders/pending')}}"><i class="icon icon-add"></i>Pending Delivery
                                    ( {{$admin_orders_pending_delivery}} )</a></li>
                            <li><a href="{{url('admin/orders/delivered')}}"><i class="icon icon-add"></i>Delivered
                                    ( {{$admin_orders_delivered}} )</a></li>
                            <li><a href="{{url('admin/orders/canceled')}}"><i class="icon icon-add"></i>Canceled
                                    ( {{$admin_orders_canceled}} )</a></li>
                        </ul>
                    </li>
                    <li class="treeview"><a href="#"><i class="icon icon-users green-text s-18"></i>Users
                            ( {{$admin_users}}
                            )<i
                                    class="icon icon-angle-left s-18 pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="{{route('users')}}"><i class="icon icon-circle-o"></i>All Users </a>
                            </li>
                            <li><a href="{{url('new-user')}}"><i class="icon icon-add"></i>Add User</a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview"><a href="#"><i class="icon icon-graduation-cap pink-text s-18"></i>Jijenge
                            ( {{$admin_jijenge}}
                            )<i
                                    class="icon icon-angle-left s-18 pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="{{route('students')}}"><i class="icon icon-circle-o"></i>All Students
                                    ( {{$admin_jijenge}} )</a>
                            </li>
                            <li><a href="{{route('verified/students')}}"><i
                                            class="icon icon-check-circle green-text"></i>Verified Students
                                    ( {{$admin_verified}} )</a>
                            </li>
                            <li><a href="{{route('pending/students')}}"><i class="icon icon-info red-text"></i>Pending
                                    Verification ( {{$admin_pending_verification}} )</a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview"><a href="#"><i class="icon icon-bar-chart red-text s-18"></i>Analytics<i
                                    class="icon icon-angle-left s-18 pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="{{url('admin/analytics/sales')}}"><i class="icon icon-circle-o"></i>Sales</a>
                            </li>
                            <li><a href="{{url('admin/analytics/users')}}"><i class="icon icon-users"></i>Users</a></li>
                        </ul>
                    </li>
                    <li class="treeview"><a href="{{url('admin/system-logs')}}"><i class="icon icon-library_books"></i>System
                            Logs</a></li>
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->production || \Illuminate\Support\Facades\Auth::user()->admin && !\Illuminate\Support\Facades\Auth::user()->accountant)
                    <li class="treeview"><a href="#"><i class="icon icon-user-secret pink-text s-18"></i>Production Manager
                           <i
                                    class="icon icon-angle-left s-18 pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="{{url('daily-production')}}"><i class="icon icon-circle-o"></i>Add Daily Production
                                  </a>
                            </li>

                        </ul>
                    </li>
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->accountant ||  \Illuminate\Support\Facades\Auth::user()->admin && !\Illuminate\Support\Facades\Auth::user()->production )
                    <li class="treeview"><a href="#"><i class="icon icon-document-list pink-text s-18"></i>Accountant<i
                                    class="icon icon-angle-left s-18 pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="{{url('admin/analytics/sales')}}"><i class="icon icon-circle-o"></i>Sales</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </section>
    </aside>
    <!--Sidebar End-->
    <div class="has-sidebar-left">
        <div class="pos-f-t">
            <div class="collapse" id="navbarToggleExternalContent">
                <div class="bg-dark pt-2 pb-2 pl-4 pr-2">
                    <div class="search-bar">
                        <input class="transparent s-24 text-white b-0 font-weight-lighter w-128 height-50" type="text"
                               placeholder="start typing...">
                    </div>
                    <a href="#" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-expanded="false"
                       aria-label="Toggle navigation" class="paper-nav-toggle paper-nav-white active "><i></i></a>
                </div>
            </div>
        </div>
        <div class="sticky">
            <div class="navbar navbar-expand navbar-dark d-flex justify-content-between bd-navbar blue accent-3">
                <div class="relative">
                    <a href="#" data-toggle="push-menu" class="paper-nav-toggle pp-nav-toggle">
                        <i></i>
                    </a>
                </div>
                <!--Top Menu Start -->

            </div>
        </div>
    </div>
    <div class="page has-sidebar-left height-full">
        <header class="blue accent-3 relative nav-sticky">
            <div class="container-fluid text-white">
                <div class="row p-t-b-10 ">
                    <div class="col">
                        <h4>
                            <i class="icon-box"></i>
                            Dashboard
                        </h4>
                    </div>
                </div>
            </div>
        </header>
        @yield('content')
    </div>
    <div class="control-sidebar-bg shadow white fixed"></div>
</div>
<!--/#app -->
<script src="{{asset('assets/js/app.js')}}"></script>
</body>
</html>