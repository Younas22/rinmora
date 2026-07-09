<?php if (auth()->user()->roll == 'hr') { ?>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

            <ul>
                <li class="menu-title">
                    <span>Main</span>
                </li>
                
                <li class="active">
                    <a href="{{route('hr-dashboard')}}"><i class="la la-dashboard"></i> <span>Dashboard</span></a>
                </li>
                <li class="menu-title">
                    <span>Admin</span>
                </li>
                <li>
                    <a href="{{route('profile')}}">
                        <i class="la la-user"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('employees-list.index') }}">
                        <i class="la la-user"></i>
                        <span>Employees</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('setting') }}">
                        <i class="la la-photo"></i>
                        <span>Setting</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('inv') }}">
                        <i class="la la-files-o"></i>
                        <span>INV</span>
                    </a>
                </li>

                <li class="menu-title">
                    <span>Blog</span>
                </li>
                <li>
                    <a href="{{ route('images.index') }}">
                        <i class="la la-file"></i>
                        <span>All images</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('blog.category.index') }}">
                        <i class="la la-pencil"></i>
                        <span>Blog Category</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('posts.index') }}">
                        <i class="la la-pencil"></i>
                        <span>Blog</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('postmeta.index') }}">
                        <i class="la la-file"></i>
                        <span>Post Meta</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('seo.index') }}">
                        <i class="la la-file"></i>
                        <span>Post SEO</span>
                    </a>
                </li>

                <li class="menu-title">
                    <span>Products</span>
                </li>
                <li>
                    <a href="{{route('products.index')}}">
                        <i class="la la-building-o"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('product-details.index')}}">
                        <i class="la la-building-o"></i>
                        <span>Products details</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('all-orders.index') }}">
                        <i class="la la-cart-plus"></i>
                        <span>Manage Products</span>
                    </a>
                </li>


                <li class="menu-title">
                    <span>Service</span>
                </li>
                <li>
                    <a href="{{route('services')}}">
                        <i class="la la-wrench"></i>
                        <span>Service</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('all-quote') }}">
                        <i class="la la-cart-plus"></i>
                        <span>Manage Service</span>
                    </a>
                </li>

                <li class="menu-title">
                    <span>Help</span>
                </li>
                <li>
                    <a href="{{route('help')}}">
                        <i class="la la-support"></i>
                        <span>Help</span>
                    </a>
                </li>
            </ul>



        </div>
    </div>
</div>
<!-- /Sidebar -->






<?php }if (auth()->user()->roll == 'user') { ?>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="active">
                    <a href="{{route('employee-dashboard')}}"><i class="la la-dashboard"></i> <span>Dashboard</span></a>
                </li>
                <li class="menu-title">
                    <span>Customer</span>
                </li>
                <li>
                    <a href="{{route('profile')}}">
                        <i class="la la-user"></i>
                        <span>Profile</span>
                    </a>
                </li>

                <li class="menu-title">
                    <span>Products</span>
                </li>
                <li>
                    <a href="{{route('products.index')}}">
                        <i class="la la-building-o"></i>
                        <span>Products</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('all-orders.index') }}">
                        <i class="la la-cart-plus"></i>
                        <span>Track Your Orders</span>
                    </a>
                </li>


                <li class="menu-title">
                    <span>Service</span>
                </li>
                <li>
                    <a href="{{route('services')}}">
                        <i class="la la-wrench"></i>
                        <span>Service</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('all-quote') }}">
                        <i class="la la-cart-plus"></i>
                        <span>Track Your Quotes</span>
                    </a>
                </li>


                <li class="menu-title">
                    <span>Help</span>
                </li>
                <li>
                    <a href="{{route('help')}}">
                        <i class="la la-support"></i>
                        <span>Help</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
<?php } ?>