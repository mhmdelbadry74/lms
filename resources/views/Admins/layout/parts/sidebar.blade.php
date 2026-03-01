<!-- Page Sidebar Start-->
<div class="sidebar-wrapper" data-layout="stroke-svg">
  <div>
    <!-- Logo Section -->
    <div class="logo-wrapper">
      <a href="{{ route('admin.dashboard') }}">
        <img class="img-fluid" src="{{asset('assets/images/logo/logo_light.png')}}" alt="">
      </a>
      <div class="back-btn"><i class="fa fa-angle-left"></i></div>
      <div class="toggle-sidebar">
        <svg class="stroke-icon sidebar-toggle status_toggle middle">
          <use href="{{asset('assets/svg/icon-sprite.svg#toggle-icon')}}"></use>
        </svg>
        <svg class="fill-icon sidebar-toggle status_toggle middle">
          <use href="{{asset('assets/svg/icon-sprite.svg#fill-toggle-icon')}}"></use>
        </svg>
      </div>
    </div>
    
    <!-- Collapsed Logo -->
    <div class="logo-icon-wrapper">
      <a href="index.html">
        <img class="img-fluid" src="{{asset('assets/images/logo/logo-icon.png')}}" alt="">
      </a>
    </div>
    
    <!-- Main Navigation -->
    <nav class="sidebar-main">
      <div id="sidebar-menu">
        <ul class="sidebar-links" id="simple-bar">
          
          <!-- Dashboard -->
          <li>
            <a class="sidebar-link text-white sidebar-title" href="{{ route('admin.dashboard') }}">
              <i class="fa fa-tachometer-alt me-2"></i>{{__("Dashboard")}}
            </a>
          </li>
          
          <!-- User Management -->
          <li class="sidebar-main-title">
            <div><h6>{{__("User Management")}}</h6></div>
          </li>
          <li>
            <a class="sidebar-link text-white sidebar-title" href="{{ route('admin.clients.index') }}">
              <i class="fa fa-users me-2"></i>{{ __("Clients") }}
            </a>
          </li>
          
          <!-- Catalog Management -->
          <li class="sidebar-main-title">
            <div><h6>{{__("Catalog Management")}}</h6></div>
          </li>
          <li>
            <a class="sidebar-link text-white sidebar-title" href="{{ route('admin.categories.table') }}">
              <i class="fa fa-sitemap me-2"></i>{{__("Categories")}}
            </a>
          </li>
          <li>
            <a class="sidebar-link text-white sidebar-title" href="{{ route('admin.products.index') }}">
              <i class="fa fa-shopping-cart me-2"></i>{{__("Products")}}
            </a>
          </li>
          <li>
            <a class="sidebar-link text-white sidebar-title" href="{{ route('admin.attributes.index') }}">
              <i class="fa fa-check-square me-2"></i>{{ __("Attributes") }}
            </a>
          </li>
          <li>
            <a class="sidebar-link text-white sidebar-title" href="{{ route('admin.features.index') }}">
              <i class="fa fa-star me-2"></i>{{__("Features")}}
            </a>
          </li>
          <li>
            <a class="sidebar-link text-white sidebar-title" href="{{ route('admin.brand.index') }}">
              <i class="fa fa-tags me-2"></i>{{__("Brands")}}
            </a>
          </li>
          <li>
            <a class="sidebar-link text-white sidebar-title" href="{{ route('admin.collection.index') }}">
              <i class="fa fa-layer-group me-2"></i>{{__("Collections")}}
            </a>
          </li>
          
          <!-- Sales & Marketing -->
          <li class="sidebar-main-title">
            <div><h6>{{__("Sales & Marketing")}}</h6></div>
          </li>
          <li>
            <a class="sidebar-link text-white sidebar-title" href="{{ route('admin.coupons.index') }}">
              <i class="fa fa-percent me-2"></i>{{__("Discounts")}}
            </a>
          </li>
          <li>
            <a class="sidebar-link text-white sidebar-title" href="{{ route('admin.offers.index') }}">
              <i class="fa fa-bullhorn me-2"></i>{{__("Offers")}}
            </a>
          </li>
          
          <!-- Flash Sales -->
          <li class="sidebar-list">
            <a class="sidebar-link text-white sidebar-title" href="javascript:void(0)">
              <i class="fa fa-bolt me-2"></i>{{__("Flash Sales")}}
              <div class="according-menu"><i class="fa fa-angle-right"></i></div>
            </a>
            <ul class="sidebar-submenu">
              <li><a href="{{ route('admin.flash_sales.index') }}">{{__("All Flash Sales")}}</a></li>
              <li><a href="{{ route('admin.flash_sales.active') }}">{{__("Active Sales")}}</a></li>
              <li><a href="{{ route('admin.flash_sales.upcoming') }}">{{__("Upcoming Sales")}}</a></li>
              <li><a href="{{ route('admin.flash_sales.create') }}">{{__("Create Flash Sale")}}</a></li>
            </ul>
          </li>
          
          <!-- Orders & Payments -->
          <li class="sidebar-list">
            <a class="sidebar-link text-white sidebar-title" href="javascript:void(0)">
              <i class="fa fa-credit-card me-2"></i>{{__("Orders & Payments")}}
              <div class="according-menu"><i class="fa fa-angle-right"></i></div>
            </a>
            <ul class="sidebar-submenu">
              <li><a href="{{ route('admin.orders.index') }}">{{__("All Orders")}}</a></li>
              <li><a href="{{ route('admin.orders.dashboard') }}">{{__("Orders Dashboard")}}</a></li>
              <li><a href="{{ route('admin.payments.index') }}">{{__("Payment Methods")}}</a></li>
              <li><a href="{{ route('admin.payments.dashboard') }}">{{__("Payments Dashboard")}}</a></li>
              <li><a href="{{ route('admin.payments.transactions') }}">{{__("Transactions")}}</a></li>
            </ul>
          </li>
          
          <!-- Shipping -->
          <li class="sidebar-list">
            <a class="sidebar-link text-white sidebar-title" href="javascript:void(0)">
              <i class="fa fa-truck me-2"></i>{{__("Shipping")}}
              <div class="according-menu"><i class="fa fa-angle-right"></i></div>
            </a>
            <ul class="sidebar-submenu">
              <li><a href="{{ route('admin.shipping.index') }}">{{__("Shipping Methods")}}</a></li>
              <li><a href="{{ route('admin.shipping.slots') }}">{{__("Delivery Slots")}}</a></li>
              <li><a href="{{ route('admin.shipping.regions') }}">{{__("Regions & Governorates")}}</a></li>
            </ul>
          </li>
          
          <!-- System -->
          <li class="sidebar-main-title">
            <div><h6>{{__("System")}}</h6></div>
          </li>
          <li>
            <a class="sidebar-link text-white sidebar-title" href="{{ route('admin.index.table') }}">
              <i class="fa fa-user me-2"></i>{{ __("Admins") }}
            </a>
          </li>
          <li>
            <a class="sidebar-link text-white sidebar-title" href="{{ route('admin.settings.index') }}">
              <i class="fa fa-cog me-2"></i>{{__("Settings")}}
            </a>
          </li>
          
        </ul>
      </div>
      <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </nav>
  </div>
</div>
<!-- Page Sidebar Ends-->