<div   data-kt-menu-placement="right-start" class="menu-item py-2">
    <!--begin:Menu link-->    
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-home-2 fs-2x"></i>
        </span>
        
            <span class="menu-title"> <a class="menu-link" href="dashboard">{{ $translator("Home","Nyumbani")}} </a></span>
       
    </span>
    <!--end:Menu link--> 
</div>
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
    <!--begin:Menu link-->
    <span class="menu-link menu-center">
        <span class="menu-icon me-0">
            <i class="ki-outline ki-home-2 fs-2x"></i>
        </span>
        <span class="menu-title"> {{ $translator("Users","Watumiaji")}}</span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-dropdown px-2 py-4 w-250px mh-75 overflow-auto">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu content-->
            <div class="menu-content">
                <span class="menu-section fs-5 fw-bolder ps-1 py-1"> {{ $translator("Users","Watumiaji")}}</span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
            
            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">                
                 
                <a class="menu-link" href="/dashboard/view/create-user">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Create User</span>
                </a>
                <a class="menu-link" href="/dashboard/view/users">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">List Users</span>
                </a>
                <a class="menu-link" href="/dashboard/view/roles-user">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Roles</span>
                </a>
                <a class="menu-link" href="/dashboard/view/permissions">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">User permissions</span>
                </a>
            </div>
            <!--end:Menu sub-->
        </div>
        <!--end:Menu item-->
         
    </div>
    <!--end:Menu sub-->
</div>